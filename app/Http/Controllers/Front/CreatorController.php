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
        // Profile
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
            ],
        ]);

        // Link
        $link = UserProfileRepositories::getLink([
            'query' => [
                ['users_id', '=', $profile->id],
            ],
        ]);

        // Tracker Channel
        $tracker = UserProfileRepositories::getLinkTracker([
            'with'  => [
                'belongsToBaseLink',
                'belongsToUserLink',
                // 'belongsToActiveStream',
            ],
            'query' => [
                ['users_id', '=', $profile->id],
            ],
        ]);

        $feed = UserProfileRepositories::getFeed([
            'with'  => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query' => [
                ['users_id', '=', $profile->id],
            ],
            'option'     => [
                'take'      => 3,
                'orderType' => 'all',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/creator/profile', [
            'profile'   => $profile,
            'link'      => $link,
            'tracker'   => $tracker,
            'feed'      => $feed,
        ]);
    }
}
