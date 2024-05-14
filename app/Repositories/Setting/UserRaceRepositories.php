<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\User;

class UserRaceRepositories{
    public static function sync($data){
        $user = User::find(auth()->user()->id);

        $user->belongsToManyUserRace()->sync($data);

        return RedirectHelper::routeBack(null, 'success', 'Your Character Race', 'update');
    }
}
