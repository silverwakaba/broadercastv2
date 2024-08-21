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

class TwitchRepositories{
    /*
    |------------------------------
    | Core Block
    |------------------------------
    */

    public static function errorKeyword(){
        return [
            'unusual traffic',
            'Enable JavaScript and cookies to continue',
            'Our systems have detected unusual traffic from your computer network',
        ];
    }

    /**
     * ----------------------------
     * Basic Function
     * ----------------------------
    **/

    // API Key
    public static function apiKey(){
        $datas = BaseAPI::where([
            ['base_link_id', '=', '1'],
        ])->select('client_id', 'client_secret', 'bearer')->inRandomOrder()->first();

        return $datas;
    }

    // Update Twitch Bearer Token
    public static function updateBearerToken(){
        $datas = BaseAPI::where('base_link_id', '=', '1')->select('client_id', 'client_secret', 'bearer')->get();

        foreach($datas AS $data){
            $validate = Http::acceptJson()->withHeaders([
                'Authorization' => 'Bearer ' . $data->bearer,
                'Client-Id'     => $data->client_id,
            ])->get('https://id.twitch.tv/oauth2/validate')->status();

            if($validate !== 200){
                $reauth = Http::post('https://id.twitch.tv/oauth2/token', [
                    'client_id'     => $data->client_id,
                    'client_secret' => $data->client_secret,
                    'grant_type'    => 'client_credentials',
                ])->json();

                BaseAPI::where([
                    ['base_link_id', '=', '1'],
                    ['client_id', '=', $data->client_id],
                    ['client_secret', '=', $data->client_secret],
                ])->update([
                    'bearer' => $reauth['access_token'],
                ]);
            }
        }
    }

    // User Link Tracker
    public static function userFeedLive($channelID, $userID){
        return UserFeed::where([
            ['base_link_id', '=', 1],
            ['users_link_tracker_id', '=', $channelID],
            ['base_status_id', '=', 8],
            ['users_id', '=', $userID],
        ])->get();
    }

    // User Link Tracker
    public static function userLinkTracker($channelID, $userID){
        return UserLinkTracker::where([
            ['base_link_id', '=', 1],
            ['users_id', '=', $userID],
            ['identifier', '=', $channelID],
        ])->first();
    }

    // User Link Tracker - Checker
    public static function userLinkTrackerChecker($channelID){
        return UserLinkTracker::where([
            ['base_link_id', '=', 1],
            ['identifier', '=', $channelID],
        ])->select('identifier')->get()->count();
    }

    // User Link Tracker - Counter
    public static function userLinkTrackerCounter($userID){
        return UserLinkTracker::where([
            ['base_link_id', '=', 1],
            ['users_id', '=', $userID],
        ])->select('identifier')->get()->count();
    }

    /**
     * ----------------------------
     * Verify
     * ----------------------------
    **/

    // Verify Channel
    public static function verifyChannel($channelID, $uniqueID, $id, $back = null){
        try{
            $checkViaChannel = Str::contains($channelID, "https://www.twitch.tv/");

            if($checkViaChannel){
                if($checkViaChannel == true){
                    $checkChannel = Str::of($channelID)->afterLast('/');
                }
                else{
                    $checkChannel = null;
                }

                $linkID = BaseHelper::decrypt($id);
                $userLink = UserLink::find($linkID);
                $countChannel = self::userLinkTrackerChecker($checkChannel);
                $limitChannel = self::userLinkTrackerCounter($userLink->users_id);

                if(($checkChannel !== null) && (Str::of($checkChannel)->length() <= 25)){
                    $http = self::fetchProfile($checkChannel);

                    if(count($http['data']) >= 1){
                        foreach($http['data'] AS $data);

                        $createNew = [
                            'users_id'      => $userLink->users_id,
                            'users_link_id' => $linkID,
                            'base_link_id'  => $userLink->base_link_id,
                            'identifier'    => $data['id'],
                            'handler'       => $data['login'],
                            'playlist'      => null,
                            'name'          => $data['display_name'],
                            'avatar'        => BaseHelper::getOnlyPath($data['profile_image_url'], '.net/'),
                            'banner'        => ($data['offline_image_url'] != null) ? BaseHelper::getOnlyPath($data['offline_image_url'], '.net/') : null,
                            'joined'        => Carbon::parse($data['created_at'])->timezone(config('app.timezone'))->toDateTimeString(),
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
                            $checkUnique = Str::contains($data['description'], $uniqueID);

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
                    return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. So please check again whether the link structure you submitted complies with the guidelines or not.', 'error');
                }
            }
            else{
                return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. As this link does not looks like Twitch.', 'error');
            }
        }
        catch(\Throwable $th){
            // redirect
            return $th;
        }
    }

    /**
     * ----------------------------
     * Fetch Data
     * ----------------------------
    **/

    // Fetch Profile
    public static function fetchProfile($channelID){
        /**
         * Notes
         * identifier = id
         * name = display_name
         * avatar = profile_image_url
         * banner = offline_image_url
         * view = deprecated (0)
         * content = no vod (0)
         * subscriber = self::fetchSubscriber
         * joined = created_at
        **/

        $apiKey = self::apiKey();

        if(is_integer($channelID)){
            $params = [
                'id' => $channelID,
            ];
        }
        else{
            $params = [
                'login' => $channelID,
            ];
        }

        return Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $apiKey->bearer,
            'Client-Id'     => $apiKey->client_id,
        ])->get('https://api.twitch.tv/helix/users', $params)->json();
    }

