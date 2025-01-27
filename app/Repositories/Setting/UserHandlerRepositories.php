<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Models\User;

use Illuminate\Support\Str;

class UserHandlerRepositories{
    public static function update(array $data){
        try{
            $user = User::find($data['id']);

            $user->update([
                'sitemaped'     => false,
                'identifier'    => BaseHelper::setIdentifier($data['handler'], $user->identifier, $user->name),
            ]);

            return RedirectHelper::routeBack(null, 'success', 'Handler', 'update');
        }
        catch(\Throwable $th){
            return RedirectHelper::routeBack(null, 'error', 'Handler', 'update');
        }
    }
}
