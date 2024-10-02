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
        // Use for hardcode debug to see usage
        // return $hardcode = 'AIzaSyCG2E8UACFHwuvVhb45dukAPkC0Agwj9WQ';

        $datas = BaseAPI::where([
            ['base_link_id', '=', '2'],
        ])->select('client_key')->inRandomOrder()->first()->client_key;

        return $datas;
    }

    // API Call via Internal Routing Rules
    public static function apiCall($data, $function, $apiKey = null){
        try{
            // Via Official Lemnos noKey, through Tor Socks5 Network
            if(($apiKey == null)){
                $http = Http::withOptions([
                    // 'proxy' => BaseHelper::socks5Proxy(),

                    'proxy' => 'socks5://ipv4.id.1.spn.my.id:12053',

                ])->get(Str::of('https://yt.lemnoslife.com/noKey/')->append($function), $data);

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
                    '1st' => 'https://llde.spn.my.id/',
                    '2nd' => 'https://llid.spn.my.id/',
                ];

                $responses = Http::pool(fn (Pool $pool) => [
                    $pool->as('1stR')->get(Str::of($endpoint['1st'])->append($function), $data),
                    $pool->as('2ndR')->get(Str::of($endpoint['2nd'])->append($function), $data),
                ]);

                foreach($responses as $key => $response){
                    if(($response->ok() == true)){
                        return array_merge(self::signature('llScraper:' . $key), $response->json());
                    }
                    else{
                        return self::apiRecall($data, $function);
                    }
                }
            }

            // Via Googleapis
            else{
                $params = array_merge($data, ['key' => $apiKey]);

                $http = Http::
                // withOptions([
                //     'proxy' => BaseHelper::socks5Proxy(),
                // ])->
                get(Str::of('https://www.googleapis.com/youtube/v3/')->append($function), $params);

                if((Arr::hasAny($http, self::errorCode()) == false) && ($http->ok() == true)){
                    return array_merge(self::signature('gApis', $apiKey), $http->json());
                }
                else{
                    return self::apiRecall($data, $function);
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

    /**
     * ----------------------------
     * Scraping via HTTP Client
     * ----------------------------
    **/

    public static function scrapeVideos($videoID){
        $http = Http::withOptions([
            'proxy' => BaseHelper::socks5Proxy(),
        ])->get('https://www.youtube.com/watch', [
            'v' => $videoID,
        ])->body();

        // return [$http];

        $id = Str::betweenFirst($http, '{"liveStreamabilityRenderer":{"videoId":"', '",');
        $title = Str::betweenFirst($http, '"title":"', '",');
        $concurrent = (int) Str::betweenFirst($http, '"originalViewCount":"', '"');

        if((Str::of($http)->contains(self::errorKeyword()) == false)){
            return [
                'id'            => $id,
                'live'          => (Str::length($id) == 11) ? true : false,
                'concurrent'    => $concurrent,
                'title'         => (Str::length($id) <= 100) ? $title : null,
                'timezone'      => config('app.timezone'),
            ];
        }
        else{
            return "Chaban";
        }
    }
}
