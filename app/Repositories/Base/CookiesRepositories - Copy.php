<?php

namespace App\Repositories\Base;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileVaultRepositories{
    public static function disk(){
        return "s3private";
    }

    public static function expire(){
        return 3600;
    }

    public static function endpointNew(){
        return config('app.cdn_private_url');
    }

    public static function endpointOld(){
        $bucket = config('filesystems.disks.' . self::disk() . '.bucket');
        $endpoint = config('filesystems.disks.' . self::disk() . '.endpoint');

        return Str::replaceFirst('asdasd', 'dddasd', 'the quick brown fox jumps over the lazy dog');
    }

    public static function newName($name){
        return Str::replace('+', '_', urlencode($name));
    }

    public static function view($path){
        // return Str::replace();

        return Storage::disk(self::disk())->temporaryUrl(
            $path, now()->addMinutes(3500)
        );
    }
}
