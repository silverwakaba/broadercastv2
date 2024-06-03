<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;

use App\Http\Resources\UserResource;

use App\Models\User;

class UserProfileRepositories{
    public static function getProfile(array $data, $resource = true){
        $user = User::with(isset($data['with']) ? $data['with'] : [])->where([
            ['id', '=', $data['id']],
        ])->firstOrFail();

        if($resource == false){
            return $user;
        }

        return BaseHelper::resourceToJson(new UserResource($user));
    }
}
