<?php

namespace App\Repositories\Service;

use App\Helpers\BaseHelper;
use App\Models\BaseAPI;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TwitchAPIRepositories{
    /**
     * ----------------------------
     * Basic Function
     * ----------------------------
    **/

    // Error Code
    public static function errorCode(){
        return [
            'error', 'error.code', 'error.message', 'error.status',
        ];
    }

    // Error Keyword
    public static function errorKeyword(){
        return [
            'unusual traffic',
            'sending automated queries',
            'Enable JavaScript and cookies to continue',
            'Our systems have detected unusual traffic from your computer network',
        ];
    }

    /**
     * ----------------------------
     * API Core Block
     * ----------------------------
    **/

    // API Key
    public static function apiKey(){
        $apiKey = BaseAPI::where([
            ['base_link_id', '=', 1],
        ])->select('client_id', 'client_secret', 'bearer')->inRandomOrder()->first();

        return $apiKey;
    }

    // API Call via Internal Routing Rules
    public static function apiCall($data, $function, $client_id = null, $client_secret = null, $bearer = null){
        $newClientID = isset($client_id) ? $client_id : null;
        $newClientSecret = isset($client_secret) ? $client_secret : null;
        $newBearerToken = isset($bearer) ? $bearer : null;

        try{
            $errorCode = self::errorCode();

            $signature = [
                'fetchFrom' => 'twitch',
            ];

            // Endpoint
            if((Str::contains($function, ['oauth2']) == true)){
                // Twitch identity manager
                $endpoint = [
                    '1st' => 'https://id.twitch.tv/',
                ];
            }
            else{
                // Twitch API endpoint
                $endpoint = [
                    '1st' => 'https://api.twitch.tv/helix/',
                ];
            }

            // Method
            if((Str::contains($function, ['oauth2/token']) == true)){
                // Post token request
                $responses = Http::pool(fn (Pool $pool) => [
                    $pool->as('1stR')->post(Str::of($endpoint['1st'])->append($function), $data),
                ]);
            }
            else{
                // Get data
                $responses = Http::pool(fn (Pool $pool) => [
                    $pool->as('1stR')->acceptJson()->withHeaders([
                        'Authorization' => 'Bearer ' . $bearer,
                        'Client-Id'     => $client_id,
                    ])->get(Str::of($endpoint['1st'])->append($function), $data),
                ]);
            }

            foreach($responses as $response){
                if(Arr::hasAny($response, $errorCode) == false){
                    return array_merge(['status' => $response->status()], $signature, $response->json());
                }
                else{
                    return self::apiRecall($data, $function, $newClientID, $newClientSecret, $newBearerToken);
                }
            }
        }
        catch(\Throwable $th){
            return $th;

            // return [
            //     'success'   => false,
            //     'message'   => 'Something is error. Please try again later.',
            // ];

            return self::apiRecall($data, $function, $newClientID, $newClientSecret, $newBearerToken);
        }
    }

    public static function apiRecall($data, $function, $client_id = null, $client_secret = null, $bearer = null){
        $newClientID = isset($client_id) ? $client_id : null;
        $newClientSecret = isset($client_secret) ? $client_secret : null;
        $newBearerToken = isset($bearer) ? $bearer : null;

        return self::apiCall($data, $function, $newClientID, $newClientSecret, $newBearerToken);
    }

    /**
     * -----------------------------
     * API Call to Official Endpoint
     * -----------------------------
    **/

    // Create Token
    public static function createToken($client_id, $client_secret){
        $params = [
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'grant_type'    => 'client_credentials',
        ];

        return self::apiCall($params, 'oauth2/token', null, null, null);
    }

    // Validate Token
    public static function validateToken($client_secret, $bearer){
        return self::apiCall(null, 'oauth2/validate', null, $client_secret, $bearer);
    }

    // Fetch Profile | $client_id, $bearer, $id = null
    public static function fetchProfile($channelID){
        if((isset($channelID) && $channelID !== null)){
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
        }
        else{
            return [
                'status'    => 400,
                'message'   => 'Provide at least one parameter.',
            ];
        }

        return self::apiCall($params, 'users', self::apiKey()->client_id, null, self::apiKey()->bearer);
    }

    // Fetch Channel
    public static function fetchChannel($id = null){
        $params = [
            'broadcaster_id' => $id,
        ];

        return self::apiCall($params, 'channels', self::apiKey()->client_id, null, self::apiKey()->bearer);
    }

    // Fetch Subscriber
    public static function fetchSubscriber($id = null){
        $params = [
            'broadcaster_id' => $id,
        ];

        return self::apiCall($params, 'channels/followers', self::apiKey()->client_id, null, self::apiKey()->bearer);
    }

    // Fetch Stream
    public static function fetchStream($id = null){
        $params = [
            'type'      => "live",
            'user_id'   => $id,
        ];

        return self::apiCall($params, 'streams', self::apiKey()->client_id, null, self::apiKey()->bearer);
    }

    // Fetch Video
    public static function fetchVideo($userID = null, $videoID = null, $streamID = null){
        // id and user_id params are mutually exclusive, so that it can't be inserted together
        $params = [
            'id'        => $videoID,
            'user_id'   => $userID,
        ];

        $http = self::apiCall($params, 'videos', self::apiKey()->client_id, null, self::apiKey()->bearer);

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
     * API Call to Internal Scraper
     * ----------------------------
    **/

    // Not yet defined
}
