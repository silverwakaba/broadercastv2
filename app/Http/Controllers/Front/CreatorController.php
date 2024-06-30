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
                'take'       => 4,
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

    // Live
    public function live(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 8],
            ],
            'option'    => [
                'take'       => 4,
                'orderType' => 'normal',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/creator/live', [
            'datas' => $datas,
        ]);
    }

    // Scheduled
    public function scheduled(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 7],
            ],
            'option'    => [
                'take'       => 4,
                'orderType' => 'normal',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/creator/scheduled', [
            'datas' => $datas,
        ]);
    }

    // Archived
    public function archived(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 9],
            ],
            'option'    => [
                'take'       => 4,
                'orderType' => 'normal',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/creator/archived', [
            'datas' => $datas,
        ]);
    }

    public function uploaded(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 10],
            ],
            'option'    => [
                'take'       => 4,
                'orderType' => 'vod',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/creator/uploaded', [
            'datas' => $datas,
        ]);
    }
}
