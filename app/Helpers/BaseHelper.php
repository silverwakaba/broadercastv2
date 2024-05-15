<?php

namespace App\Helpers;

use App\Models\BaseLink;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class BaseHelper {
    public static function adler32($v = ''){
        if(!$v){
            $v = Str::uuid();
        }

        return hash("adler32", $v);
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

    public static function encrypt($v){
        return Crypt::encryptString($v);
    }

    public static function decrypt($v){
        try{
            return Crypt::decryptString($v);
        }
        catch(\Throwable $th){
            return abort(404);
        }
    }
}