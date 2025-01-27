<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\User;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserAvatarRepositories{
    public static function change($data){
        try{
            $dir = 'app/avatar';

            $user = User::find(auth()->user()->id);

            $storage = Storage::disk(config('filesystems.public'));

            if($user->hasOneUserAvatar->path){
                $storage->delete($dir . '/' . $user->hasOneUserAvatar->path);
            }

            $avatar = $storage->put($dir, $data);

            $user->hasOneUserAvatar()->update([
                'path' => Str::of($avatar)->basename(),
            ]);

            return RedirectHelper::routeBack(null, 'success', 'Avatar', 'update');
        }
        catch(\Throwable $th){
            return RedirectHelper::routeBack(null, 'error', 'Avatar', 'update');
        }
    }
}
