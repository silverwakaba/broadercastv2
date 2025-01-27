<?php

namespace App\Repositories\Base;

use Faker\Factory;
use Illuminate\Support\Str;

class ImageHandlerRepositories{
    /**
     * Logo
    **/

    public static function logo($logo){
        if(isset($logo) && ($logo) && ($logo == 'darkmode')){
            return Str::of(config('app.cdn_public_url_r2'))->append('/system/image/logo/full-light-50-transparent.webp');
        }
        elseif(isset($logo) && ($logo) && ($logo == 'lightmode')){
            return Str::of(config('app.cdn_public_url_r2'))->append('/system/image/logo/full-dark-50-transparent.webp');
        }
        elseif(isset($logo) && ($logo) && ($logo == 'apps')){
            return Str::of(config('app.cdn_public_url_r2'))->append('/system/image/logo/logo-50.webp');
        }
    }

    /**
     * Avatar
    **/

    public static function avatar($data = null){
        if(isset($data) && ($data) && ($data != null)){
            return self::avatarCustom($data);
        }
        else{
            return self::avatarDefault();
        }
    }

    public static function avatarCustom($data){
        return Str::of(config('app.cdn_public_url_r2'))->append('/app/avatar/' . $data);
    }

    public static function avatarDefault(){
        $fakerBetween = Factory::create()->numberBetween(1, 5);

        return Str::of(config('app.cdn_public_url_r2'))->append('/system/image/avatar/avatar-' . $fakerBetween . '.webp');
    }

    /**
     * Channel
    **/

    public static function channelNull(){
        return Str::of(config('app.cdn_public_url_r2'))->append('/system/image/placeholder/banner.webp');
    }

    public static function channelAvatar($service, $avatar = null){
        // Twitch
        if(($service == 1) && ($avatar != null)){
            return Str::of(config('app.cdn_cache_twitch'))->append('/' . $avatar);
        }

        // YouTube
        elseif(($service == 2) && ($avatar != null)){
            return Str::of(config('app.cdn_cache_youtube_profile'))->append('/' . $avatar);
        }

        // Other
        else{
            return self::channelNull();
        }
    }

    public static function channelBanner($service, $banner = null){
        // Twitch
        if(($service == 1) && ($banner != null)){
            return Str::of(config('app.cdn_cache_twitch'))->append('/' . $banner);
        }

        // YouTube
        elseif(($service == 2) && ($banner != null)){
            return Str::of(config('app.cdn_cache_youtube_profile'))->append('/' . Str::of($banner)->append('=w1080-fcrop64=1,00005a57ffffa5a8-k-c0xffffffff-no-nd-rj') . '?test=test');
        }

        // Other
        else{
            return self::channelNull();
        }
    }
}