    // Fetch Subscriber
    public static function fetchSubscriber($channelID){
        /**
         * Notes
         * subscriber = total
        **/

        $apiKey = self::apiKey();

        $params = [
            // Integer, as in "715990491"
            'broadcaster_id' => $channelID,
        ];

        return Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $apiKey->bearer,
            'Client-Id'     => $apiKey->client_id,
        ])->get('https://api.twitch.tv/helix/channels/followers', $params)->json();
    }

    // Fetch Activity
    public static function fetchChannel($channelID){
        /**
         * Notes
         * -
        **/

        $apiKey = self::apiKey();

        $params = [
            // Integer, as in "715990491"
            'broadcaster_id' => $channelID,
        ];

        return Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $apiKey->bearer,
            'Client-Id'     => $apiKey->client_id,
        ])->get('https://api.twitch.tv/helix/channels', $params)->json();
    }

    // Fetch Stream via API
    public static function fetchStream($channelID){
        /**
         * Notes
         * concurrent = viewer_count
         * identifier = id
         * title = title
         * published & actual_start = started_at
         * actual_end = ?
        **/

        $apiKey = self::apiKey();

        $params = [
            'type'      => "live",
            'user_id'   => $channelID,
        ];
    
        return Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $apiKey->bearer,
            'Client-Id'     => $apiKey->client_id,
        ])->get('https://api.twitch.tv/helix/streams', $params)->json();
    }

    // Fetch Stream via API
    public static function fetchVideo($videoID = null, $channelID = null, $streamID = null){
        /**
         * Notes
         * streamID !== videoID
         * 
         * actual_end = published_at
         * duration = duration (dikasih awalan PT. Mis: 2h31m6s jadinya PT2H31M6S, uppercase)
        **/

        $apiKey = self::apiKey();

        $params = [
            'id'        => $videoID,
            'user_id'   => $channelID,
        ];
    
        $http = Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $apiKey->bearer,
            'Client-Id'     => $apiKey->client_id,
        ])->get('https://api.twitch.tv/helix/videos', $params)->json();

        if(($videoID == null) && ($streamID != null)){
            foreach($http['data'] as $datas){
                if($datas['stream_id'] == $streamID){
                    return $datas;
                }
            }
        }
        else{
            return $http;
        }
    }

    /**
     * ----------------------------
     * Manage Data
     * ----------------------------
    **/

    // Update Subscriber
    public static function updateSubscriber($channelID, $userID){
        try{
            $http = self::fetchSubscriber($channelID);

            $tracker = new UserLinkTracker();
                        
            $tracker->timestamps = false;
            $tracker->where([
                ['users_id', '=', $userID],
                ['identifier', '=', $channelID],
                ['base_link_id', '=', 1],
            ])->update([
                'subscriber' => isset($http['total']) ? $http['total'] : 0,
            ]);
        }
        catch(\Throwable $th){
            //return $th;
        }
    }

    // Fetch and Update Channel Activity, such as streaming activity
    public static function fetchChannelActivity($channelIDStr, $channelIDInt, $userID){
        try{
            $http = Http::get('https://www.twitch.tv/' . $channelIDStr)->body();

            $live = Str::betweenFirst($http, ',"isLiveBroadcast":', '}}');
            $title = Str::betweenFirst($http, '"description":"', '",');

            if((Str::of($live)->contains(['true'])) && (Str::length($title) <= 140)){
                $stream = self::fetchStream($channelIDInt);
                $tracker = self::userLinkTracker($channelIDInt, $userID);

                if(isset($stream) && count($stream['data']) >= 1){
                    foreach($stream['data'] as $data){
                        UserFeed::updateOrCreate(['identifier' => $data['id']], [
                            'users_id'              => $userID,
                            'base_link_id'          => 1,
                            'users_link_tracker_id' => $tracker->id,
                            'base_status_id'        => 8,
                            'base_feed_type_id'     => null,
                            'concurrent'            => $data['viewer_count'],
                            'identifier'            => $data['id'],
                            'thumbnail'             => null,
                            'title'                 => $data['title'],
                            'published'             => Carbon::parse($data['started_at'])->timezone(config('app.timezone'))->toDateTimeString(),
                            'schedule'              => null,
                            'actual_start'          => Carbon::parse($data['started_at'])->timezone(config('app.timezone'))->toDateTimeString(),
                            'actual_end'            => null,
                            'duration'              => "P0D",
                        ]);
                    }
                }
                else{
                    $live = self::userFeedLive($tracker->id, $tracker->users_id);

                    foreach($live as $check){
                        self::wrapChannelActivity($channelIDInt, $check->identifier);
                    }
                }
            }
            else{
                $live = self::userFeedLive($tracker->id, $tracker->users_id);

                foreach($live as $check){
                    self::wrapChannelActivity($channelIDInt, $check->identifier);
                }
            }
        }
        catch(\Throwable $th){
            //return $th;
        }
    }

    // Wrap finished streaming
    public static function wrapChannelActivity($channelID, $streamID){
        try{
            $http = self::fetchVideo(null, $channelID, $streamID);

            if(Str::contains($http['thumbnail_url'], '/_404/404_processing_%{width}x%{height}.png') == false){
                $feed = UserFeed::where('identifier', '=', $streamID)->first();

                $feed->update([
                    'base_status_id'    => 9,
                    'concurrent'        => 0,
                    'identifier'        => $http['id'],
                    'thumbnail'         => Str::replace('%{width}x%{height}', '640x480', BaseHelper::getOnlyPath($http['thumbnail_url'], '.net/')),
                    'title'             => $http['title'],
                    'duration'          => Str::of('PT')->append(Str::of($http['duration'])->upper()),
                ]);
            }
        }
        catch(\Throwable $th){
            //return $th;
        }
    }
}
