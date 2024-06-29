<?php

namespace App\Repositories\Service;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\BaseAPI;
use App\Models\User;
use App\Models\UserFeed;
use App\Models\UserLink;
use App\Models\UserLinkTracker;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class YoutubeRepositories{
    /**
     * ---------------
     * Block Base Data
     * ---------------
    */

    // YouTube API Key
    public static function apiKey(){
        $apiKey = BaseAPI::where([
            ['base_link_id', '=', 2],
        ])->select('client_key')->inRandomOrder()->first()->client_key;

        return $apiKey;
    }

    public static function apiCall($data, $function){
        $apiKey = self::apiKey();

        $params = array_merge($data, ['key' => $apiKey]);

        $endpoint = [
            '1st' => 'https://yt.lemnoslife.com/noKey/',
            '2nd' => 'https://www.googleapis.com/youtube/v3/',
        ];

        try{
            $http = Http::acceptJson()->get(Str::of($endpoint['1st'])->append($function), $data);

            if(($http->ok() == true)){
                return $http->json();
            }
            else{
                return Http::acceptJson()->get(Str::of($endpoint['2nd'])->append($function), $params)->json();
            }
        }
        catch(\Throwable $th){
            // Should write a logs
            return Http::acceptJson()->get(Str::of($endpoint['2nd'])->append($function), $params)->json();
        }
    }

    // Live Scrapper
    public static function videoScrapper($videoID){
        try{
            $endpoint = [
                '1st' => 'https://web.scraper.workers.dev',
                '2nd' => 'https://scraper.sspn.workers.dev',
            ];

            $params = [
                'url'       => "https://www.youtube.com/watch?v=$videoID",
                'selector'  => 'title,script,body',
                'scrape'    => 'text',
                'spaced'    => 'true',
                'pretty'    => 'true',
            ];
    
            $responses = Http::pool(fn (Pool $pool) => [
                $pool->as('first')->get($endpoint['1st'], $params),
                $pool->as('second')->get($endpoint['2nd'], $params),
            ]);
    
            $http = [
                '1stP'  => $responses['first']->json(),
                '2ndP'  => $responses['second']->json(),
            ];

            // First result
            if(
                (Str::isUrl($http['1stP']['result']['title'][0]) == false)
                &&
                (Str::of($http['1stP']['result']['script'][0])->contains(['captcha']) == false)
                &&
                (Str::of($http['1stP']['result']['body'][0])->contains(['captcha']) == false)
            ){
                return $http['1stP'];
            }

            // Second result
            elseif(
                (Str::isUrl($http['2ndP']['result']['title'][0]) == false)
                &&
                (Str::of($http['2ndP']['result']['script'][0])->contains(['captcha']) == false)
                &&
                (Str::of($http['2ndP']['result']['body'][0])->contains(['captcha']) == false)
            ){
                return $http['2ndP'];
            }

            // Get another result by repooling, if both is being blocked
            else{
                return self::videoScrapperAgain($videoID);
            }
        }
        catch(\Throwable $th){}
    }

    public static function videoScrapperAgain($videoID){
        try{
            return self::videoScrapper($videoID);
        }
        catch(\Throwable $th){}
    }

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
        $userLT = UserLinkTracker::where([
            ['identifier', '=', $channelID],
        ])->first();

        if(isset($userLT)){
            return false;
        }
        else{
            return true;
        }
    }

    // User Link Tracker - Counter
    public static function userLinkTrackerCounter($userID, $initialized){
        $userLT = UserLinkTracker::where([
            ['initialized', '=', $initialized],
            ['base_link_id', '=', 2],
            ['users_id', '=', $userID],
        ])->first();

        // return $userLT->count();

        if(isset($userLT)){
            return false;
        }
        else{
            return true;
        }
    }

    // User Feed
    public static function userFeed($archiveID){
        $userF = UserFeed::where([
            ['identifier', '=', $archiveID],
        ])->first();

        return $userF;
    }

    /**
     * ------------------
     * Block Verify Start
     * ------------------
    */

    // Verify Channel
    public static function verifyChannel($channelID, $uniqueID, $id){
        try{
            $checker = self::userLinkTrackerChecker(Str::of($channelID)->afterLast('/'));

            $counter = self::userLinkTrackerCounter(auth()->user()->id, true);

            // if(($checker == true)){
            //     if(auth()->user()->hasRole('Admin|Moderator')){
                    return self::verifyChannelDirectly($channelID, $uniqueID, $id); // Bypass buat testing
            //     }
            //     else{
            //         // if($counter == false){
            //             return self::verifyChannelManually($channelID, $uniqueID, $id);
            //         // }
            //         // else{
            //         //     return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Because we only allow one YouTube tracker per creator, thus we have to cancel this verification process.', 'error');
            //         // }
            //     }
            // }
            // else{
            //     return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Because we found that this channel has been successfully verified by other users, thus we have to cancel this verification process.', 'error');
            // }
        }
        catch(\Throwable $th){
            return $th;
        }
    }

    // Verify Channel - Direct
    public static function verifyChannelDirectly($channelID, $uniqueID, $id){
        try{
            $checkString = Str::contains($channelID, "https://www.youtube.com/channel/");

            if($checkString){
                $checkChannel = Str::of($channelID)->afterLast('/');

                if(Str::of($checkChannel)->length() == 24){
                    $params = [
                        'id'    => $checkChannel,
                        'part'  => "snippet,statistics,brandingSettings,contentDetails",
                    ];

                    $http = self::apiCall($params, 'channels');

                    if($http['pageInfo']['totalResults'] >= 1){
                        $linkID = BaseHelper::decrypt($id);

                        $userLink = UserLink::find($linkID);

                        $userLink->update([
                            'base_decision_id' => 2,
                        ]);

                        foreach($http['items'] AS $data);

                        $userLink->hasOneUserLinkTracker()->create([
                            'users_id'      => auth()->user()->id,
                            'users_link_id' => $linkID,
                            'base_link_id'  => $userLink->base_link_id,
                            'identifier'    => $data['id'],
                            'playlist'      => $data['contentDetails']['relatedPlaylists']['uploads'],
                            'name'          => $data['snippet']['title'],
                            'avatar'        => Str::before($data['snippet']['thumbnails']['medium']['url'], '='),
                            'banner'        => isset($data['brandingSettings']['image']['bannerExternalUrl']) ? Str::before($data['brandingSettings']['image']['bannerExternalUrl'], '=') : null,
                            'view'          => $data['statistics']['viewCount'] ? $data['statistics']['viewCount'] : 0,
                            'subscriber'    => $data['statistics']['hiddenSubscriberCount'] == false ? $data['statistics']['subscriberCount'] : 0,
                            'joined'        => Carbon::parse($data['snippet']['publishedAt'])->timezone(config('app.timezone'))->toDateTimeString(),
                        ]);

                        return RedirectHelper::routeBack('apps.manager.link', 'success', 'Channel Verification', 'verify');
                    }
                    else{
                        return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. And it seems we can not find your channel.', 'error');
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
            return $th;
        }
    }

    // Verify Channel - Manual
    public static function verifyChannelManually($channelID, $uniqueID, $id){
        try{
            $checkString = Str::contains($channelID, "https://www.youtube.com/channel/");

            if($checkString){
                $checkChannel = Str::of($channelID)->afterLast('/');

                if(Str::of($checkChannel)->length() == 24){
                    $params = [
                        'id'    => $checkChannel,
                        'part'  => "snippet,statistics,brandingSettings,contentDetails",
                    ];
                    
                    $http = self::apiCall($params, 'channels');

                    if($http['pageInfo']['totalResults'] >= 1){
                        foreach($http['items'] AS $data);

                        $checkUnique = Str::contains($data['snippet']['description'], $uniqueID);

                        if($checkUnique == true){
                            $linkID = BaseHelper::decrypt($id);

                            $userLink = UserLink::find($linkID);

                            $userLink->update([
                                'base_decision_id' => 2,
                            ]);

                            $userLink->hasOneUserLinkTracker()->create([
                                'users_id'      => auth()->user()->id,
                                'users_link_id' => $linkID,
                                'base_link_id'  => $userLink->base_link_id,
                                'identifier'    => $data['id'],
                                'playlist'      => $data['contentDetails']['relatedPlaylists']['uploads'],
                                'name'          => $data['snippet']['title'],
                                'avatar'        => Str::before($data['snippet']['thumbnails']['medium']['url'], '='),
                                'banner'        => isset($data['brandingSettings']['image']['bannerExternalUrl']) ? Str::before($data['brandingSettings']['image']['bannerExternalUrl'], '=') : null,
                                'view'          => $data['statistics']['viewCount'] ? $data['statistics']['viewCount'] : 0,
                                'subscriber'    => $data['statistics']['hiddenSubscriberCount'] == false ? $data['statistics']['subscriberCount'] : 0,
                                'joined'        => Carbon::parse($data['snippet']['publishedAt'])->timezone(config('app.timezone'))->toDateTimeString(),
                            ]);

                            return RedirectHelper::routeBack('apps.manager.link', 'success', 'Channel Verification', 'verify');
                        }
                        else{
                            return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Like we were able to find your channel but we did not find your unique code.', 'error');
                        }
                    }
                    else{
                        return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. And it seems we can not find your channel.', 'error');
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
        catch(\Throwable $th){}
    }

    /**
     * -----------------
     * Block Fetch Start
     * -----------------
    */

    // Fetch Profile
    public static function fetchProfile($channelID, $userID){
        try{
            $params = [
                'id'    => $channelID,
                'part'  => "snippet,statistics,brandingSettings,contentDetails",
            ];

            $http = self::apiCall($params, 'channels');

            if($http['pageInfo']['totalResults'] >= 1){
                foreach($http['items'] AS $data){
                    UserLinkTracker::where([
                        ['users_id', '=', $userID],
                        ['identifier', '=', $channelID],
                        ['base_link_id', '=', 2]
                    ])->update([
                        'playlist'      => $data['contentDetails']['relatedPlaylists']['uploads'],
                        'name'          => $data['snippet']['title'],
                        'avatar'        => Str::before($data['snippet']['thumbnails']['medium']['url'], '='),
                        'banner'        => isset($data['brandingSettings']['image']['bannerExternalUrl']) ? Str::before($data['brandingSettings']['image']['bannerExternalUrl'], '=') : null,
                        'subscriber'    => $data['statistics']['hiddenSubscriberCount'] == false ? $data['statistics']['subscriberCount'] : 0,
                    ]);
                }
            }
        }
        catch(\Throwable $th){
            // return $th;
        }
    }

    // Fetch Archive Via API
    public static function fetchArchiveViaAPI($channelID, $userID, $pageToken = null){
        try{
            $userLT = self::userLinkTracker($channelID, $userID, false);

            $userLTs = [
                'users_id'              => $userLT->users_id,
                'base_link_id'          => $userLT->base_link_id,
                'users_link_tracker_id' => $userLT->id,
            ];

            $params = [
                'part'          => "snippet,contentDetails,status",
                'playlistId'    => $userLT->playlist,
                'maxResults'    => 50,
                'pageToken'     => $pageToken,
            ];

            if((!empty($pageToken))){
                $params['pageToken'] = $pageToken;
            }

            $http = self::apiCall($params, 'playlistItems');

            if(isset($http['items'])){
                foreach($http['items'] AS $data){
                    if(isset($data['contentDetails']['videoId'])){
                        UserFeed::insertOrIgnore(
                            array_merge($userLTs, [
                                'base_status_id' => 6,
                                'identifier'     => $data['contentDetails']['videoId'],
                                'title'          => $data['snippet']['title'],
                                'published'      => Carbon::parse($data['snippet']['publishedAt'])->timezone(config('app.timezone'))->toDateTimeString(),
                            ])
                        );
                    }
                }
            }

            // Next Page Token Implementation
            if(isset($http['nextPageToken'])){
                self::fetchArchiveViaAPIRepeater($channelID, $userID, $http['nextPageToken']);
            }
            else{
                $userLT->update([
                    'initialized' => true,
                ]);
            }
        }
        catch(\Throwable $th){
            return $th;
        }
    }

    public static function fetchArchiveViaAPIRepeater($channelID, $userID, $pageToken){
        try{
            self::fetchArchiveViaAPI($channelID, $userID, $pageToken);
        }
        catch(\Throwable $th){}
    }

    // Fetch Archive Via Feed
    public static function fetchArchiveViaFeed($channelID, $userID){
        try{
            $userLT = self::userLinkTracker($channelID, $userID, true);

            $userLTs = [
                'users_id'              => $userLT->users_id,
                'base_link_id'          => $userLT->base_link_id,
                'users_link_tracker_id' => $userLT->id,
            ];

            $http = BaseHelper::youtubeXMLToJson($channelID);

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
        catch(\Throwable $th){
            return $th;
        }
    }

    // Fetch Video Via Scraper
    public static function fetchVideoViaScraper($vID, $uID){
        try{
            $userF = self::userFeed($vID);

            // Default state
            $videoID = null;
            $videoIDNew = null;
            $isOffline = true;
            $videoSchedule = null;

            $http = self::videoScrapper($vID);

            /**
             * Array key reference (Patch 15 June 2024)
             * 14: Streaming status (id, title, next stream schedule)
             * 35: Streaming statistic (concurrent viewers)
            */
            $httpResultScript = $http['result']['script'];
            $httpResultTitle = Str::remove(' - YouTube', $http['result']['title'][0]);

            if(isset($httpResultScript[35]) && (Str::contains($httpResultScript[35], ['originalViewCount']) == true)){
                $isOffline = false;

                $videoID = Str::betweenFirst($httpResultScript[14], '{"liveStreamabilityRenderer":{"videoId":"', '",'); // Cek kalo ada 11 char berarti valid

                $videoTitle = Str::betweenFirst($httpResultScript[14], '"title":"', '",');
                $videoTitleNew = $httpResultTitle == $videoTitle ? $httpResultTitle : 'Recheck';

                $videoSchedule = (int) Str::betweenFirst($httpResultScript[14], '"scheduledStartTime":"', '",'); // Cek kalo 0 artinya lagi live dan/atau gak ada next schedule

                $videoConcurrent = (int) Str::betweenFirst($httpResultScript[35], '"originalViewCount":"', '"'); // Cek kalo int berarti oke
            }

            if(
                (($isOffline == false) && (Str::length($videoID) === 11) && ($videoID == $userF->identifier))
                &&
                (($videoSchedule == null) || (BaseHelper::diffInDays($userF->schedule) <= 0))
            ){
                if(isset($userF)){
                    if(
                        ($videoTitleNew !== 'Recheck')
                    ){
                        $userF->update([
                            'base_status_id' => 8,
                            'concurrent'     => $videoConcurrent,
                            'title'          => $videoTitleNew,
                        ]);

                        return "Online and updating";
                    }
                }

                return "Just online";
            }
            else{
                if($userF->base_status_id == 8){
                    $userF->update([
                        'base_status_id' => 9,
                        'concurrent'     => 0,
                    ]);

                    return "Offline and updating";
                }

                return "Just offline";
            }
        }
        catch(\Throwable $th){}
    }

    // Fetch Archive Status
    public static function fetchArchiveStatus($archiveID){
        try{
            $data = self::userFeed($archiveID);

            $videoLink = "www.youtube.com/watch?v=$archiveID";

            $http = Http::get('https://web.scraper.workers.dev', [
                'url'       => $videoLink,
                'selector'  => 'title',
                'scrape'    => 'text',
                'spaced'    => 'true',
                'pretty'    => 'true',
            ])->json();

            $notFound = "- YouTube";

            $videoTitle = $http['result']['title'][0];

            if(
                ($videoTitle == $notFound) && ($videoTitle != $data->title)
            ){
                $data->delete();
            }
        }
        catch(\Throwable $th){}
    }

    public static function fetchVideoStatus($videoID){
        $params = [
            'id'    => "$videoID",
            'part'  => "contentDetails,liveStreamingDetails,snippet,statistics,status",
        ];

        return $http = self::apiCall($params, 'videos');
    }

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
    
                $http = self::fetchVideoStatus($videoID);
    
                if($http['pageInfo']['totalResults'] >= 1){
                    foreach($http['items'] AS $data){
                        UserFeed::where([
                            ['identifier', '=', $data['id']],
                        ])->update([
                            'base_status_id' => self::userFeedStatus($data),
                            'schedule'       => isset($data['liveStreamingDetails']['scheduledStartTime']) ? Carbon::parse($data['liveStreamingDetails']['scheduledStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                            'actual_start'   => isset($data['liveStreamingDetails']['actualStartTime']) ? Carbon::parse($data['liveStreamingDetails']['actualStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                            'actual_end'     => isset($data['liveStreamingDetails']['actualEndTime']) ? Carbon::parse($data['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString()  : null,
                            'duration'       => $data['contentDetails']['duration'],
                        ]);
                    }
                }
    
                return self::userFeedInitAgain();
            }
        }
        catch(\Throwable $th){
            return $th;
        }
    }

    public static function userFeedInitAgain(){
        return self::userFeedInit();
    }

    // User feed stream archive
    public static function userFeedArchived(){
        $datas = UserFeed::where([
            ['base_link_id', '=', 2],
            ['base_status_id', '=', 9],
            ['actual_end', '=', null],
            ['duration', '=', "P0D"],
        ])->select('identifier')->take(50)->get();

        if(($datas) && isset($datas) && ($datas->count() >= 1)){
            $videoID = implode(',', ($datas)->pluck('identifier')->toArray());

            $http = self::fetchVideoStatus($videoID);

            if($http['pageInfo']['totalResults'] >= 1){
                foreach($http['items'] AS $data){
                    UserFeed::where([
                        ['identifier', '=', $data['id']],
                    ])->update([
                        'base_status_id'    => self::userFeedStatus($data),
                        'concurrent'        => isset($data['liveStreamingDetails']['concurrentViewers']) ? $data['liveStreamingDetails']['concurrentViewers'] : 0,
                        'actual_start'      => isset($data['liveStreamingDetails']['actualStartTime']) ? Carbon::parse($data['liveStreamingDetails']['actualStartTime'])->timezone(config('app.timezone'))->toDateTimeString() : null,
                        'actual_end'        => isset($data['liveStreamingDetails']['actualEndTime']) ? Carbon::parse($data['liveStreamingDetails']['actualEndTime'])->timezone(config('app.timezone'))->toDateTimeString()  : null,
                        'duration'          => isset($data['contentDetails']['duration']) ? $data['contentDetails']['duration'] : "P0D",
                    ]);
                }
            }

            return self::userFeedArchivedAgain();
        }
    }

    public static function userFeedArchivedAgain(){
        return self::userFeedArchived();
    }

    // User Feed Status
    public static function userFeedStatus($data){
        if(isset($data['liveStreamingDetails'])){
            // Scheduled Stream
            if(
                (isset($data['liveStreamingDetails']['scheduledStartTime']) && !isset($data['liveStreamingDetails']['actualStartTime']) && !isset($data['liveStreamingDetails']['actualEndTime']) && !isset($data['liveStreamingDetails']['concurrentViewers']))
            ){
                return "7";
            }

            // Live Stream
            elseif(
                (isset($data['liveStreamingDetails']['scheduledStartTime']) && isset($data['liveStreamingDetails']['actualStartTime']) && !isset($data['liveStreamingDetails']['actualEndTime']) && isset($data['liveStreamingDetails']['concurrentViewers']))
                ||
                (!isset($data['liveStreamingDetails']['scheduledStartTime']) && isset($data['liveStreamingDetails']['actualStartTime']) && !isset($data['liveStreamingDetails']['actualEndTime']) && isset($data['liveStreamingDetails']['concurrentViewers']))
            ){
                return "8";
            }

            // Archive Stream
            elseif(
                (isset($data['liveStreamingDetails']['scheduledStartTime']) && isset($data['liveStreamingDetails']['actualStartTime']) && isset($data['liveStreamingDetails']['actualEndTime']) && !isset($data['liveStreamingDetails']['concurrentViewers']))
                ||
                (!isset($data['liveStreamingDetails']['scheduledStartTime']) && isset($data['liveStreamingDetails']['actualStartTime']) && isset($data['liveStreamingDetails']['actualEndTime']) && !isset($data['liveStreamingDetails']['concurrentViewers']))
            ){
                return "9";
            }

            // Default Stream/Upload from Youtube
            elseif(
                (!isset($data['liveStreamingDetails']['scheduledStartTime']) && !isset($data['liveStreamingDetails']['actualStartTime']) && !isset($data['liveStreamingDetails']['actualEndTime']) && !isset($data['liveStreamingDetails']['concurrentViewers']))
            ){
                return "5";
            }

            // Unknown Streaming Content
            else{
                return "6";
            }
        }
        else{
            // Direct Upload
            return "10";
        }
    }
}
