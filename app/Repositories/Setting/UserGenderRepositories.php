<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\User;

class UserGenderRepositories{
    public static function sync($data){
        $user = User::find(auth()->user()->id);

        $user->belongsToManyUserGender()->sync($data);
        
        return RedirectHelper::routeBack(null, 'success', 'Your Gender Representation', 'update');
    }
}
