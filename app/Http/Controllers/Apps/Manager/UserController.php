<?php

namespace App\Http\Controllers\Apps\Manager;

use App\Http\Controllers\Controller;

use App\Http\Requests\Apps\Setting\UserAvatarRequest;
use App\Http\Requests\Apps\Setting\UserBiodataRequest;

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

    // Biodata
    public function biodata(){
        $datas = UserRepositories::getProfile([
            'id'    => auth()->user()->id,
            'with'  => ['hasOneUserBiodata'],
        ]);

        return view('pages/apps/setting/user/biodata', [
            'datas' => $datas,
        ]);
    }

    public function biodataPost(UserBiodataRequest $request){
        return UserRepositories::biodata([
            'name'      => $request->name,
            'nickname'  => $request->nickname,
            'dob'       => $request->dob,
            'dod'       => $request->dod,
            'biography' => $request->biography,
        ]);
    }
}
