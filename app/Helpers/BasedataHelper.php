<?php

namespace App\Helpers;

use App\Helpers\BaseHelper;

use App\Models\BaseAffiliation;
use App\Models\BaseBoolean;
use App\Models\BaseContent;
use App\Models\BaseCountry;
use App\Models\BaseGender;
use App\Models\BaseLanguage;
use App\Models\BaseLink;
use App\Models\BaseRace;
use App\Models\BaseSort;
use App\Models\BaseTimezone;

class BasedataHelper{
    public static function baseAffiliation(){
        $datas = BaseAffiliation::orderBy('name', 'ASC')->get();

        return $datas;
    }

    public static function baseBoolean(){
        $datas = BaseBoolean::orderBy('id', 'ASC')->get();

        return $datas;
    }

    public static function baseContent(){
        $datas = BaseContent::orderBy('name', 'ASC')->get();

        return $datas;
    }

    public static function baseCountry(){
        $datas = BaseCountry::orderBy('name', 'ASC')->get();

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
    
    public static function baseLink(){
        $datas = BaseLink::orderBy('name', 'ASC')->get();

        return $datas;
    }

    public static function baseRace(){
        $datas = BaseRace::orderBy('name', 'ASC')->get();

        return $datas;
    }

    public static function baseSort(){
        $datas = BaseSort::orderBy('id', 'ASC')->get();

        return $datas;
    }

    public static function baseTimezone(){
        $datas = BaseTimezone::orderBy('id', 'ASC')->get();

        return $datas;
    }
}