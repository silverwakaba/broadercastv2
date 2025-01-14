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
            ['id', '=', 1],
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
            // Endpoint
            if((Str::contains($function, ['oauth2']) == true)){
                // Twitch API Identity Manager
                $endpoint = 'https://id.twitch.tv/';
            }
            else{
                // Twitch API Helix
                $endpoint = 'https://api.twitch.tv/helix/';
            }

            // Make an API Call
            if((Str::contains($function, ['oauth2/token']) == true)){
                $http = Http::post(Str::of($endpoint)->append($function), $data);
            }
            else{
                $http = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $bearer,
                    'Client-Id'     => $client_id,
                ])->get(Str::of($endpoint)->append($function) . $data);
            }

            if(Arr::hasAny($http, self::errorCode()) == false){
                return array_merge(['status' => $http->status()], $http->json());
            }
            else{
                return self::apiRecall($data, $function, $newClientID, $newClientSecret, $newBearerToken);
            }
        }
        catch(\Throwable $th){
            throw $th;
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

    // Fetch Profile By ID
    public static function fetchProfileByID($id){
        $params = [
            'id' => $id,
        ];

        $query = self::paramsQuery($params, 'id');

        return self::apiCall($query, 'users', self::apiKey()->client_id, null, self::apiKey()->bearer);
    }

    // Fetch Profile By Handler
    public static function fetchProfileByHandler($id){
        $params = [
            'login' => $id,
        ];

        $query = self::paramsQuery($params, 'login');

        return self::apiCall($query, 'users', self::apiKey()->client_id, null, self::apiKey()->bearer);
    }

    // Fetch Channel
    public static function fetchChannel($id = null){
        $params = [
            'broadcaster_id' => $id,
        ];

        $query = self::paramsQuery($params, 'broadcaster_id');

        return self::apiCall($query, 'channels', self::apiKey()->client_id, null, self::apiKey()->bearer);
    }

    // Fetch Subscriber
    public static function fetchSubscriber($id = null){ // Actually follower and not a subscriber | Need to be revised? | Nah
        $params = [
            'broadcaster_id' => $id,
        ];

        $query = self::paramsQuery($params, 'broadcaster_id');

        return self::apiCall($query, 'channels/followers', self::apiKey()->client_id, null, self::apiKey()->bearer);
    }

    // Fetch Stream
    public static function fetchStream($id = null){
        $params = [
            'type'      => "live",
            'user_id'   => $id,
        ];

        $query = self::paramsQuery($params, 'user_id');

        return self::apiCall($query, 'streams', self::apiKey()->client_id, null, self::apiKey()->bearer);
    }

    // Fetch Stream
    public static function fetchStreamByHandler($id = null){
        $params = [
            'type'          => "live",
            'user_login'    => $id,
        ];

        $query = self::paramsQuery($params, 'user_login');

        return self::apiCall($query, 'streams', self::apiKey()->client_id, null, self::apiKey()->bearer);
    }

    // Fetch Video | Need to add some worthnoty notes since:
    // This function only fetch and filter the first 20 video belongs to user AND not implementing pagination
    // So if given video is AVAILABLE as the 21st video onwards, IT WILL be marked as UNAVAILABLE or NULL ARRAY
    // Twitch don't store VOD that long, so i won't trying hard on this one either
    public static function fetchVideo($userID, $kind = null, $theID = null){
        $params = [
            'user_id'   => $userID,
            'sort'      => 'time',
        ];

        $query = self::paramsQuery($params, 'user_id');

        $http = self::apiCall($query, 'videos', self::apiKey()->client_id, null, self::apiKey()->bearer);

        // Showing all of the video belongs to user
        if(($kind == null) && ($theID == null)){
            return $http;
        }

        // Showing one video belongs to user based on video id
        elseif(($kind == 'video') && ($theID != null)){
            return collect($http['data'])->where('id', '=', $theID)->first();
        }

        // Showing one video belongs to user based on stream id
        elseif(($kind == 'stream') && ($theID != null)){
            return collect($http['data'])->where('stream_id', '=', $theID)->first();
        }

        // just for precaution
        else{
            return null;
        }
    }

    /**
     * ----------------------------
     * API Call to Internal Scraper
     * ----------------------------
    **/

    // Scrape

    /**
     * ------------------------------
     * Get & process part of the data
     * ------------------------------
    **/

    public static function paramsQuery($data, $key){
        $needDelimiter = Str::contains($data[$key], [',']);
        $filteredData = Arr::query(Arr::except($data, [$key]));

        if(isset($needDelimiter) && $needDelimiter == true){
            $idDelimiter = explode(',', $data[$key]);
            $idDelimiterNew = '';

            foreach($idDelimiter as $ids){
                $idDelimiterNew .= Str::of($key)->append('=' . $ids . '&');
            }

            $cleanDelimiter = Str::chopEnd($idDelimiterNew, '&');

            $query = Str::of($filteredData . '&')->append($cleanDelimiter);
        }
        else{
            $query = Arr::query($data);
        }

        return Str::start($query, '?');
    }
}
