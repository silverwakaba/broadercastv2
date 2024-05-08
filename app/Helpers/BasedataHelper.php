<?php

namespace App\Helpers;

use App\Models\BaseContent;

class BasedataHelper{
    public static function BaseContent(){
        $datas = BaseContent::get();

        return $datas;
    }
}