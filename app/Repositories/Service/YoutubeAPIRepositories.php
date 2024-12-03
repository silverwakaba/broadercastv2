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

    // Information About Key That Being Used
    public static function keyUsed($key){
        // AIzaSy means that the key is v3 key
        $keyUsed = Str::excerpt($key, 'AIzaSy', [
            'radius'    => 5,
            'omission'  => 'XXX',
        ]);

        return $keyUsed;
    }

    // Information About Service Signature
    public static function signature($service, $key = null){
        return [
            'fetchFrom' => $service,
            'keyUsed'   => self::keyUsed($key),
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
            ['base_link_id', '=', 2],
            ['client_key', '=', 'AIzaSyCG2E8UACFHwuvVhb45dukAPkC0Agwj9WQ'],
        ])->select('client_key')->inRandomOrder()->first()->client_key;

        return $datas;
    }

    // API Call via Internal Routing Rules
    public static function apiCall($data, $function, $apiKey = null){
        if($apiKey == null){
            // Basically redirect request to gApis endpoint if $apiKey is null
            $apiKey = self::apiKey();
        }

        try{
            // Via Official Lemnos noKey - This motherfucker dead already
            if(($apiKey == null)){
                return null;

                $http = Http::get(Str::of('https://yt.lemnoslife.com/noKey/')->append($function), $data);

                if((Arr::hasAny($http, self::errorCode()) == false) && ($http->ok() == true)){
                    return array_merge(self::signature('llHost'), $http->json());
                }
                elseif((Arr::hasAny($http, self::errorCode()) == false) && ($http->ok() == false)){
                    return self::apiRecall($data, $function, self::apiKey());
                }
                else{
                    return self::apiRecall($data, $function);
                }
            }

            // Via Private Lemnos Scraper
            elseif(($apiKey == 'scraperLL')){
                $endpoint = [
                    // '1st' => 'https://yts.spn.my.id/',
                    '1st' => 'https://yts-shared.spn.my.id/',
                ];

                $responses = Http::pool(fn (Pool $pool) => [
                    $pool->as('1stR')->timeout(60 * 5)->get(Str::of($endpoint['1st'])->append($function), $data), // at least 5 mins timeout for max 50 videos
                ]);

                foreach($responses as $key => $response){
                    if(($response->ok() == true)){
                        return array_merge(self::signature('llScraper:' . $key), $response->json());
                    }
                    else{
                        return array_merge(self::signature('llScraper:' . $key), $response->json());
                    }
                }
            }

            // Via Googleapis
            else{
                $params = array_merge($data, ['key' => $apiKey]);

                if(((isset($params['id'])) && ($params['id'] != null)) || ((isset($params['playlistId'])) && ($params['playlistId'] != null))){
                    $http = Http::get(Str::of('https://www.googleapis.com/youtube/v3/')->append($function), $params);

                    if((Arr::hasAny($http, self::errorCode()) == false) && ($http->ok() == true)){
                        return array_merge(self::signature('gApis', $apiKey), $http->json());
                    }
                    else{
                        // Do nothing
                    }
                }
            }
        }
        catch(\Throwable $th){
            // throw $th;
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
        $containCID = Str::contains($channelID, ['/c/']);
        $containAtSymbol = Str::contains($channelID, ['@']);

        $params = [
            'maxResults'    => 50,
            'part'          => "snippet,upcomingEvents,about,approval,membership",
        ];

        if(($length == 24) && ($containCID == false) && ($containAtSymbol == false)){
            $params['id'] = $channelID;
        }
        elseif(($length >= 1) && ($containCID == true) && ($containAtSymbol == false)){
            $params['cId'] = Str::of($channelID)->afterLast('/c/');
        }
        else{
            $params['handle'] = $channelID;
        }

        return self::apiCall($params, 'channels', $apiKey);
    }

    // Video
    public static function scrapeLLVideos($videoID, $part = null, $apiKey = 'scraperLL'){
        if($part != null){
            $parts = $part;
        }
        else{
            $parts = "contentDetails,music,musics,short,snippet,statistics,status,activity,isPaidPromotion,isPremium,isMemberOnly,isOriginal,isRestricted,explicitLyrics";
        }

        $params = [
            'id'            => "$videoID",
            'maxResults'    => 50,
            'part'          => $parts,
        ];

        return self::apiCall($params, 'videos', $apiKey);
    }

    /**
     * ----------------------------
     * Scraping via HTTP Client
     * ----------------------------
    **/

    public static function scrapeVideos($videoID){
        try{
            $http = Http::
            // withOptions([
            //     'proxy' => BaseHelper::socks5Proxy(),
            // ])->
            get('https://www.youtube.com/watch', [
                'v' => $videoID,
            ])->body();

            $id = Str::betweenFirst($http, '{"liveStreamabilityRenderer":{"videoId":"', '",');
            $title = Str::betweenFirst($http, '"title":"', '",');
            $concurrent = (int) Str::betweenFirst($http, '"originalViewCount":"', '"');

            if((Str::of($http)->contains(self::errorKeyword()) == false)){
                return [
                    'success'       => true,
                    'id'            => $id,
                    'item'          => $videoID,
                    'live'          => (Str::length($id) == 11) ? true : false,
                    'concurrent'    => $concurrent,
                    'title'         => (Str::length($id) <= 100) ? $title : null,
                ];
            }
            else{
                return [
                    'success'       => false,
                ];
            }
        }
        catch(\Throwable $th){
            return $th;
        }
    }
}
