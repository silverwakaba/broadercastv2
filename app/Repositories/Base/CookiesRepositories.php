<?php

namespace App\Repositories\Base;

use Illuminate\Http\Request;

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
        $data = request()->cookie('timezone') ? request()->cookie('timezone') : config('app.timezone');

        return $data;
    }
}
