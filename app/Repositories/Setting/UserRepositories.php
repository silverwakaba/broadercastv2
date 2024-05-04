<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;

use App\Models\User;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserRepositories{
    public static function avatar($data){
        $dir = 'system/avatar';

        $user = User::find(auth()->user()->id);

        $storage = Storage::disk('s3public'); // s3public

        if($user->hasOneUserAvatar->path){
            $storage->delete($dir . '/' . $user->hasOneUserAvatar->path);
        }

        $avatar = $storage->put($dir, $data);

        $user->hasOneUserAvatar()->update([
            'path' => Str::of($avatar)->basename(),
        ]);

        return back()->with('class', 'success')->with('message', "Your avatar is changed successfully.");
    }
}
