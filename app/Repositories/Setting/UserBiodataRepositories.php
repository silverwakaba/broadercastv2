<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Http\Resources\UserResource;

use App\Models\User;

class UserBiodataRepositories{
    public static function update(array $data){
        $user = User::find(auth()->user()->id);

        $user->update([
            'name' => $data['name'],
        ]);

        $user->hasOneUserBiodata()->update([
            'nickname'  => $data['nickname'],
            'dob'       => $data['dob'],
            'dod'       => $data['dod'],
            'biography' => $data['biography'],
        ]);

        return RedirectHelper::routeBack(null, 'success', 'Biodata', 'update');
    }
}
