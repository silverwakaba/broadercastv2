<?php

namespace App\Repositories\Setting;

use App\Helpers\RedirectHelper;

use App\Models\User;

use Illuminate\Support\Str;

class UserBiodataRepositories{
    public static function update(array $data){
        $user = User::find($data['id']);

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
