<?php

namespace App\Helpers;

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

    public static function encrypt($v){
        return Crypt::encryptString($v);
    }

    public static function decrypt($v){
        return Crypt::decryptString($v);
    }
}