<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\BaseLink;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class BaseHelper{
    public static function adler32($value = ''){
        if(!$value){
            $value = Str::uuid();
        }

        return hash("adler32", $value);
    }

    public static function analyzeDomain($url, $catch, $subTLD = false){
        if(Str::isUrl($url) == true){
            $url = Str::chopStart($url, ['http://', 'https://']);

            $domain = Str::of($url)->before('/');

            if($catch == 'domain'){
                return $domain;
            }
            elseif($catch == 'name'){
                return Str::of($domain)->before('.');
            }
            elseif($catch == 'extension'){
                if($subTLD == true){
                    $extension = Str::of($domain)->after('.');
                }
                else{
                    $extension = Str::of($domain)->afterLast('.');
                }

                return $extension;
            }
            else{
                return null;
            }
        }
        else{
            return null;
        }
    }

    public static function getOnlyPath($url, $after){
        return Str::of($url)->after($after . '/');

        // Old, unreliable code
        // $datas = Str::contains($url, [
        //     // Youtube Avatar and Banner
        //     'https://yt3.ggpht.com', 'https://yt3.googleusercontent.com', 'https://lh3.googleusercontent.com',
            
        //     // Youtube Thumbnail
        //     'https://i.ytimg.com',

        //     // Twitch All-Static
        //     'https://static-cdn.jtvnw.net'
        // ]);

        // if(($datas == true)){
        //     return Str::of($url)->after($after . '/');
        // }
        // else{
        //     return $url;
        // }
    }

    public static function httpProxy($url, $query = null, $option = null){
        /**
         * ----------------------------------------------------------------------------------------------------------------------------------------
         * Make a note, since the possibility of confusion is high in the future. Like "what the actual fuck am i doing here" or some similarity.
         *
         * 1. 'proxy' option utilize Hono API Bridger, which hosted on Cloudflare Pages.
         *    - Need to be deployed first from Github to Cloudflare Pages environment.
         *    - Some provider known to do IP block if we make a lot of API call, for example Youtube v3.
         *    - Cloudflare Pages have abundant IP pool and would act as our backend proxy who make request on our behalf.
         *    - Since it was a serverless environment, please leave immediately if start being charged humongously.
         *
         * 2, 'socks' option utilize TOR network for IP flexibility.
         *    - Need to be installed and configured on local machine.
         *    - TOR network is notorious for their abusive usage, so their IP pool is basically doomed.
         *    - If your Cloudflare security set to high or more please make an exception to the /misc/proxy endpoint, so request isn't blocked.
         *
         * 3. If 'proxy' were enabled, it means that the request would be carried over by IP provided by API Bridger.
         *    - API Bridger > Endpoint
         *
         * 4. If 'socks' were enabled, it means that the request would be carried over by IP provided by TOR network.
         *    - TOR > Endpoint
         *
         * 5. If both were enabled, it means that the request would be carried over by IP provided by TOR network which then access the API Bridger.
         *    - TOR > API Bridger > Endpoint
         *
         * 6. Core API such as Youtube v3 or Twitch Helix don't need to use this httpProxy helper, since it has its own endpoint. But it stil can tho.
         *
         * 7. Verdict: Only use one type of proxy, since it is more fast. Unless for unknown reason, like Cloudflare Pages isn't available anymore.
         * ----------------------------------------------------------------------------------------------------------------------------------------
        **/

        if(Str::of($url)->isUrl() == true){
            // 30 secs timeout
            $http = Http::timeout(30);

            $outputURL = null;
            $endpointURL = null;

            // Query string
            if($query == null){
                $outputURL = $url;
            }
            else{
                $outputURL = Str::of(Str::finish($url, '?'))->append(urldecode(http_build_query($query, null, '&')));
            }

            // Proxy option - Deploy and set Hono API Bridger to Cloudflare Pages
            if(!isset($option['proxy']) ?? $option['proxy'] == false){
                $endpointURL = $outputURL;
            }
            else{
                $proxyURL = 'https://apibridger.silverspoon.me/misc/proxy?key=penikmatKesulitan&url';

                $endpointURL = Str::of(Str::finish($proxyURL, '='))->append($outputURL);
            }

            // SOCKS option - TOR might be blocked on many case and wouldn't really recommend, unless Cloudflare Pages is fucked up, or at least isn't available anymore
            if(isset($option['socks']) ?? $option['socks'] == true){
                $http->withOptions([
                    'proxy' => [
                        'http'  => 'socks5://103.76.129.3:12053',
                        'https' => 'socks5://103.76.129.3:12053',
                    ],
                ]);
            }

            // Return result based on method
            if($option['method'] == 'GET'){
                return $http->get($endpointURL);
            }
            else{
                return null;
            }
        }
        else{
            return null;
        }
    }

    public static function setIdentifier($name, $before = null, $after = null){
        $slug = Str::of($name)->slug('-');

        $before = Str::before($before, '.');

        $after = Str::after($after, '.');

        return Str::of($before)->append('.' . Str::of($slug)->slug('-'));
    }

    public static function diffInDays($compared){
        $now = Carbon::now()->timezone(config('app.timezone'))->toDateTimeString();
        $parse = Carbon::parse($compared)->timezone(config('app.timezone'))->toDateTimeString();

        return Carbon::parse($now)->diffInDays($parse);
    }

    public static function getBotID(){
        $datas = User::where([
            ['identifier', '=', 'waka'],
        ])->first();

        return $datas->id;
    }

    public static function getCheckedBaseLink(){
        $datas = BaseLink::where([
            ['checking', '=', true],
        ])->select('id')->get();

        return ($datas)->pluck('id')->toArray();
    }

    public static function encrypt($value){
        return Crypt::encryptString($value);
    }

    public static function decrypt($value){
        try{
            return Crypt::decryptString($value);
        }
        catch(\Throwable $th){
            return abort(404);
        }
    }

    public static function resourceToJson($datas){
        $encode = json_encode($datas);
        
        $decode = json_decode($encode);

        return $decode;
    }

    public static function youtubeXMLToJson($channelID){
        $http = Http::get('https://www.youtube.com/feeds/videos.xml', [
            'channel_id' => $channelID,
        ]);

        $xml = simplexml_load_string($http->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);

        return self::resourceToJson($xml);
    }
}