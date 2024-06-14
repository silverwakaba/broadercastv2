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

    public static function diffInDays($day, $compared){
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