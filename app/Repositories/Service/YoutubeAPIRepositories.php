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

class YoutubeAPIRepositories{
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
        $datas = BaseAPI::where([
            ['base_link_id', '=', '2'],
        ])->select('client_key')->inRandomOrder()->first()->client_key;

        return $datas;
    }

    // API Call via Internal Routing Rules
    public static function apiCall($data, $function, $apiKey = null){
        $errorCode = [
            'error', 'error.code', 'error.message', 'error.status'
        ];

        try{
            // Via Lemnos noKey
            if(($apiKey == null)){
                $signature = [
                    'fetchFrom' => 'llHost',
                ];

                $endpoint = [
                    '1st' => 'https://yt.lemnoslife.com/noKey/',
                ];

                $responses = Http::pool(fn (Pool $pool) => [
                    $pool->as('1stR')->get(Str::of($endpoint['1st'])->append($function), $data),
                ]);

                foreach($responses as $response){
                    if((Arr::hasAny($response, $errorCode) == false) && ($response->ok() == true)){
                        return array_merge($signature, $response->json());
                    }
                    elseif((Arr::hasAny($response, $errorCode) == false) && ($response->ok() == false)){
                        return self::apiRecall($data, $function, self::apiKey());
                    }
                    else{
                        return self::apiRecall($data, $function, null);
                    }
                }
            }

            // Via Private Lemnos Scraper
            elseif(($apiKey == 'scraperLL')){
                $signature = [
                    'fetchFrom' => 'llPvt',
                ];

                $endpoint = [
                    '1st' => 'https://llde.spn.my.id/',
                ];

                $responses = Http::pool(fn (Pool $pool) => [
                    $pool->as('1stR')->get(Str::of($endpoint['1st'])->append($function), $data),
                ]);

                foreach($responses as $response){
                    return array_merge($signature, $response->json());
                }
            }

            // Via Googleapis
            else{
                $signature = [
                    'fetchFrom' => 'gApis',
                ];

                $endpoint = [
                    '1st' => 'https://www.googleapis.com/youtube/v3/',
                ];

                $params = array_merge($data, ['key' => $apiKey]);

                $responses = Http::pool(fn (Pool $pool) => [
                    $pool->as('1stR')->get(Str::of($endpoint['1st'])->append($function), $params),
                ]);

                foreach($responses as $response){
                    if((Arr::hasAny($response, $errorCode) == false) && ($response->ok() == true)){
                        return array_merge($signature, $response->json());
                    }
                    else{
                        return self::apiRecall($data, $function, null);
                    }
                }
            }
        }
        catch(\Throwable $th){
            return $th;
        }
    }

    public static function apiRecall($data, $function, $apiKey = null){
        return self::apiCall($data, $function, $apiKey);
    }

    /**
     * ----------------------------
     * API Call to Official Data
     * ----------------------------
    **/

    // Channel
    public static function fetchChannels($channelID, $apiKey = null){
        $params = [
            'id'            => "$channelID",
            'maxResults'    => 50,
            'part'          => "snippet,statistics,brandingSettings,contentDetails",
        ];

        return self::apiCall($params, 'channels', $apiKey);
    }

    // Feed
    public static function fetchFeeds($channelID){
        $http = Http::get('https://www.youtube.com/feeds/videos.xml', [
            'channel_id' => "$channelID",
        ]);

        $xml = simplexml_load_string($http->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);

        return BaseHelper::resourceToJson($xml);
    }

    // Playlist
    public static function fetchPlaylistItems($playlistID, $pageToken = null, $apiKey = null){
        $params = [
            'part'          => "snippet,contentDetails,status",
            'playlistId'    => "$playlistID",
            'maxResults'    => 50,
            'pageToken'     => "$pageToken",
        ];

        return self::apiCall($params, 'playlistItems', $apiKey);
    }

    // Video
    public static function fetchVideos($videoID, $apiKey = null){
        $params = [
            'id'            => "$videoID",
            'maxResults'    => 50,
            'part'          => "contentDetails,liveStreamingDetails,snippet,statistics,status",
        ];

        return self::apiCall($params, 'videos', $apiKey);
    }

    /**
     * ----------------------------
     * API Call to Lemnos Scraper
     * ----------------------------
    **/

    // Channel
    public static function scrapeLLChannels($channelID, $apiKey = 'scraperLL'){
        $length = Str::length($channelID);
        $containAtSymbol = Str::contains($channelID, ['@']);

        $params = [
            'maxResults'    => 50,
            'part'          => "snippet,upcomingEvents,about,approval,membership",
        ];

        if(($length == 24) && ($containAtSymbol == false)){
            $params['id'] = $channelID;
        }
        else{
            $params['handle'] = $channelID;
        }

        return self::apiCall($params, 'channels', $apiKey);
    }

    // Video
    public static function scrapeLLVideos($videoID, $apiKey = 'scraperLL'){
        $params = [
            'id'            => "$videoID",
            'maxResults'    => 50,
            'part'          => "contentDetails,music,musics,short,snippet,statistics,status,activity,isPaidPromotion,isPremium,isMemberOnly,isOriginal,isRestricted,explicitLyrics",
        ];

        return self::apiCall($params, 'videos', $apiKey);
    }
}
