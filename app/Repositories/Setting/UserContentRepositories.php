<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\User;

class UserContentRepositories{
    public static function sync(array $data){
        try{
            $user = User::find($data['id']);

            $user->belongsToManyUserContent()->sync($data['data']);

            return RedirectHelper::routeBack(null, 'success', 'Your Focus Content', 'update');
        }
        catch(\Throwable $th){
            return RedirectHelper::routeBack(null, 'error', 'Your Focus Content', 'update');
        }
    }
}
