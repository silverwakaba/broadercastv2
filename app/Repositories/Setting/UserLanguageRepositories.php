<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\User;

class UserLanguageRepositories{
    public static function sync(array $data){
        try{
            $user = User::find($data['id']);

            $user->belongsToManyUserLanguage()->sync($data['data']);

            return RedirectHelper::routeBack(null, 'success', 'Your Main Language', 'update');
        }
        catch(\Throwable $th){
            return RedirectHelper::routeBack(null, 'error', 'Your Main Language', 'update');
        }
    }
}
