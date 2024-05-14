<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\User;

class UserContentRepositories{
    public static function sync($data){
        $user = User::find(auth()->user()->id);

        $user->belongsToManyUserContent()->sync($data);

        return RedirectHelper::routeBack(null, 'success', 'Your Focus Content', 'update');
    }
}
