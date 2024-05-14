<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\User;

class UserLanguageRepositories{
    public static function sync($data){
        $user = User::find(auth()->user()->id);

        $user->belongsToManyUserLanguage()->sync($data);

        return RedirectHelper::routeBack(null, 'success', 'Your Main Language', 'update');
    }
}
