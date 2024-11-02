<?php

namespace App\Repositories\Service;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\BaseAPI;
use App\Models\User;
use App\Models\UserFeed;
use App\Models\UserLink;
use App\Models\UserLinkTracker;
use App\Repositories\Service\YoutubeAPIRepositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

//
use Illuminate\Support\Facades\Log;

class YoutubeRepositories{
    /**
     * ----------------------------
     * Basic Function
     * ----------------------------
    **/

    // User Link Tracker
    public static function userLinkTracker($channelID, $userID, $initialized = null){
        $userLT = UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['users_id', '=', $userID],
            ['identifier', '=', $channelID],
        ]);

        if(isset($initialized)){
            $userLT->where([
                ['initialized', '=', $initialized],
            ]);
        }
        
        $userLTNew = $userLT->firstOrFail();

        return $userLTNew;
    }

    // User Link Tracker - Checker
    public static function userLinkTrackerChecker($channelID){
        return UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['identifier', '=', $channelID],
        ])->select('identifier')->get()->count();
    }

    // User Link Tracker - Counter
    public static function userLinkTrackerCounter($userID){
        return UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['users_id', '=', $userID],
        ])->select('identifier')->get()->count();
    }

    // User Feed
    public static function userFeed($videoID){
        $userF = UserFeed::where([
            ['identifier', '=', $videoID],
        ])->first();

        return $userF;
    }

    /**
     * ----------------------------
     * Verify
     * ----------------------------
    **/

    // Verify Channel
    public static function verifyChannel($channelID, $uniqueID, $id, $back = null){
        try{
            $checkViaChannel = Str::contains($channelID, "https://www.youtube.com/channel/");
            $checkViaHandler = Str::contains($channelID, "https://www.youtube.com/@");

            if($checkViaChannel xor $checkViaHandler){
                if($checkViaChannel == true){
                    $channelIDS = Str::of($channelID)->afterLast('/');
                }
                elseif($checkViaHandler == true){
                    $channelHandler = Str::of($channelID)->afterLast('@');

                    $scrapeChannel = YoutubeAPIRepositories::scrapeLLChannels('@' . $channelHandler);

                    if(count($scrapeChannel['items']) == 1){
                        foreach($scrapeChannel['items'] as $dataChannel);

                        $channelIDS = $dataChannel['id'];
                    }
                    else{
                        $channelIDS = null;
                    }
                }
                else{
                    $channelIDS = null;
                }

                $linkID = BaseHelper::decrypt($id);
                $userLink = UserLink::find($linkID);
                $countChannel = self::userLinkTrackerChecker($channelIDS);
                $limitChannel = self::userLinkTrackerCounter($userLink->users_id);

                if(($channelIDS !== null) && (Str::of($channelIDS)->length() == 24)){
                    if($countChannel == 0){
                        return "ABC";

                        $http = YoutubeAPIRepositories::fetchChannels($channelIDS);

                        if($http['pageInfo']['totalResults'] >= 1){
                            foreach($http['items'] AS $data);
                
                            $createNew = [
                                'users_id'      => $userLink->users_id,
                                'users_link_id' => $linkID,
                                'base_link_id'  => $userLink->base_link_id,
                                'identifier'    => $data['id'],
                                'handler'       => $data['snippet']['customUrl'],
                                'playlist'      => $data['contentDetails']['relatedPlaylists']['uploads'],
                                'trailer'       => isset($data['brandingSettings']['channel']['unsubscribedTrailer']) ? $data['brandingSettings']['channel']['unsubscribedTrailer'] : null,
                                'name'          => $data['snippet']['title'],
                                'avatar'        => self::userThumbnail($http),
                                'banner'        => isset($data['brandingSettings']['image']['bannerExternalUrl']) ? self::userBanner($http) : null,
                                'description'   => isset($data['snippet']['description']) ? $data['snippet']['description'] : null,
                                'content'       => $data['statistics']['videoCount'] ? $data['statistics']['videoCount'] : 0,
                                'view'          => $data['statistics']['viewCount'] ? $data['statistics']['viewCount'] : 0,
                                'subscriber'    => $data['statistics']['hiddenSubscriberCount'] == false ? $data['statistics']['subscriberCount'] : 0,
                                'joined'        => Carbon::parse($data['snippet']['publishedAt'])->timezone(config('app.timezone'))->toDateTimeString(),
                            ];

                            // Admin and Moderator can Directly Mark Link Tracker as Verified
                            if((auth()->user()->hasRole('Admin|Moderator'))){
                                $userLink->update([
                                    'base_decision_id' => 2,
                                ]);
                                
                                $userLink->hasOneUserLinkTracker()->create($createNew);

                                // Redirect
                                return RedirectHelper::routeBack($back, 'success', 'Channel Verification', 'verify');
                            }
                            else{
                                $checkUnique = Str::contains($data['snippet']['description'], $uniqueID);

                                if($checkUnique == true){
                                    if($limitChannel <= 1){
                                        $userLink->update([
                                            'base_decision_id' => 2,
                                        ]);

                                        $userLink->hasOneUserLinkTracker()->create($createNew);
            
                                        // Redirect
                                        return RedirectHelper::routeBack($back, 'success', 'Channel Verification', 'verify');
                                    }
                                    else{
                                        return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Because currently we only allow one YouTube tracker per creator, thus we have to cancel this verification process.', 'error');
                                    }
                                }
                                else{
                                    return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. We were able to find your channel but we did not find your unique code.', 'error');
                                }
                            }
                        }
                        else{
                            return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. And it seems we can not find your channel.', 'error');
                        }
                    }
                    else{
                        return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Because we found that this channel has been successfully verified by other users, thus we have to cancel this verification process.', 'error');
                    }
                }
                else{
                    return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. So please check again whether the link structure you submitted complies with the guidelines or not.', 'error');
                }
            }
            else{
                return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. As this link does not looks like YouTube.', 'error');
            }
        }
        catch(\Throwable $th){
            return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Something went wrong, please try again.', 'error');
        }
    }

    /**
     * ----------------------------
     * Fetch Data
     * ----------------------------
    **/

    // Fetch Initial Archive via API (Need Repeater Since it isn't Directly Chunked)
    public static function fetchArchiveViaAPI($channelID, $userID, $pageToken = null){
        try{
            $userLT = self::userLinkTracker($channelID, $userID, false);

            $errorCode = [
                'error', 'error.code', 'error.message', 'error.status'
            ];

            $userLTs = [
                'users_id'              => $userLT->users_id,
                'base_link_id'          => $userLT->base_link_id,
                'users_link_tracker_id' => $userLT->id,
            ];

            $http = YoutubeAPIRepositories::fetchPlaylistItems($userLT->playlist, $pageToken);

            if(isset($http['items'])){
                foreach($http['items'] AS $data){
                    if(isset($data['contentDetails']['videoId'])){
                        UserFeed::insertOrIgnore(
                            array_merge($userLTs, [
                                'base_status_id' => 6,
                                'identifier'     => $data['contentDetails']['videoId'],
                                'title'          => $data['snippet']['title'],
                                'concurrent'     => isset($data['liveStreamingDetails']['concurrentViewers']) ? $data['liveStreamingDetails']['concurrentViewers'] : 0,
                                'published'      => Carbon::parse($data['snippet']['publishedAt'])->timezone(config('app.timezone'))->toDateTimeString(),
                            ])
                        );
                    }
                }
            }

            foreach([$http] as $data){
                if(Arr::hasAny($data, $errorCode) == false){
                    if(
                        ((isset($http['nextPageToken'])) && (!isset($http['prevPageToken'])))
                        xor
                        ((isset($http['nextPageToken'])) && (isset($http['prevPageToken'])))
                    ){
                        self::fetchArchiveViaAPIRepeater($channelID, $userID, $http['nextPageToken']);
                    }
                    else{
                        $userLT->timestamps = false;

                        $userLT->update([
                            'initialized' => true,
                        ]);
                    }
                }
                else{
                    $nextToken = isset($http['nextPageToken']) ? $http['nextPageToken'] : $pageToken;
            
                    self::fetchArchiveViaAPIRepeater($channelID, $userID, $nextToken);
                }
            }
        }
        catch(\Throwable $th){
            // Log::error($th);
            // return $th;
        }
    }

    public static function fetchArchiveViaAPIRepeater($channelID, $userID, $pageToken){
        try{
            self::fetchArchiveViaAPI($channelID, $userID, $pageToken);
        }
        catch(\Throwable $th){
            // return $th;
        }
    }

    // Fetch Ongoing Archive via Youtube XML Feed (Need to Learn and Invest Knowledge on PubSubHubBub for XML Webhook Checker and Stop Using a Pooler Like This)
    public static function fetchArchiveViaFeed(){
        try{
            UserLinkTracker::where([
                ['base_link_id', '=', 2],
                ['initialized', '=', true],
            ])->select('id', 'identifier', 'users_id', 'base_link_id')->chunkById(100, function(Collection $chunks){
                foreach($chunks as $chunk){
                    $http = YoutubeAPIRepositories::fetchFeeds($chunk->identifier);

                    $userLTs = [
                        'users_id'              => $chunk->users_id,
                        'base_link_id'          => $chunk->base_link_id,
                        'users_link_tracker_id' => $chunk->id,
                    ];

                    if(isset($http->entry)){
                        foreach($http->entry AS $data){
                            UserFeed::insertOrIgnore(
                                array_merge($userLTs, [
                                    'base_status_id' => 6,
                                    'identifier'     => Str::afterLast($data->id, ':'),
                                    'title'          => $data->title,
                                    'published'      => Carbon::parse($data->published)->timezone(config('app.timezone'))->toDateTimeString(),
                                ])
                            );
                        }
                    }
                }
            });

        }
        catch(\Throwable $th){
            // return $th;
        }
    }

    /**
     * ----------------------------
     * Managing Data
     * ----------------------------
    **/

    // User Feed Init
    public static function userFeedInit(){
        try{
            $datas = UserFeed::where([
                ['base_link_id', '=', 2],
                ['base_status_id', '=', 6],
                ['schedule', '=', null],
                ['actual_start', '=', null],
                ['actual_end', '=', null],
                ['duration', '=', null],
            ])->select('id', 'identifier')->chunkById(50, function(Collection $chunks){
                $videoID = implode(',', ($chunks)->pluck('identifier')->toArray());

                if(($chunks) && isset($chunks) && ($chunks->count() >= 1)){
                    $http = YoutubeAPIRepositories::fetchVideos($videoID);
                    $collectionHTTP = collect($http['items']);
                    $resultHTTP = $collectionHTTP->all();
        
                    if(($resultHTTP) && isset($resultHTTP) && (count($resultHTTP) >= 1)){
                        foreach($resultHTTP as $video){
                            UserFeed::where([
                                ['identifier', '=', $video['id']],
                            ])->update([
                                'base_status_id' => self::userFeedStatus($video),
                                'thumbnail'      => self::userThumbnailMultiple($video),
                                'description'    => isset($video['snippet']['description']) ? $video['snippet']['description'] : null,
                                'concurrent'     => isset($video['liveStreamingDetails']['concurrentViewers']) ? $video['liveStreamingDetails']['concurrentViewers'] : 0,
                                'schedule'       => isset($video['liveStreamingDetails']['scheduledStartTime']) ? Carbon::parse($video['liveStreamingDetails']['scheduledStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                                'actual_start'   => isset($video['liveStreamingDetails']['actualStartTime']) ? Carbon::parse($video['liveStreamingDetails']['actualStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                                'actual_end'     => isset($video['liveStreamingDetails']['actualEndTime']) ? Carbon::parse($video['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString()  : null,
                                'duration'       => isset($video['contentDetails']['duration']) ? $video['contentDetails']['duration'] : null,
                            ]);
                        }
                    }
                }
            });
        }
        catch(\Throwable $th){
            Log::error($th);
            // return $th;
        }
    }

    // Fetch streaming status
    public static function fetchStreamStatusViaAPI(){
        $day = 3; // 3 days back + today + 3 days next. Total 7 days to load.
        $subDay = Carbon::now()->timezone(config('app.timezone'))->subDays($day)->startOfDay()->toDateTimeString();
        $addDay = Carbon::now()->timezone(config('app.timezone'))->addDays($day)->endOfDay()->toDateTimeString();

        try{
            $datas = UserFeed::where([
                ['base_link_id', '=', 2],
                ['actual_end', '=', null],
                ['duration', '=', "P0D"],
            ])->orWhere([
                ['base_link_id', '=', 2],
                ['actual_end', '=', null],
                ['duration', '!=', "P0D"],
            ])->whereIn('base_status_id', ['7', '8'])->whereNotIn('base_status_id', ['5'])->select('id', 'identifier', 'published', 'schedule')->chunkById(50, function(Collection $chunks) use($subDay, $addDay){
                $dbCollection = collect($chunks);
                $dbCollectionFilter = $dbCollection->whereBetween('published', [$subDay, $addDay])->whereBetween('schedule', [$subDay, $addDay])->pluck('identifier');
                $dbCollectionResult = $dbCollectionFilter->all();
                $videoIDFromDatabase = implode(',', ($dbCollectionResult)); // Debug ID by Hardcode: $videoIDFromDatabase = "O0xrNFFrL5U,-nQcxe2nzmI,ASDCFEGTHVX,ASDCFEGT458";

                // Only Doing a Check if Filtered `$dbCollectionResult` Returning at Least Single Record
                if(($dbCollectionResult) && isset($dbCollectionResult) && (count($dbCollectionResult) >= 1)){
                    $http = YoutubeAPIRepositories::fetchVideos($videoIDFromDatabase);
                    $httpCollection = collect($http['items']);
                    $httpCollectionResult = $httpCollection->all();

                    $httpCollectionPlucker = collect($httpCollectionResult)->pluck('id');
                    $httpCollectionPluckerResult = $httpCollectionPlucker->all();
                    $videoIDFromYoutube = implode(',', ($httpCollectionPluckerResult));

                    // We Dd Fun Update
                    foreach($httpCollectionResult as $possibleArchiveItem){
                        $userF = self::userFeed($possibleArchiveItem['id']);

                        $userF->update([
                            'base_status_id'    => self::userFeedStatus($possibleArchiveItem),
                            'concurrent'        => isset($possibleArchiveItem['liveStreamingDetails']['concurrentViewers']) ? $possibleArchiveItem['liveStreamingDetails']['concurrentViewers'] : 0,
                            'thumbnail'         => self::userThumbnailMultiple($possibleArchiveItem),
                            'title'             => $possibleArchiveItem['snippet']['title'],
                            'description'       => isset($possibleArchiveItem['snippet']['description']) ? $possibleArchiveItem['snippet']['description'] : null,
                            'actual_start'      => isset($possibleArchiveItem['liveStreamingDetails']['actualStartTime']) ? Carbon::parse($possibleArchiveItem['liveStreamingDetails']['actualStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                            'actual_end'        => isset($possibleArchiveItem['liveStreamingDetails']['actualEndTime']) ? Carbon::parse($possibleArchiveItem['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                            'duration'          => isset($possibleArchiveItem['contentDetails']['duration']) ? $possibleArchiveItem['contentDetails']['duration'] : "P0D",
                        ]);

                        if((isset($possibleArchiveItem['liveStreamingDetails']['actualEndTime'])) && (Carbon::parse($possibleArchiveItem['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString() >= $userF->belongsToUserLinkTracker()->select('updated_at')->first()->updated_at)){
                            $userF->belongsToUserLinkTracker()->update([
                                'updated_at' => Carbon::parse($possibleArchiveItem['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString(),
                            ]);
                        }
                    }

                    // Comparing Video ID from Database and Video ID from Youtube
                    $missingVideo = array_diff(
                        explode(',', $videoIDFromDatabase), explode(',', $videoIDFromYoutube)
                    );

                    // If Video is Being Unavailable Midway (Not Being Able to Changed From 'Live' to 'Archived') Then it Will Be Deleted
                    if(($missingVideo) && isset($missingVideo) && (count($missingVideo) >= 1)){
                        UserFeed::whereIn('identifier', $missingVideo)->delete();
                    }
                }
            });
        }
        catch(\Throwable $th){
            // throw $th;
        }
    }

    // Fetch Profile
    public static function fetchProfile(){
        try{
            $datas = UserLinkTracker::where([
                ['base_link_id', '=', 2],
                ['initialized', '=', true],
            ])->select('id', 'identifier')->chunkById(50, function(Collection $chunks){
                $channelID = implode(',', ($chunks)->pluck('identifier')->toArray());
                
                if(($chunks) && isset($chunks) && ($chunks->count() >= 1)){
                    $http = YoutubeAPIRepositories::fetchChannels($channelID);
                    $collectionHTTP = collect($http['items']);
                    $resultHTTP = $collectionHTTP->all();
                
                    if(($resultHTTP) && isset($resultHTTP) && (count($resultHTTP) >= 1)){
                        foreach($resultHTTP as $channel){
                            $tracker = new UserLinkTracker();
                            
                            $tracker->timestamps = false;
                            $tracker->where([
                                ['identifier', '=', $channel['id']],
                                ['base_link_id', '=', 2]
                            ])->update([
                                'handler'       => $channel['snippet']['customUrl'],
                                'playlist'      => $channel['contentDetails']['relatedPlaylists']['uploads'],
                                'trailer'       => isset($channel['brandingSettings']['channel']['unsubscribedTrailer']) ? $channel['brandingSettings']['channel']['unsubscribedTrailer'] : null,
                                'name'          => $channel['snippet']['title'],
                                'avatar'        => self::userThumbnailMultiple($channel),
                                'banner'        => isset($channel['brandingSettings']['image']['bannerExternalUrl']) ? self::userBannerMultiplle($channel) : null,
                                'description'   => isset($channel['snippet']['description']) ? $channel['snippet']['description'] : null,
                                'content'       => $channel['statistics']['videoCount'] ? $channel['statistics']['videoCount'] : 0,
                                'view'          => $channel['statistics']['viewCount'] ? $channel['statistics']['viewCount'] : 0,
                                'subscriber'    => $channel['statistics']['hiddenSubscriberCount'] == false ? $channel['statistics']['subscriberCount'] : 0,
                            ]);
                        }
                    }
                }
            });
        }
        catch(\Throwable $th){
            // return $th;
        }
    }

    /**
     * ------------------------------
     * Get & process part of the data
     * ------------------------------
    **/

    // User Feed Status
    public static function userFeedStatus($data){
        // Manage streaming content
        if(isset($data['liveStreamingDetails'])){
            // Scheduled
            if(
                ($data['snippet']['liveBroadcastContent'] == 'upcoming')
                &&
                ((isset($data['liveStreamingDetails']['scheduledStartTime']) && !isset($data['liveStreamingDetails']['actualStartTime']) && !isset($data['liveStreamingDetails']['actualEndTime']) && !isset($data['liveStreamingDetails']['concurrentViewers'])))
            ){
                return "7";
            }

            // Live
            elseif(
                ($data['snippet']['liveBroadcastContent'] == 'live')
                &&
                ((isset($data['liveStreamingDetails']['scheduledStartTime']) && isset($data['liveStreamingDetails']['actualStartTime']) && !isset($data['liveStreamingDetails']['actualEndTime']) && isset($data['liveStreamingDetails']['concurrentViewers']))
                ||
                (!isset($data['liveStreamingDetails']['scheduledStartTime']) && isset($data['liveStreamingDetails']['actualStartTime']) && !isset($data['liveStreamingDetails']['actualEndTime']) && isset($data['liveStreamingDetails']['concurrentViewers'])))
            ){
                return "8";
            }

            // Archive
            elseif(
                ($data['snippet']['liveBroadcastContent'] == 'none')
                &&
                ((isset($data['liveStreamingDetails']['scheduledStartTime']) && isset($data['liveStreamingDetails']['actualStartTime']) && isset($data['liveStreamingDetails']['actualEndTime']) && !isset($data['liveStreamingDetails']['concurrentViewers']))
                ||
                (!isset($data['liveStreamingDetails']['scheduledStartTime']) && isset($data['liveStreamingDetails']['actualStartTime']) && isset($data['liveStreamingDetails']['actualEndTime']) && !isset($data['liveStreamingDetails']['concurrentViewers'])))
            ){
                return "9";
            }

            // Default Stream/Upload from Youtube
            elseif(
                ($data['snippet']['liveBroadcastContent'] =! null)
                &&
                ((!isset($data['liveStreamingDetails']['scheduledStartTime']) && !isset($data['liveStreamingDetails']['actualStartTime']) && !isset($data['liveStreamingDetails']['actualEndTime']) && !isset($data['liveStreamingDetails']['concurrentViewers'])))
            ){
                return "5";
            }

            // Unknown Streaming Content
            else{
                return "6";
            }
        }

        // Manage non-streaming content
        else{
            // Direct Upload
            return "10";
        }
    }

    // User Banner
    public static function userBanner($datas){
        $channel = $datas;

        $banner = null;
        foreach($channel['items'] as $data);

        $banner = $data['brandingSettings']['image']['bannerExternalUrl'];

        return (isset($banner) && ($banner != null)) ? BaseHelper::getOnlyPath($banner, BaseHelper::analyzeDomain($banner, 'extension')) : null;
    }

    public static function userBannerMultiplle($datas){
        $banner = $datas['brandingSettings']['image']['bannerExternalUrl'];

        return (isset($banner) && ($banner != null)) ? BaseHelper::getOnlyPath($banner, BaseHelper::analyzeDomain($banner, 'extension')) : null;
    }

    // User Thumbnail
    public static function userThumbnail($datas){
        $video = $datas;

        $thumbnail = null;
        foreach($video['items'] as $data);

        $last_key = array_key_last($data['snippet']['thumbnails']);
        foreach($data['snippet']['thumbnails'] as $key => $thumbnails){
            if($key == $last_key){
                $thumbnail = $thumbnails['url'];
            }
        }

        return (isset($thumbnail) && ($thumbnail != null)) ? BaseHelper::getOnlyPath($thumbnail, BaseHelper::analyzeDomain($thumbnail, 'extension')) : null;
    }

    public static function userThumbnailMultiple($datas){
        $last_key = array_key_last($datas['snippet']['thumbnails']);
        
        foreach($datas['snippet']['thumbnails'] as $key => $thumbnails){
            if($key == $last_key){
                $thumbnail = $thumbnails['url'];
            }
        }

        return (isset($thumbnail) && ($thumbnail != null)) ? BaseHelper::getOnlyPath($thumbnail, BaseHelper::analyzeDomain($thumbnail, 'extension')) : null;
    }
}
