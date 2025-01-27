<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\User;

class UserRaceRepositories{
    public static function sync(array $data){
        try{
            $user = User::find($data['id']);

            $user->belongsToManyUserRace()->sync($data['data']);

            return RedirectHelper::routeBack(null, 'success', 'Your Character Persona', 'update');
        }
        catch(\Throwable $th){
            return RedirectHelper::routeBack(null, 'error', 'Your Character Persona', 'update');
        }
    }
}
