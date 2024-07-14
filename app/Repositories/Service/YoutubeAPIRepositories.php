<?php

namespace App\Repositories\Service;

use App\Helpers\BaseHelper;
use App\Models\BaseAPI;

use Carbon\Carbon;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class YoutubeAPIRepositories{
    /*
    |--------------------------------------------------------------------------
    | Core Block
    |--------------------------------------------------------------------------
    */

    // Error Keyword Filter
    public static function errorKeyword(){
        return [
            'unusual traffic',
            'Enable JavaScript and cookies to continue',
            'Our systems have detected unusual traffic from your computer network',
        ];
    }

    // Youtube API Key
    public static function apiKey(){
        $apiKey = BaseAPI::where([
            ['base_link_id', '=', 2],
        ])->select('client_key')->inRandomOrder()->first()->client_key;

        return $apiKey;
    }

    // Make a Request to Youtube API-Endpoint
    public static function apiCall($data, $function){
        // Not yet Implemented Request with Key, Until the Limit is Increased
        $withKey = Str::of($function)->contains([
            'notAfterWeIncreaseTheLimit'
        ]);

        $endpoint = [
            'lemnoslife' => 'https://yt.lemnoslife.com/noKey/',
            'googleapis' => 'https://www.googleapis.com/youtube/v3/',
        ];

        if($withKey == false){
            $signature = [
                'fetchFrom' => 'lemnoslife',
            ];

            $http = Http::acceptJson()->get(
                Str::of($endpoint['lemnoslife'])->append($function), $data
            )->json();

            return array_merge($signature, $http);
        }
        else{
            $apiKey = self::apiKey();

            $signature = [
                'fetchFrom' => 'googleapis',
            ];

            $dataWithKey = array_merge($data, ['key' => $apiKey]);

            $http = Http::acceptJson()->get(
                Str::of($endpoint['googleapis'])->append($function), $dataWithKey
            )->json();

            return array_merge($signature, $http);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Scraper Block
    |--------------------------------------------------------------------------
    */

    // Channel
    public static function scrapeChannel($id){
        $directMethod = self::scrapeChannelDirectly($id);

        // We're using direct mode as first choice
        if(
            ($directMethod['success'] == true)
        ){
            return $directMethod;
        }

        // If direct mode was failed, we switch to scraper mode
        else{
            $scraperMethod = self::scrapeChannelProxied($id);

            return $scraperMethod;
        }
    }

    public static function scrapeChannelDirectly($id){
        try{
            $http = Http::get('https://www.youtube.com/' . $id)->body();

            $id = Str::betweenFirst($http, '"browseEndpoint":{"browseId":"', '",');

            $errorKeyword = self::errorKeyword();

            if((Str::of($http)->contains($errorKeyword) == false)){
                return [
                    'success'   => true,
                    'id'        => (Str::length($id) == 24) ? $id : null,
                    'method'    => 'direct',
                ];
            }
            else{
                return [
                    'success'   => false,
                    'method'    => 'direct',
                ];
            }
        }
        catch(\Throwable $th){
            return [
                'success'   => false,
                'method'    => 'direct',
            ];
        }
    }

    public static function scrapeChannelProxied($id){
        try{
            $endpoint = [
                '1st' => 'https://web.scraper.workers.dev',
                '2nd' => 'https://scraper.sspn.workers.dev',
            ];

            $params = [
                'url'       => "https://www.youtube.com/$id",
                'selector'  => 'title,script,body',
                'scrape'    => 'text',
                'spaced'    => 'true',
                'pretty'    => 'true',
            ];
    
            $responses = Http::pool(fn (Pool $pool) => [
                $pool->as('first')->get($endpoint['1st'], $params),
                $pool->as('second')->get($endpoint['2nd'], $params),
            ]);
    
            $http = [
                '1stP'  => $responses['first']->json(),
                '2ndP'  => $responses['second']->json(),
            ];

            /**
             * Array key reference (Patch 12 July 2024)
             * 26: Channel status (id)
            */

            // First result
            if(
                (Str::isUrl($http['1stP']['result']['title'][0]) == false)
                &&
                (Str::of($http['1stP']['result']['script'][0])->contains(['captcha']) == false)
                &&
                (Str::of($http['1stP']['result']['body'][0])->contains(['captcha']) == false)
            ){
                $httpResult = $http['1stP']['result']['script'];

                $id = Str::betweenFirst($httpResult[26], '"browseEndpoint":{"browseId":"', '",');

                return [
                    'success'   => true,
                    'id'        => (Str::length($id) == 24) ? $id : null,
                    'method'    => 'scraper1',
                ];
            }

            // Second result
            elseif(
                (Str::isUrl($http['2ndP']['result']['title'][0]) == false)
                &&
                (Str::of($http['2ndP']['result']['script'][0])->contains(['captcha']) == false)
                &&
                (Str::of($http['2ndP']['result']['body'][0])->contains(['captcha']) == false)
            ){
                $httpResult = $http['2ndP']['result']['script'];

                $id = Str::betweenFirst($httpResult[26], '"browseEndpoint":{"browseId":"', '",');

                return [
                    'success'   => true,
                    'id'        => (Str::length($id) == 24) ? $id : null,
                    'method'    => 'scraper2',
                ];
            }

            // Else
            else{
                return [
                    'success'   => false,
                    'method'    => 'scraper',
                ];
            }
        }
        catch(\Throwable $th){
            return [
                'success'   => false,
                'method'    => 'scraper',
            ];
        }
    }

    // Video
    public static function scrapeVideo($id){
        $directMethod = self::scrapeVideoDirectly($id);

        // We're using direct mode as first choice
        if(
            ($directMethod['success'] == true)
        ){
            return $directMethod;
        }

        // If direct mode was failed, we then switched to scraper mode
        else{
            return "Error";

            $scraperMethod = self::scrapeVideoProxied($id);

            return $scraperMethod;
        }
    }

    public static function scrapeVideoDirectly($id){
        try{
            $http = Http::get('https://www.youtube.com/watch', [
                'v'  => $id,
            ])->body();

            $id = Str::betweenFirst($http, '{"liveStreamabilityRenderer":{"videoId":"', '",');
            $title = Str::betweenFirst($http, '"title":"', '",');
            $concurrent = (int) Str::betweenFirst($http, '"originalViewCount":"', '"');
            $schedule = (int) Str::betweenFirst($http, '"scheduledStartTime":"', '",') !== 0 ? true : false;

            $errorKeyword = self::errorKeyword();

            if((Str::of($http)->contains($errorKeyword) == false)){
                return [
                    'success'       => true,
                    'live'          => (Str::length($id) == 11) ? true : false,
                    'concurrent'    => $concurrent,
                    'title'         => (Str::length($id) <= 100) ? $title : null,
                    'timezone'      => config('app.timezone'),
                    'schedule'      => $schedule == true ? Carbon::createFromTimestamp(Str::betweenFirst($http, '"scheduledStartTime":"', '",'))->timezone(config('app.timezone'))->toDateTimeString() : null,
                    'method'        => 'direct',
                ];
            }
            else{
                return [
                    'success'       => false,
                    'method'        => 'direct',
                ];
            }
        }
        catch(\Throwable $th){
            return [
                'success'       => false,
                'method'        => 'direct',
            ];
        }
    }

    public static function scrapeVideoProxied($id){
        try{
            $endpoint = [
                '1st' => 'https://web.scraper.workers.dev',
                '2nd' => 'https://scraper.sspn.workers.dev',
            ];

            $params = [
                'url'       => "https://www.youtube.com/watch?v=$id",
                'selector'  => 'title,script,body',
                'scrape'    => 'text',
                'spaced'    => 'true',
                'pretty'    => 'true',
            ];

            $responses = Http::pool(fn (Pool $pool) => [
                $pool->as('first')->get($endpoint['1st'], $params),
                $pool->as('second')->get($endpoint['2nd'], $params),
            ]);

            $http = [
                '1stP'  => $responses['first']->json(),
                '2ndP'  => $responses['second']->json(),
            ];

            /**
                * Array key reference (Patch 15 June 2024)
                * 14: Streaming status (id, title, next stream schedule)
                * 35: Streaming statistic (concurrent viewers)
            */

            // First result
            if(
                (Str::isUrl($http['1stP']['result']['title'][0]) == false)
                &&
                (Str::of($http['1stP']['result']['script'][0])->contains(['captcha']) == false)
                &&
                (Str::of($http['1stP']['result']['body'][0])->contains(['captcha']) == false)
            ){
                $httpResult = $http['1stP']['result']['script'];

                $id = Str::betweenFirst($httpResult[14], '{"liveStreamabilityRenderer":{"videoId":"', '",');
                $title = Str::betweenFirst($httpResult[14], '"title":"', '",');
                $concurrent = (int) Str::betweenFirst($httpResult[35], '"originalViewCount":"', '"');
                $schedule = (int) Str::betweenFirst($httpResult[14], '"scheduledStartTime":"', '",') !== 0 ? true : false;

                return [
                    'success'       => true,
                    'live'          => (Str::length($id) == 11) ? true : false,
                    'concurrent'    => $concurrent,
                    'title'         => (Str::length($id) <= 100) ? $title : null,
                    'timezone'      => config('app.timezone'),
                    'schedule'      => $schedule == true ? Carbon::createFromTimestamp(Str::betweenFirst($httpResult[14], '"scheduledStartTime":"', '",'))->timezone(config('app.timezone'))->toDateTimeString() : null,
                    'method'        => 'scraper1',
                ];
            }

            // Second result
            elseif(
                (Str::isUrl($http['2ndP']['result']['title'][0]) == false)
                &&
                (Str::of($http['2ndP']['result']['script'][0])->contains(['captcha']) == false)
                &&
                (Str::of($http['2ndP']['result']['body'][0])->contains(['captcha']) == false)
            ){
                $httpResult = $http['2ndP']['result']['script'];

                $id = Str::betweenFirst($httpResult[14], '{"liveStreamabilityRenderer":{"videoId":"', '",');
                $title = Str::betweenFirst($httpResult[14], '"title":"', '",');
                $concurrent = (int) Str::betweenFirst($httpResult[35], '"originalViewCount":"', '"');
                $schedule = (int) Str::betweenFirst($httpResult[14], '"scheduledStartTime":"', '",') !== 0 ? true : false;

                return [
                    'success'       => true,
                    'live'          => (Str::length($id) == 11) ? true : false,
                    'concurrent'    => $concurrent,
                    'title'         => (Str::length($id) <= 100) ? $title : null,
                    'timezone'      => config('app.timezone'),
                    'schedule'      => $schedule == true ? Carbon::createFromTimestamp(Str::betweenFirst($httpResult[14], '"scheduledStartTime":"', '",'))->timezone(config('app.timezone'))->toDateTimeString() : null,
                    'method'        => 'scraper2',
                ];
            }

            // Else
            else{
                return [
                    'success'       => false,
                    'method'        => 'scraper',
                ];
            }
        }
        catch(\Throwable $th){
            return [
                'success'       => false,
                'method'        => 'scraper',
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | API Block
    |--------------------------------------------------------------------------
    */

    public static function fetchChannels($channelID){
        $params = [
            'id'            => "$channelID",
            'maxResults'    => 50,
            'part'          => "snippet,statistics,brandingSettings,contentDetails",
        ];

        return self::apiCall($params, 'channels');
    }

    public static function fetchFeeds($channelID){
        $http = Http::get('https://www.youtube.com/feeds/videos.xml', [
            'channel_id' => "$channelID",
        ]);

        $xml = simplexml_load_string($http->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);

        return BaseHelper::resourceToJson($xml);
    }

    public static function fetchPlaylistItems($playlistID, $pageToken = null){
        $params = [
            'part'          => "snippet,contentDetails,status",
            'playlistId'    => "$playlistID",
            'maxResults'    => 50,
            'pageToken'     => "$pageToken",
        ];

        return self::apiCall($params, 'playlistItems');
    }

    public static function fetchVideos($videoID){
        $params = [
            'id'            => "$videoID",
            'maxResults'    => 50,
            'part'          => "contentDetails,liveStreamingDetails,snippet,statistics,status",
        ];

        return self::apiCall($params, 'videos');
    }
}
