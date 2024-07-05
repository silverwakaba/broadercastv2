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

        return Str::replaceFirst('https://', 'https://' . $bucket . '.', $endpoint);
    }

    public static function newName($path){
        $name = Str::of($path)->basename();

        return Str::replace('+', '_', urlencode($name));
    }

    public static function download($path, $name = null){
        $newName = $name ? $name : $path;

        return self::view($path, [
            'ResponseContentType'           => 'application/octet-stream',
            'ResponseContentDisposition'    => 'attachment; filename=' . self::newName($newName),
        ]);
    }

    public static function view($path, $params = null){
        return Str::replace(
            self::endpointOld(), self::endpointNew(),
            
            Storage::disk(self::disk())->temporaryUrl(
                $path, now()->addMinutes(self::expire()), ($params ? $params : [])
            ),
        );
    }
}
