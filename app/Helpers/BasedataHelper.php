<?php

namespace App\Helpers;

use App\Models\BaseContent;
use App\Models\BaseGender;
use App\Models\BaseLanguage;

use App\Models\BaseLink;
use App\Models\BaseRace;

class BasedataHelper{
    public static function baseContent(){
        $datas = BaseContent::orderBy('name', 'ASC')->get();

        return $datas;
    }

    public static function baseGender(){
        $datas = BaseGender::orderBy('name', 'ASC')->get();

        return $datas;
    }

    public static function baseLanguage(){
        $datas = BaseLanguage::orderBy('name', 'ASC')->get();

        return $datas;
    }

    // Link

    public static function baseRace(){
        $datas = BaseRace::orderBy('name', 'ASC')->get();

        return $datas;
    }
}