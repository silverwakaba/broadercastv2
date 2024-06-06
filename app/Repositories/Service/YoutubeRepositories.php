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
        ])->inRandomOrder()->first()->client_key;

        return $apiKey;
    }

    // Live Scrapper
    public static function liveScrapper($channelID){
        try{
            $params = [
                'url'       => 'www.youtube.com/channel/' . $channelID . '/live',
                'selector'  => 'title,script,body',
                'scrape'    => 'text',
                'spaced'    => 'true',
                'pretty'    => 'true',
            ];
    
            $responses = Http::pool(fn (Pool $pool) => [
                $pool->as('first')->get('https://web.scraper.workers.dev', $params),
                $pool->as('second')->get('https://web.scraper.workers.dev', $params),
                $pool->as('third')->get('https://web.scraper.workers.dev', $params),
            ]);
    
            $http = [
                '1stP'  => $responses['first']->json(),
                '2ndP'  => $responses['second']->json(),
                '3rdP'  => $responses['third']->json(),
            ];
    
            if(
                // First
                (Str::isUrl($http['1stP']['result']['title'][0]) == false)
                &&
                (Str::of($http['1stP']['result']['script'][0])->contains(['captcha']) == false)
                &&
                (Str::of($http['1stP']['result']['body'][0])->contains(['captcha']) == false)
            ){
                // Return
                return $http['1stP'];
            }
            elseif(
                // Second
                (Str::isUrl($http['2ndP']['result']['title'][0]) == false)
                &&
                (Str::of($http['2ndP']['result']['script'][0])->contains(['captcha']) == false)
                &&
                (Str::of($http['2ndP']['result']['body'][0])->contains(['captcha']) == false)
            ){
                // Return
                return $http['2ndP'];
            }
            elseif(
                // Third
                (Str::isUrl($http['3rdP']['result']['title'][0]) == false)
                &&
                (Str::of($http['3rdP']['result']['script'][0])->contains(['captcha']) == false)
                &&
                (Str::of($http['3rdP']['result']['body'][0])->contains(['captcha']) == false)
            ){
                // Return
                return $http['3rdP'];
            }
            else{
                return self::liveScrapperAgain($channelID);
            }
        }
        catch(\Throwable $th){}
    }

    public static function liveScrapperAgain($channelID){
        try{
            return self::liveScrapper($channelID);
        }
        catch(\Throwable $th){}
    }

    // User Link Tracker
    public static function userLinkTracker($channelID, $userID, $initialized){
        $userLT = UserLinkTracker::where([
            ['initialized', '=', $initialized],
            ['base_link_id', '=', 2],
            ['users_id', '=', $userID],
            ['identifier', '=', $channelID],
        ])->firstOrFail();

        return $userLT;
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

            if(($checker == true)){
                if(auth()->user()->hasRole('Admin|Moderator')){
                    return self::verifyChannelDirectly($channelID, $uniqueID, $id);
                }
                else{
                    if($counter == false){
                        return self::verifyChannelManually($channelID, $uniqueID, $id);
                    }
                    else{
                        return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Because we only allow one YouTube tracker per creator, thus we have to cancel this verification process.', 'error');
                    }
                }
            }
            else{
                return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Because we found that this channel has been successfully verified by other users, thus we have to cancel this verification process.', 'error');
            }
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
                    $apiKey = self::apiKey();

                    $params = [
                        'id'    => $checkChannel,
                        'key'   => $apiKey,
                        'part'  => "snippet,statistics,brandingSettings",
                    ];

                    $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/channels', $params)->json();

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
                            'name'          => $data['snippet']['title'],
                            'avatar'        => $data['snippet']['thumbnails']['medium']['url'],
                            'banner'        => $data['brandingSettings']['image']['bannerExternalUrl'],
                            'view'          => $data['statistics']['viewCount'] ? $data['statistics']['viewCount'] : 0,
                            'subscriber'    => $data['statistics']['hiddenSubscriberCount'] == false ? $data['statistics']['subscriberCount'] : 0,
                            'joined'        => Carbon::parse($data['snippet']['publishedAt'])->toIso8601String(),
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
        catch(\Throwable $th){}
    }

    // Verify Channel - Manual
    public static function verifyChannelManually($channelID, $uniqueID, $id){
        try{
            $checkString = Str::contains($channelID, "https://www.youtube.com/channel/");

            if($checkString){
                $checkChannel = Str::of($channelID)->afterLast('/');

                if(Str::of($checkChannel)->length() == 24){
                    $apiKey = self::apiKey();

                    $params = [
                        'id'    => $checkChannel,
                        'key'   => $apiKey,
                        'part'  => "snippet,statistics,brandingSettings",
                    ];

                    $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/channels', $params)->json();

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
                                'name'          => $data['snippet']['title'],
                                'avatar'        => $data['snippet']['thumbnails']['medium']['url'],
                                'banner'        => $data['brandingSettings']['image']['bannerExternalUrl'],
                                'view'          => $data['statistics']['viewCount'] ? $data['statistics']['viewCount'] : 0,
                                'subscriber'    => $data['statistics']['hiddenSubscriberCount'] == false ? $data['statistics']['subscriberCount'] : 0,
                                'joined'        => Carbon::parse($data['snippet']['publishedAt'])->toIso8601String(),
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
            $apiKey = self::apiKey();

            $params = [
                'id'    => $channelID,
                'key'   => $apiKey,
                'part'  => "snippet,statistics,brandingSettings",
            ];

            return $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/channels', $params)->json();

            if($http['pageInfo']['totalResults'] >= 1){
                foreach($http['items'] AS $data){
                    UserLinkTracker::where([
                        ['users_id', '=', $userID],
                        ['identifier', '=', $channelID],
                        ['base_link_id', '=', 2]
                    ])->update([
                        'name'          => $data['snippet']['title'],
                        'avatar'        => $data['snippet']['thumbnails']['medium']['url'],
                        'subscriber'    => $data['statistics']['hiddenSubscriberCount'] == false ? $data['statistics']['subscriberCount'] : 0,
                    ]);
                }
            }
        }
        catch(\Throwable $th){}
    }

    public static function fetchArchiveViaAPI($channelID, $userID, $nextPageToken = ''){
        try{
            $userLT = self::userLinkTracker($channelID, $userID, false);

            $apiKey = self::apiKey();

            $params = [
                'key'           => $apiKey,
                'part'          => "snippet,contentDetails",
                'channelId'     => $channelID,
                'maxResults'    => 256,
                'pageToken'     => $nextPageToken,
            ];

            // Next Page Token Implementation
            if(!empty($nextPageToken)){
                $params['pageToken'] = $nextPageToken;
            }

            $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/activities', $params)->json();

            if(isset($http['items'])){
                foreach($http['items'] AS $data){
                    if(isset($data['contentDetails']['upload']['videoId'])){
                        UserFeed::insertOrIgnore([
                            'users_id'              => $userLT->users_id,
                            'base_link_id'          => $userLT->base_link_id,
                            'users_link_tracker_id' => $userLT->id,
                            'identifier'            => $data['contentDetails']['upload']['videoId'],
                            'title'                 => $data['snippet']['title'],
                            'published'             => Carbon::parse($data['snippet']['publishedAt'])->toIso8601String(),
                        ]);
                    }
                }
            }

            // Next Page Token Implementation
            if(isset($http['nextPageToken'])){
                self::fetchArchiveViaAPINextPage($channelID, $userID, $http['nextPageToken']);
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

    public static function fetchArchiveViaAPINextPage($channelID, $userID, $nextPageToken){
        try{
            self::fetchArchiveViaAPI($channelID, $userID, $nextPageToken);
        }
        catch(\Throwable $th){}
    }

    // Fetch Archive Via Feed
    public static function fetchArchiveViaFeed($channelID, $userID){
        try{
            $userLT = self::userLinkTracker($channelID, $userID, true);

            $http = BaseHelper::youtubeXMLToJson($channelID);

            if(isset($http->entry)){
                foreach($http->entry AS $data){
                    UserFeed::insertOrIgnore([
                        'users_id'              => $userLT->users_id,
                        'base_link_id'          => $userLT->base_link_id,
                        'users_link_tracker_id' => $userLT->id,
                        'identifier'            => Str::afterLast($data->id, ':'),
                        'title'                 => $data->title,
                        'published'             => Carbon::parse($data->published)->toIso8601String(),
                        'updated'               => Carbon::parse($data->updated)->toIso8601String(),
                    ]);
                }
            }
        }
        catch(\Throwable $th){}
    }

    // Fetch Activity
    public static function fetchActivityViaCrawler($channelID, $userID){
        try{
            // Default state
            $videoID = null;
            $videoIDNew = null;
            $isOffline = true;
            $videoSchedule = null;

            $userLT = self::userLinkTracker($channelID, $userID, true);

            $http = self::liveScrapper($channelID);

            $httpResultTitle = Str::remove(' - YouTube', $http['result']['title'][0]);

            /**
             * Array key reference (Patch 30 May 2024)
             * 12: Streaming status (id, title, next stream schedule)
             * 33: Streaming statistic (concurrent viewers)
            */
            $httpResultScript = $http['result']['script'];

            // Streaming statistic
            if(isset($httpResultScript[33])){
                $isOffline = false;

                $videoID = Str::betweenFirst($httpResultScript[12], '{"liveStreamabilityRenderer":{"videoId":"', '",'); // Cek kalo ada 11 char berarti valid
                $videoIDNew = Str::length($videoID) === 11 ? $videoID : "B-Bakaa~Kyun~";

                // $videoTitle = Str::betweenFirst($httpResultScript[12], '"title":"', '",');
                // $videoTitleNew = $httpResultTitle == $videoTitle ? $httpResultTitle : 'Recheck';

                $videoSchedule = (int) Str::betweenFirst($httpResultScript[12], '"scheduledStartTime":"', '",'); // Cek kalo 0 artinya lagi live dan/atau gak ada next schedule

                $videoConcurrent = (int) Str::betweenFirst($httpResultScript[33], '"originalViewCount":"', '"'); // Cek kalo int berarti oke
            }

            $userF = self::userFeed($videoIDNew);

            if(
                ($isOffline == false) && (Str::length($videoID) === 11) && ($videoSchedule == null)
            ){
                if(isset($userF)){
                    $userLT->update([
                        'users_feed_id' => $userF->id,
                        'streaming'     => true,
                        'concurrent'    => $videoConcurrent,
                    ]);
            
                    return "Online and updating";
                }
            
                return "Online";
            }
            else{
                if(isset($userLT->users_feed_id)){
                    $userLT->update([
                        'users_feed_id' => null,
                        'streaming'     => false,
                        'concurrent'    => 0,
                    ]);
                }
            
                return "Offline";
            }

        }
        catch(\Throwable $th){
            return $th;
        }
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
                ($videoTitle == $notFound)
                && ($videoTitle != $data->title)
            ){
                $data->delete();
            }
        }
        catch(\Throwable $th){}
    }

    public static function fetchVideoStatus($videoID){
        $apiKey = self::apiKey();

        $params = [
            'key'           => $apiKey, 
            'id'            => $videoID,
            'part'          => "contentDetails,liveStreamingDetails,snippet,statistics,status",
        ];

        $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/videos', $params)->json();

        return $http;
    }
}
