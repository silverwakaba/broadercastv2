<?php

namespace App\Helpers;

use App\Models\BaseLink;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class BaseHelper{
    public static function adler32($value = ''){
        if(!$value){
            $value = Str::uuid();
        }

        return hash("adler32", $value);
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
}