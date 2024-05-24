<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;

use App\Http\Resources\UserResource;

use App\Models\User;

class UserProfileRepositories{
    public static function getProfile(array $data, $resource = false){
        $user = User::with(isset($data['with']) ? $data['with'] : [])->where([
            ['id', '=', $data['id']],
        ])->firstOrFail();

        if($resource == true){
            return new UserResource($user);
        }

        return $user;
    }
}
