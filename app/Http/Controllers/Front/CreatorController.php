<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Repositories\Front\Creator\UserProfileRepositories;

use Illuminate\Http\Request;

class CreatorController extends Controller{
    // Index
    public function index(){
        return "List semua creator";
    }

    // Profile
    public function profile($id){
        $profile = UserProfileRepositories::getProfile([
            'identifier'    => $id,
            'with'          => [
                'hasOneUserAvatar',
                'hasOneUserBiodata',
                'belongsToManyUserContent',
                'belongsToManyUserGender',
                'belongsToManyUserLanguage',
                'belongsToManyUserRace',
                'belongsToManyUserLink',
                'belongsToManyUserLinkTracker',
            ],
        ]);

        $tracker = UserProfileRepositories::getLinkTracker([
            'id' => $profile->id,
        ]);

        // return $tracker;

        // $feed = UserProfileRepositories::getFeed([
        //     'id' => $profile->id,
        // ], true);

        return view('pages/front/creator/profile', [
            'profile' => $profile,
            'tracker' => $tracker,
        ]);
    }
}
