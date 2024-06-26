<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\User;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserAvatarRepositories{
    public static function change($data){
        $dir = 'project/broadercast/system/avatar';

        $user = User::find(auth()->user()->id);

        $storage = Storage::disk('s3public');

        if($user->hasOneUserAvatar->path){
            $storage->delete($dir . '/' . $user->hasOneUserAvatar->path);
        }

        $avatar = $storage->put($dir, $data);

        $user->hasOneUserAvatar()->update([
            'path' => Str::of($avatar)->basename(),
        ]);

        return RedirectHelper::routeBack(null, 'success', 'Avatar', 'update');
    }
}
