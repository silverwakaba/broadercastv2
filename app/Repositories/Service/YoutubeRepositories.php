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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

// use App\Repositories\Service\YoutubeRepositories;

class YoutubeRepositories{
    // Verify Channel - Debug
    // public static function verifyViaChannelDebug($channelID, $uniqueID, $id){
    //     try{
    //         $apiKey = BaseAPI::where('base_link_id', '=', '2')->inRandomOrder()->first()->client_key;

    //         $checkChannel = Str::of($channelID)->afterLast('/');

    //         $params = [
    //             'id'    => $checkChannel,
    //             'key'   => $apiKey,
    //             'part'  => "snippet,statistics",
    //         ];

    //         $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/channels', $params);

    //         $httpJSON = $http->json();

    //         foreach($httpJSON['items'] AS $data);

    //         $checkUnique = Str::contains($data['snippet']['description'], $uniqueID);

    //         $linkID = BaseHelper::decrypt($id);

    //         $userLink = UserLink::find($linkID);

    //         $userLink->update([
    //             'base_decision_id' => 2,
    //         ]);

    //         $userLink->hasOneUserLinkTracker()->create([
    //             'users_id'      => auth()->user()->id,
    //             'users_link_id' => $linkID,
    //             'base_link_id'  => $userLink->base_link_id,
    //             'identifier'    => $data['id'],
    //             'name'          => $data['snippet']['title'],
    //             'avatar'        => $data['snippet']['thumbnails']['medium']['url'],
    //             'view'          => $data['statistics']['viewCount'] ? $data['statistics']['viewCount'] : 0,
    //             'subscriber'    => $data['statistics']['hiddenSubscriberCount'] == false ? $data['statistics']['subscriberCount'] : 0,
    //             'joined'        => Carbon::parse($data['snippet']['publishedAt'])->toIso8601String(),
    //         ]);

    //         return RedirectHelper::routeBack('apps.manager.link', 'success', 'Channel Verification', 'verify');
    //     }
    //     catch(\Throwable $th){}
    // }

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

    // User Link Tracker
    public static function userLinkTracker($channelID, $userID){
        $userLT = UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['users_id', '=', $userID],
            ['identifier', '=', $channelID],
        ])->firstOrFail();

        return $userLT;
    }

    /**
     * ------------------
     * Block Verify Start
     * ------------------
    */

    // Verify Channel
    public static function verifyViaChannel($channelID, $uniqueID, $id){
        try{
            $checkString = Str::contains($channelID, "https://www.youtube.com/channel/");

            if($checkString){
                $checkChannel = Str::of($channelID)->afterLast('/');

                if(Str::of($checkChannel)->length() == 24){
                    $apiKey = self::apiKey();

                    $params = [
                        'id'    => $checkChannel,
                        'key'   => $apiKey,
                        'part'  => "snippet,statistics",
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
                'part'  => "snippet,statistics",
            ];

            $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/channels', $params)->json();

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

    // Fetch Archive Via Feed
    public static function fetchArchiveViaFeed($channelID, $userID){
        try{
            $userLT = self::userLinkTracker($channelID, $userID);

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
                    ]);
                }
            }
        }
        catch(\Throwable $th){}
    }

    public static function fetchArchiveViaAPI($channelID, $userID, $nextPageToken = ''){
        try{
            $userLT = self::userLinkTracker($channelID, $userID);

            $apiKey = self::apiKey();

            $params = [
                'key'           => $apiKey,
                'part'          => "snippet,contentDetails",
                'channelId'     => $channelID,
                'maxResults'    => 256,
                // 'pageToken'     => $nextPageToken,
            ];

            // // Next Page Token Implementation
            // if(!empty($nextPageToken)){
            //     $params['pageToken'] = $nextPageToken;
            // }

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

            // // Next Page Token Implementation
            // if(isset($http['nextPageToken'])){
            //     $this->initYoutube($channelID, $userID, $http['nextPageToken']);
            // }
        }
        catch(\Throwable $th){}
    }

    // Fetch Archive Status
    public static function fetchArchiveStatus($archiveID){
        try{
            $data = UserFeed::where([
                ['identifier', '=', $archiveID],
            ])->firstOrFail();

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

    // Fetch Activity
    public static function fetchActivity($channelID, $userID){
        try{
            // Default state
            $videoID = null;
            $isOffline = true;
            $videoSchedule = null;

            $userLT = self::userLinkTracker($channelID, $userID);

            // Endpoint Alt: https://web.sspn.workers.dev
            $http = Http::get('https://web.scraper.workers.dev', [
                'url'       => 'www.youtube.com/channel/' . $channelID . '/live',
                'selector'  => 'title,script',
                'scrape'    => 'text',
                'spaced'    => 'true',
                'pretty'    => 'true',
            ])->json();

            // $httpResultTitle = Str::remove(' - YouTube', $http['result']['title'][0]);

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

            $userF = $userLT->hasManyUserFeed()->where([
                ['identifier', '=', $videoIDNew],
            ])->first();

            if(
                ($isOffline == false) && (Str::length($videoID) === 11) && ($videoSchedule == null)
            ){
                if(isset($userF)){
                    $userLT->update([
                        'users_feed_id' => $userF->id,
                        'streaming'     => true,
                        'concurrent'    => $videoConcurrent,
                    ]);
                }
            }
            else{
                $userLT->update([
                    'users_feed_id' => null,
                    'streaming'     => false,
                    'concurrent'    => 0,
                ]);
            }
        }
        catch(\Throwable $th){}
    }
}
