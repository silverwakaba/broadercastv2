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

class YoutubeRepositories{
    // Verify Channel
    public static function verifyViaChannel($channelID, $uniqueID, $id){
        try{
            //
            $apiKey = BaseAPI::where('base_link_id', '=', '2')->inRandomOrder()->first()->client_key;

            $checkChannel = Str::of($channelID)->afterLast('/');

            $params = [
                'id'    => $checkChannel,
                'key'   => $apiKey,
                'part'  => "snippet,statistics",
            ];

            $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/channels', $params);

            $httpJSON = $http->json();

            foreach($httpJSON['items'] AS $data);

            $checkUnique = Str::contains($data['snippet']['description'], $uniqueID);

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

            return "Stop debug";
            //

            $checkString = Str::contains($channelID, "https://www.youtube.com/channel/");

            if($checkString){
                $checkChannel = Str::of($channelID)->afterLast('/');

                if(Str::of($checkChannel)->length() == 24){
                    $apiKey = BaseAPI::where('base_link_id', '=', '2')->inRandomOrder()->first()->client_key;

                    $params = [
                        'id'    => $checkChannel,
                        'key'   => $apiKey,
                        'part'  => "snippet,statistics",
                    ];

                    $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/channels', $params);

                    $httpJSON = $http->json();

                    if($httpJSON['pageInfo']['totalResults'] >= 1){
                        foreach($httpJSON['items'] AS $data);

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
                            return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. We were able to find your channel but we did not find your unique code.', 'error');
                        }
                    }
                    else{
                        return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. It seems we can not find your channel.', 'error');
                    }
                }
                else{
                    return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. Please check whether the link structure you submitted complies with the guidelines.', 'error');
                }
            }
            else{
                return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. This link does not look like YouTube.', 'error');
            }
            // 
        }
        catch(\Throwable $th){}
    }

    // Fetch Profile
    public static function fetchProfile($channelID, $userID){
        try{
            $apiKey = BaseAPI::where('base_link_id', '=', '2')->inRandomOrder()->first()->client_key;

            $params = [
                'id'    => $channelID,
                'key'   => $apiKey,
                'part'  => "snippet,statistics",
            ];

            $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/channels', $params);

            $httpJSON = $http->json();

            if($httpJSON['pageInfo']['totalResults'] >= 1){
                foreach($httpJSON['items'] AS $data){
                    UserLinkTracker::where([
                        ['users_id', '=', $userID],
                        ['identifier', '=', $channelID],
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

    // Fetch Archive
    public static function fetchArchive($channelID, $userID){
        // // Via User Model - Not Used
        // $user = User::with([
        //     'belongsToManyUserLinkTracker',
        // ])->whereHas('belongsToManyUserLinkTracker', function($query) use($channelID, $userID){
        //     $query->where([
        //         ['users_link_tracker.base_link_id', '=', 2],
        //         ['users_link_tracker.users_id', '=', $userID],
        //         ['users_link_tracker.identifier', '=', $channelID],
        //     ]);
        // })->where([
        //     ['id', '=', $userID],
        // ])->first();

        // Via UserLinkTracker Model
        $userLT = UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['users_id', '=', $userID],
            ['identifier', '=', $channelID],
        ])->first();

        try{
            $http = Http::get('https://www.toptal.com/developers/feed2json/convert', [
                'url' => "https://www.youtube.com/feeds/videos.xml?channel_id=" . $channelID,
            ]);

            $httpJSON = $http->json();

            if(isset($httpJSON['items'])){
                foreach($httpJSON['items'] AS $data){
                    UserFeed::insertOrIgnore([
                        'users_id'              => $userLT->users_id,
                        'base_link_id'          => $userLT->base_link_id,
                        'users_link_tracker_id' => $userLT->id,
                        'identifier'            => Str::afterLast($data['guid'], ':'),
                        'title'                 => $data['title'],
                        'published'             => Carbon::parse($data['date_published'])->toIso8601String(),
                    ]);
                }
            }
        }
        catch(\Throwable $th){
            $apiKey = BaseAPI::where('base_link_id', '=', '2')->inRandomOrder()->first()->client_key;

            $params = [
                'key'           => $apiKey,
                'part'          => "snippet,contentDetails",
                'channelId'     => $channelID,
                'maxResults'    => 256,
            ];

            $http = Http::acceptJson()->get('https://www.googleapis.com/youtube/v3/activities', $params);

            $httpJSON = $http->json();

            if(isset($httpJSON['items'])){
                foreach($httpJSON['items'] AS $data){
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
        }
    }

    // Fetch Activity
    public static function fetchActivity($channelID, $userID){
        try{
            // Default state
            $videoID = null;
            $isOffline = true;
            $videoSchedule = null;

            $userLT = UserLinkTracker::where([
                ['base_link_id', '=', 2],
                ['users_id', '=', $userID],
                ['identifier', '=', $channelID],
            ])->first();

            $http = Http::get('https://web.scraper.workers.dev', [
                'url'       => 'www.youtube.com/channel/' . $userLT->identifier . '/live',
                'selector'  => 'title,script',
                'scrape'    => 'text',
                'spaced'    => 'true',
                'pretty'    => 'true',
            ])->json();

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

                $videoTitle = Str::betweenFirst($httpResultScript[12], '"title":"', '",');
                $videoTitleNew = $httpResultTitle == $videoTitle ? $httpResultTitle : 'Recheck';

                $videoSchedule = (int) Str::betweenFirst($httpResultScript[12], '"scheduledStartTime":"', '",'); // Cek kalo 0 artinya lagi live dan/atau gak ada next schedule

                $videoConcurrent = (int) Str::betweenFirst($httpResultScript[33], '"originalViewCount":"', '"'); // Cek kalo int berarti oke
            }

            if(
                ($isOffline == false) && (Str::length($videoID) === 11) && ($videoSchedule == null)
            ){
                // return "Live with ID '$videoID' and title '$videoTitle' and have '$videoConcurrent' concurent views.";

                $userF = UserFeed::where([
                    ['identifier', '=', $videoID],
                ])->first();

                if($userF){
                    $userF->belongsToUserLinkTracker()->update([
                        'users_feed_id' => $userF->id,
                        'streaming'     => true,
                        'concurrent'    => $videoConcurrent,
                    ]);
                }
            }
            else{
                $userF->belongsToUserLinkTracker()->update([
                    'users_feed_id' => null,
                    'streaming'     => false,
                    'concurrent'    => 0,
                ]);
            }
        }
        catch(\Throwable $th){
            return $th;
        }
    }
}
