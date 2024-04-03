<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class BaseHelper {
    public static function encrypt($v){
        return Crypt::encryptString($v);
    }

    public static function decrypt($v){
        return Crypt::decryptString($v);
    }
}