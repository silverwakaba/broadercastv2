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
                        $http = YoutubeAPIRepositories::fetchChannels($channelIDS, YoutubeAPIRepositories::apiKey());

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
            // return $th;
            // redirect karena action
            return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Something went wrong, please try again.', 'error');
        }
    }

    /**
     * ----------------------------
     * Fetch Data
     * ----------------------------
    **/

    // Fetch Profile
    public static function fetchProfile($channelID, $userID){
        try{
            $http = YoutubeAPIRepositories::fetchChannels($channelIDS);

            if($http['pageInfo']['totalResults'] >= 1){
                foreach($http['items'] AS $data){
                    $tracker = new UserLinkTracker();
                    
                    $tracker->timestamps = false;
                    $tracker->where([
                        ['users_id', '=', $userID],
                        ['identifier', '=', $channelID],
                        ['base_link_id', '=', 2]
                    ])->update([
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
                    ]);
                }
            }
        }
        catch(\Throwable $th){
            // return $th;
        }
    }

    // Fetch Initial Archive via API
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

            // Hardcoded to 'AIzaSyA5-XF2wJ0RcQCiD1OIgPNDHqn1mFg1fmI' as for debugging, if already ok then use the YoutubeAPIRepositories::apiKey() instead
            $http = YoutubeAPIRepositories::fetchPlaylistItems($userLT->playlist, $pageToken, null);

            if(isset($http['items'])){
                foreach($http['items'] AS $data){
                    if(isset($data['contentDetails']['videoId'])){
                        // try{
                            UserFeed::insertOrIgnore(
                                array_merge($userLTs, [
                                    'base_status_id' => 6,
                                    'identifier'     => $data['contentDetails']['videoId'],
                                    'title'          => $data['snippet']['title'],
                                    'published'      => Carbon::parse($data['snippet']['publishedAt'])->timezone(config('app.timezone'))->toDateTimeString(),
                                ])
                            );
                        // }
                        // catch(\Throwable $th){
                        //     Log::error($th);
                        // }
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
            return Log::debug($th);
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

    // Fetch Ongoing Archive via XML Feed
    public static function fetchArchiveViaFeed($channelID, $userID){
        try{
            $userLT = self::userLinkTracker($channelID, $userID, true);

            $userLTs = [
                'users_id'              => $userLT->users_id,
                'base_link_id'          => $userLT->base_link_id,
                'users_link_tracker_id' => $userLT->id,
            ];

            $http = YoutubeAPIRepositories::fetchFeeds($channelID);

            if(isset($http['entry'])){
                foreach($http['entry'] AS $data){
                    UserFeed::insertOrIgnore(
                        array_merge($userLTs, [
                            'base_status_id' => 6,
                            'identifier'     => Str::afterLast($data['id'], ':'),
                            'title'          => $data['title'],
                            'published'      => Carbon::parse($data['published'])->timezone(config('app.timezone'))->toDateTimeString(),
                        ])
                    );
                }
            }
        }
        catch(\Throwable $th){
            // return $th;
        }
    }

    // Fetch Video via Scraper
    public static function fetchVideoViaScraper($videoID){
        try{
            $userF = self::userFeed($videoID);

            if(isset($userF)){
                $isOffline = true;

                $viaScraper = YoutubeAPIRepositories::scrapeLLVideos($videoID);
                
                foreach($viaScraper['items'] AS $data);

                // Add && ($data['snippet']['publishedAt'] == false) if the Lemnos scraper is fixed
                if(($data['contentDetails']['duration'] == 0)){
                    $isOffline = false;
                }

                if((($isOffline == false) && (BaseHelper::diffInDays($userF->schedule) <= 0))){
                    $userF->update([
                        'base_status_id'    => 8,
                        'concurrent'        => $data['statistics']['viewCount'],
                    ]);

                    // return "Online and updating";
                }
                else{
                    $viaAPI = YoutubeAPIRepositories::fetchVideos($videoID);

                    if($viaAPI['pageInfo']['totalResults'] >= 1){
                        foreach($viaAPI['items'] AS $data){
                            $userF->update([
                                'base_status_id'    => self::userFeedStatus($data),
                                'concurrent'        => isset($data['liveStreamingDetails']['concurrentViewers']) ? $data['liveStreamingDetails']['concurrentViewers'] : 0,
                                'thumbnail'         => self::userThumbnail($viaAPI),
                                'title'             => $data['snippet']['title'],
                                'description'       => isset($data['snippet']['description']) ? $data['snippet']['description'] : null,
                                'actual_start'      => isset($data['liveStreamingDetails']['actualStartTime']) ? Carbon::parse($data['liveStreamingDetails']['actualStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                                'actual_end'        => isset($data['liveStreamingDetails']['actualEndTime']) ? Carbon::parse($data['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                                'duration'          => isset($data['contentDetails']['duration']) ? $data['contentDetails']['duration'] : "P0D",
                            ]);

                            if((isset($data['liveStreamingDetails']['actualEndTime'])) && (Carbon::parse($data['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString() >= $userF->belongsToUserLinkTracker()->select('updated_at')->first()->updated_at)){
                                $userF->belongsToUserLinkTracker()->update([
                                    'updated_at' => Carbon::parse($data['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString(),
                                ]);
                            }
                        }

                        // return "Offline and updating";
                    }
                    else{
                        $userF->delete();

                        // return "Privated and deleting";
                    }

                    // return "Just offline";
                }
            }

            // return "???";
        }
        catch(\Throwable $th){
            // return $th;
        }
    }

    /**
     * ----------------------------
     * Manage Data
     * ----------------------------
    **/

    // User feed init
    public static function userFeedInit(){
        try{
            $datas = UserFeed::where([
                ['base_link_id', '=', 2],
                ['base_status_id', '=', 6],
                ['schedule', '=', null],
                ['actual_start', '=', null],
                ['actual_end', '=', null],
                ['duration', '=', null],
            ])->select('identifier')->take(50)->get();
    
            if(($datas) && isset($datas) && ($datas->count() >= 1)){
                $videoID = implode(',', ($datas)->pluck('identifier')->toArray());
    
                $http = YoutubeAPIRepositories::fetchVideos($videoID);
    
                if($http['pageInfo']['totalResults'] >= 1){
                    foreach($http['items'] AS $data){
                        UserFeed::where([
                            ['identifier', '=', $data['id']],
                        ])->update([
                            'base_status_id' => self::userFeedStatus($data),
                            'thumbnail'      => self::userThumbnail($http),
                            'description'    => isset($data['snippet']['description']) ? $data['snippet']['description'] : null,
                            'schedule'       => isset($data['liveStreamingDetails']['scheduledStartTime']) ? Carbon::parse($data['liveStreamingDetails']['scheduledStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                            'actual_start'   => isset($data['liveStreamingDetails']['actualStartTime']) ? Carbon::parse($data['liveStreamingDetails']['actualStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                            'actual_end'     => isset($data['liveStreamingDetails']['actualEndTime']) ? Carbon::parse($data['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString()  : null,
                            'duration'       => isset($data['contentDetails']['duration']) ? $data['contentDetails']['duration'] : null,
                        ]);
                    }
                }
                else{
                    UserFeed::whereIn('identifier', explode(',', $videoID))->delete();
                }
    
                return self::userFeedInitRepeater();
            }
        }
        catch(\Throwable $th){
            // return $th;
        }
    }

    public static function userFeedInitRepeater(){
        return self::userFeedInit();
    }

    // User feed live stream without metadata
    public static function userFeedLiveMissingMetadata(){
        try{
            $datas = UserFeed::where([
                ['base_link_id', '=', 2],
                ['base_status_id', '=', 8],
                ['actual_start', '=', null],
                ['duration', '=', "P0D"],
            ])->select('identifier')->take(50)->get();
    
            if(($datas) && isset($datas) && ($datas->count() >= 1)){
                $videoID = implode(',', ($datas)->pluck('identifier')->toArray());
    
                $http = YoutubeAPIRepositories::fetchVideos($videoID);
    
                if($http['pageInfo']['totalResults'] >= 1){
                    foreach($http['items'] AS $data){
                        UserFeed::where([
                            ['identifier', '=', $data['id']],
                        ])->update([
                            'base_status_id'    => self::userFeedStatus($data),
                            'thumbnail'         => self::userThumbnail($http),
                            'description'       => isset($data['snippet']['description']) ? $data['snippet']['description'] : null,
                            'concurrent'        => isset($data['liveStreamingDetails']['concurrentViewers']) ? $data['liveStreamingDetails']['concurrentViewers'] : 0,
                            'actual_start'      => isset($data['liveStreamingDetails']['actualStartTime']) ? Carbon::parse($data['liveStreamingDetails']['actualStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                            'actual_end'        => isset($data['liveStreamingDetails']['actualEndTime']) ? Carbon::parse($data['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString()  : null,
                            'duration'          => isset($data['contentDetails']['duration']) ? $data['contentDetails']['duration'] : "P0D",
                        ]);
                    }
                }
    
                return self::userFeedLiveMissingMetadataRepeater();
            }
        }
        catch(\Throwable $th){
            // return $th;
        }
    }

    public static function userFeedLiveMissingMetadataRepeater(){
        return self::userFeedLiveMissingMetadata();
    }

    // User feed init
    public static function userFeedLiveOverdue(){
        try{
            $datas = UserFeed::where([
                ['base_link_id', '=', 2],
                ['actual_start', '=', null],
                ['actual_end', '=', null],
                ['duration', '=', null],
            ])->whereNotNull('schedule')->whereDate('schedule', '<=', Carbon::now()->timezone(config('app.timezone'))->format('Y-m-d'))->whereTime('schedule', '<=', Carbon::now()->timezone(config('app.timezone'))->format('H:i:s'))->whereIn('base_status_id', ['7'])->whereNotIn('base_status_id', ['5'])->take(50)->get();
    
            if(($datas) && isset($datas) && ($datas->count() >= 1)){
                $videoID = implode(',', ($datas)->pluck('identifier')->toArray());
    
                $http = YoutubeAPIRepositories::fetchVideos($videoID);
    
                if($http['pageInfo']['totalResults'] >= 1){
                    foreach($http['items'] AS $data){
                        UserFeed::where([
                            ['identifier', '=', $data['id']],
                        ])->update([
                            'base_status_id' => self::userFeedStatus($data),
                            'thumbnail'      => self::userThumbnail($http),
                            'description'    => isset($data['snippet']['description']) ? $data['snippet']['description'] : null,
                            'schedule'       => isset($data['liveStreamingDetails']['scheduledStartTime']) ? Carbon::parse($data['liveStreamingDetails']['scheduledStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                            'actual_start'   => isset($data['liveStreamingDetails']['actualStartTime']) ? Carbon::parse($data['liveStreamingDetails']['actualStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                            'actual_end'     => isset($data['liveStreamingDetails']['actualEndTime']) ? Carbon::parse($data['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString()  : null,
                            'duration'       => isset($data['contentDetails']['duration']) ? $data['contentDetails']['duration'] : null,
                        ]);
                    }
                }
                else{
                    UserFeed::whereIn('identifier', explode(',', $videoID))->delete();
                }
    
                return self::userFeedLiveOverdueRepeater();
            }
        }
        catch(\Throwable $th){
            // return $th;
        }
    }

    public static function userFeedLiveOverdueRepeater(){
        return self::userFeedLiveOverdue();
    }

    // User feed stream archive
    public static function userFeedArchived(){
        try{
            $datas = UserFeed::where([
                ['base_link_id', '=', 2],
                ['base_status_id', '=', 9],
                ['actual_end', '=', null],
                ['duration', '=', "P0D"],
            ])->select('identifier')->take(50)->get();
    
            if(($datas) && isset($datas) && ($datas->count() >= 1)){
                $videoID = implode(',', ($datas)->pluck('identifier')->toArray());
    
                $http = YoutubeAPIRepositories::fetchVideos('video', $videoID);
    
                if($http['pageInfo']['totalResults'] >= 1){
                    foreach($http['items'] AS $data){
                        $feed = UserFeed::where('identifier', '=', $data['id'])->first();
                        
                        $feed->update([
                            'base_status_id'    => self::userFeedStatus($data),
                            'thumbnail'         => self::userThumbnail($http),
                            'description'       => isset($data['snippet']['description']) ? $data['snippet']['description'] : null,
                            'concurrent'        => isset($data['liveStreamingDetails']['concurrentViewers']) ? $data['liveStreamingDetails']['concurrentViewers'] : 0,
                            'actual_start'      => isset($data['liveStreamingDetails']['actualStartTime']) ? Carbon::parse($data['liveStreamingDetails']['actualStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                            'actual_end'        => isset($data['liveStreamingDetails']['actualEndTime']) ? Carbon::parse($data['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                            'duration'          => isset($data['contentDetails']['duration']) ? $data['contentDetails']['duration'] : "P0D",
                        ]);

                        if((isset($data['liveStreamingDetails']['actualEndTime'])) && (Carbon::parse($data['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString() >= $feed->belongsToUserLinkTracker()->select('updated_at')->first()->updated_at)){
                            $feed->belongsToUserLinkTracker()->update([
                                'updated_at' => Carbon::parse($data['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString(),
                            ]);
                        }
                    }
                }
    
                return self::userFeedArchivedRepeater();
            }
        }
        catch(\Throwable $th){
            // return $th;
        }
    }

    public static function userFeedArchivedRepeater(){
        return self::userFeedArchived();
    }

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

    // User Thumbnail
    public static function userBanner($datas){
        $channel = $datas;

        $banner = null;
        foreach($channel['items'] as $data);

        $banner = $data['brandingSettings']['image']['bannerExternalUrl'];

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
}
