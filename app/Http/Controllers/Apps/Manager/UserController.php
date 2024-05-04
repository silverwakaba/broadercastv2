<?php

namespace App\Http\Controllers\Apps\Manager;

use App\Http\Controllers\Controller;

use App\Http\Requests\Apps\Setting\UserAvatarRequest;

use App\Repositories\Setting\UserRepositories;

use Illuminate\Http\Request;

class UserController extends Controller{
    // Avatar
    public function avatar(){
        return view('pages/apps/setting/user/avatar');
    }

    public function avatarPost(UserAvatarRequest $request){
        return UserRepositories::avatar($request->avatar);
    }
}
