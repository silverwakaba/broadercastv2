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
use Illuminate\Support\Arr;
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

    public static function apiCall($mode, $insertParams){
        $apiKey = self::apiKey();

        $apiParams = [
            'client_id' => $apiKey->client_id,
            'bearer'    => $apiKey->bearer,
        ];

        if(($mode == 'validate-token')){
            return Http::acceptJson()->get('https://www.silverspoon.me/api/twitch/validate-token', [
                'client_secret' => $insertParams['client_secret'],
                'bearer'        => $insertParams['bearer'],
            ])->json();
        }
        elseif(($mode == 'create-token')){
            return Http::acceptJson()->get('https://www.silverspoon.me/api/twitch/create-token', [
                'client_id'     => $insertParams['client_id'],
                'client_secret' => $insertParams['client_secret'],
            ])->json();
        }
        elseif(($mode == 'profile')){
            return Http::acceptJson()->get('https://www.silverspoon.me/api/twitch/fetch-profile', array_merge($apiParams, [
                'id'    => isset($insertParams['id']) ? $insertParams['id'] : null,
                'login' => isset($insertParams['login']) ? $insertParams['login'] : null,
            ]))->json();
        }
        elseif(($mode == 'channel')){
            return Http::acceptJson()->get('https://www.silverspoon.me/api/twitch/fetch-channel', array_merge($apiParams, [
                'id' => $insertParams['id'],
            ]))->json();
        }
        elseif(($mode == 'subscriber')){
            return Http::acceptJson()->get('https://www.silverspoon.me/api/twitch/fetch-subscriber', array_merge($apiParams, [
                'id' => $insertParams['id'],
            ]))->json();
        }
        elseif(($mode == 'stream')){
            return Http::acceptJson()->get('https://www.silverspoon.me/api/twitch/fetch-stream', array_merge($apiParams, [
                'id' => $insertParams['id'],
            ]))->json();
        }
        elseif(($mode == 'video')){
            return Http::acceptJson()->get('https://www.silverspoon.me/api/twitch/fetch-video', array_merge($apiParams, [
                'user_id'   => isset($insertParams['user_id']) ? $insertParams['user_id'] : null,
                'video_id'  => isset($insertParams['video_id']) ? $insertParams['video_id'] : null,
                'stream_id' => isset($insertParams['stream_id']) ? $insertParams['stream_id'] : null,
            ]))->json();
        }
    }

    // Update Twitch Bearer Token
    public static function updateBearerToken(){
        $datas = BaseAPI::where('base_link_id', '=', '1')->select('client_id', 'client_secret', 'bearer')->get();

        foreach($datas AS $data){
            $validate = self::apiCall('validate-token', [
                'client_secret' => $data->client_secret,
                'bearer'        => $data->bearer,
            ]);

            if($validate['status'] !== 200){
                $reauth = TwitchRepositories::apiCall('create-token', [
                    'client_id'     => $data->client_id,
                    'client_secret' => $data->client_secret,
                ]);

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
                    $channeru = (string) $checkChannel;
                    $http = self::fetchProfile($channeru);

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
        if(is_string($channelID)){
            $params = [
                'login' => $channelID,
            ];
        }
        else{
            $params = [
                'id' => $channelID,
            ];
        }

        return self::apiCall('profile', $params);
    }

    // Fetch Subscriber
    public static function fetchSubscriber($channelID){
        return self::apiCall('subscriber', [
            'id' => $channelID,
        ]);
    }

    // Fetch Activity
    public static function fetchChannel($channelID){
        return TwitchRepositories::apiCall('channel', [
            'id' => $channelID,
        ]);
    }

    // Fetch Stream via API
    public static function fetchStream($channelID){
        return TwitchRepositories::apiCall('stream', [
            'id' => $channelID,
        ]);
    }

    // Fetch Stream via API
    public static function fetchVideo($videoID = null, $channelID = null, $streamID = null){
        return TwitchRepositories::apiCall('video', [
            'user_id'   => $channelID,
            'video_id'  => $videoID,
            'stream_id' => $streamID,
        ]);
    }

    /**
     * ----------------------------
     * Manage Data
     * ----------------------------
    **/

    public static function updateProfile($channelID, $userID){
        try{
            $http = self::fetchProfile($channelID);

            foreach($http['data'] as $data){
                $tracker = new UserLinkTracker();
                
                $tracker->timestamps = false;
                $tracker->where([
                    ['users_id', '=', $userID],
                    ['identifier', '=', $channelID],
                    ['base_link_id', '=', 1],
                ])->update([
                    'name'      => $data['display_name'],
                    'handler'   => $data['login'],
                    'name'      => $data['display_name'],
                    'avatar'    => BaseHelper::getOnlyPath($data['profile_image_url'], '.net/'),
                    'banner'    => ($data['offline_image_url'] != null) ? BaseHelper::getOnlyPath($data['offline_image_url'], '.net/') : null,
                ]);
            }
        }
        catch(\Throwable $th){
            //return $th;
        }
    }

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
                'initialized'   => true,
                'subscriber'    => isset($http['total']) ? $http['total'] : 0,
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
            $tracker = self::userLinkTracker($channelIDInt, $userID);

            if((Str::of($live)->contains(['true'])) && (Str::length($title) <= 140)){
                $stream = self::fetchStream($channelIDInt);

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
            // return $th;
        }
    }

    // Wrap finished streaming
    public static function wrapChannelActivity($channelID, $streamID){
        try{
            $feed = UserFeed::where([
                ['identifier', '=', $streamID],
                ['base_status_id', '=', 8],
            ])->first();

            if(isset($feed) && ($feed->base_status_id == 8)){
                $http = self::fetchVideo(null, $channelID, $streamID);

                if(Str::contains($http['thumbnail_url'], '/_404/404_processing_%{width}x%{height}.png') == false){
                    $feed->update([
                        'base_status_id'    => 9,
                        'concurrent'        => 0,
                        'identifier'        => $http['id'],
                        'thumbnail'         => Str::replace('%{width}x%{height}', '640x480', BaseHelper::getOnlyPath($http['thumbnail_url'], '.net/')),
                        'title'             => $http['title'],
                        'duration'          => Str::of('PT')->append(Str::of($http['duration'])->upper()),
                    ]);

                    if((isset($http['created_at'])) && (Carbon::parse($http['created_at'])->timezone(config('app.timezone'))->toDateTimeString() >= $feed->belongsToUserLinkTracker()->select('updated_at')->first()->updated_at)){
                        $feed->belongsToUserLinkTracker()->update([
                            'updated_at' => Carbon::parse($http['created_at'])->timezone(config('app.timezone'))->toDateTimeString(),
                        ]);
                    }
                }
            }
        }
        catch(\Throwable $th){
            // return $th;
        }
    }
}
