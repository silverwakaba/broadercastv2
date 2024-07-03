<?php

namespace App\Repositories\Base;

use App\Models\BaseTimezone;

class CookiesRepositories{
    public static function actualStart(){
        $data = request()->cookie('actual_start') ? request()->cookie('actual_start') : 'DESC';

        return $data;
    }

    public static function published(){
        $data = request()->cookie('published') ? request()->cookie('published') : 'DESC';

        return $data;
    }

    public static function schedule(){
        $data = request()->cookie('schedule') ? request()->cookie('schedule') : 'ASC';

        return $data;
    }

    public static function timezone(){
        return request()->cookie('timezone') ? request()->cookie('timezone') : 'Asia/Jakarta';
    }
}
