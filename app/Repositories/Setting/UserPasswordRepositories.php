<?php

namespace App\Repositories\Setting;

use App\Helpers\RedirectHelper;

use App\Models\User;

use Illuminate\Support\Str;

class UserPasswordRepositories{
    public static function update(array $data){
        try{
            $user = User::find($data['id']);

            $user->update([
                'password' => bcrypt($data['new_password']),
            ]);

            return RedirectHelper::routeBack(null, 'success', 'Password', 'update');
        }
        catch(\Throwable $th){
            return RedirectHelper::routeBack(null, 'error', 'Password', 'update');
        }
    }
}
