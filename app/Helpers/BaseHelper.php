<?php

namespace App\Helpers;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Models\BaseLink;
use App\Models\User;
use Illuminate\Support\Arr;
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

    public static function timeInterval($date){
        $carbon = Carbon::parse($date);

        return CarbonInterval::create(
            $years = null, $months = null, $weeks = null, $days = null, $hours = $carbon->diffInHours(), $minutes = null, $seconds = null, $microseconds = null
        )->format('%H:%I:%S');
    }

    public static function socks5Proxy(){
        $proxy = Arr::shuffle([
            'socks5://ipv4.id.1.spn.my.id:12053',
            // 'socks5://ipv4.de.2.spn.my.id:12053',
        ]);

        // Get first array
        return $proxy[0];
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
         * -------------------------------------------------------------------------------------------------------------
         * Not being used anymore, since it's definitely incure request costs. But the code is kept for future reference
         * -------------------------------------------------------------------------------------------------------------
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