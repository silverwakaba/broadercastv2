<?php

namespace App\Repositories\Setting;

// use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

// use App\Http\Resources\UserResource;

use App\Models\User;

use Illuminate\Support\Str;

class UserEmailRepositories{
    public static function update(array $data){
        $user = User::find($data['id']);

        $user->update([
            'email' => $data['email'],
        ]);

        return RedirectHelper::routeBack(null, 'success', 'Email', 'update');
    }
}
