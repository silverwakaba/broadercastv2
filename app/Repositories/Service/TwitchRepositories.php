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
                // Integer, as in "715990491"
                'id'    => $channelID,
            ];
        }
        elseif(is_string($channelID)){
            $params = [
                // String, as in "dttodot"
                'login' => $channelID,
            ];
        }

        return $http = Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $apiKey->bearer,
            'Client-Id'     => $apiKey->client_id,
        ])->get('https://api.twitch.tv/helix/users', $params)->json();

        if(count($http['data']) >= 1){
            foreach($http['data'] AS $data){
                return "Insert based on notes";
            }
        }
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

        return $http = Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $apiKey->bearer,
            'Client-Id'     => $apiKey->client_id,
        ])->get('https://api.twitch.tv/helix/channels/followers', $params)->json();
    }

    // Fetch Subscriber
    public static function fetchChannelActivity($channelID){
        /**
         * Notes
         * -
        **/

        $apiKey = self::apiKey();

        $params = [
            // Integer, as in "715990491"
            'broadcaster_id' => $channelID,
        ];

        return $http = Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $apiKey->bearer,
            'Client-Id'     => $apiKey->client_id,
        ])->get('https://api.twitch.tv/helix/channels', $params)->json();
    }

    // Fetch Stream via API
    public static function fetchStreamViaAPI($channelID){
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
    
        return $http = Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $apiKey->bearer,
            'Client-Id'     => $apiKey->client_id,
        ])->get('https://api.twitch.tv/helix/streams', $params)->json();
    }

    // Fetch Stream via API
    public static function fetchVideoViaAPI($videoID = null, $channelID = null, $streamID = null){
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

    public static function fetchChannelViaScraper($channelIDStr, $channelIDInt = null){
        $http = Http::get('https://www.twitch.tv/' . $channelIDStr)->body();

        $live = Str::betweenFirst($http, ',"isLiveBroadcast":', '}}');
        $title = Str::betweenFirst($http, '"description":"', '",');

        return $title;

        if((Str::of($live)->contains(['true'])) && (Str::length($title) <= 140)){
            $stream = self::fetchStreamViaAPI('715990491'); // Use $channelIDInt on prod

            if(isset($stream) && count($stream['data']) >= 1){
                return "Update or Create";
            }
            else{
                return "Update as Archived";
            }
        }
    }
}
