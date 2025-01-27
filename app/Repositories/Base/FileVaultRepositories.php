<?php

namespace App\Repositories\Base;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileVaultRepositories{
    public static function disk(){
        return config('filesystems.private');
    }

    public static function expire(){
        return 3600;
    }

    public static function endpointNew(){
        return config('app.cdn_private_url_r2');
    }

    public static function endpointOld(){
        $bucket = config('filesystems.disks.' . self::disk() . '.bucket');
        $endpoint = config('filesystems.disks.' . self::disk() . '.endpoint');

        return Str::replaceFirst('https://', 'https://' . $bucket . '.', $endpoint);
    }

    public static function newName($path){
        $name = Str::of($path)->basename();

        return Str::replace('+', '_', urlencode($name));
    }

    public static function download($path, $expire = 1, $name = null){
        $newName = $name ? $name : $path;

        return self::view($path, $expire = 1, [
            'ResponseContentType'           => 'application/octet-stream',
            'ResponseContentDisposition'    => 'attachment; filename=' . self::newName($newName),
        ]);
    }

    public static function view($path, $expire = 1, $params = null){
        return Str::replace(
            self::endpointOld(), self::endpointNew(), Storage::disk(self::disk())->temporaryUrl(
                $path, now()->addMinutes(self::expire() * $expire), ($params ? $params : [])
            ),
        );
    }
}
