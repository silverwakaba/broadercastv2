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

        // BENTARAN YA
        $live = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 8],
                ['users_id', '=', $profile->id],
            ],
            'option'    => [
                'take'       => 4,
                'orderType' => 'live',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        // Upcoming Schedule
        $schedule = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 7],
                ['users_id', '=', $profile->id],
            ],
            'option'    => [
                'take'       => 4,
                'orderType' => 'schedule',
                'dayLoad'   => 7,
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        // $feed = UserProfileRepositories::getFeed([
        //     'with'  => [
        //         'belongsToUser',
        //         'hasOneThroughUserLink',
        //         'belongsToUserLinkTracker',
        //     ],
        //     'query' => [
        //         ['users_id', '=', $profile->id],
        //     ],
        //     'option'     => [
        //         'take'      => 6,
        //         'orderType' => 'all',
        //         'pagination' => [
        //             'type' => 'normal',
        //         ],
        //     ],
        // ]);

        return view('pages/front/creator/profile', [
            'profile'   => $profile,
            'link'      => $link,
            'tracker'   => $tracker,
            
            // Kela
            'live'      => $live,
            'schedule'  => $schedule,
        ]);
    }
}
