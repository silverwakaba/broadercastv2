<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Http\Resources\UserResource;

use App\Models\User;

use Illuminate\Support\Str;

class UserBiodataRepositories{
    public static function update(array $data){
        $user = User::find($data['id']);

        if(($user->confirmed == true) || ($user->email_verified_at !== null)){
            $name = Str::of($data['name'])->slug('-');

            $before = Str::before($user->identifier, '.');

            $after = Str::after($user->identifier, '.');

            if($name !== $after){
                $identifier = $before . '.' . Str::of($data['name'])->slug('-');
            
                $user->update([
                    'identifier' => $identifier,
                ]);
            }
        }

        $user->update([
            'name' => $data['name'],
        ]);

        $user->hasOneUserBiodata()->update([
            'nickname'  => $data['nickname'],
            'dob'       => $data['dob'],
            'dod'       => $data['dod'],
            'dor'       => $data['dor'],
            'biography' => $data['biography'],
        ]);

        return RedirectHelper::routeBack(null, 'success', 'Biodata', 'update');
    }
}
