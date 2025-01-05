<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;

use App\Repositories\Front\Creator\UserProfileRepositories;

use Illuminate\Http\Request;

// Hapus
use App\Models\User;
use App\Models\UserFeed;
use App\Models\UserRelation;

class SimpingController extends Controller{
    // Timeline
    public function index(){
        // Live
        $live = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 8],
            ],
            'option'    => [
                'take'       => 3,
                'orderType'  => 'live',
                'simping'    => true,
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        // Upcoming Schedule
        $schedule = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 7],
            ],
            'option'    => [
                'take'       => 3,
                'orderType'  => 'schedule',
                'dayLoad'    => 30,
                'simping'    => true,
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/apps/simp/index', [
            'live'      => $live,
            'schedule'  => $schedule,
        ]);
    }

    // Live
    public function live(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 8],
            ],
            'option'    => [
                'take'       => 4,
                'orderType'  => 'live',
                'simping'    => true,
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/apps/simp/live', [
            'datas' => $datas,
        ]);
    }

    // Scheduled
    public function scheduled(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 7],
            ],
            'option'    => [
                'take'       => 3,
                'orderType'  => 'schedule',
                'dayLoad'    => 30,
                'simping'    => true,
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/apps/simp/scheduled', [
            'datas' => $datas,
        ]);
    }

    // Archived
    public function archived(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 9],
            ],
            'option'    => [
                'take'       => 3,
                'orderType'  => 'archive',
                'simping'    => true,
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/apps/simp/archived', [
            'datas' => $datas,
        ]);
    }

    public function uploaded(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 10],
            ],
            'option'    => [
                'take'       => 3,
                'orderType'  => 'vod',
                'simping'    => true,
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/apps/simp/uploaded', [
            'datas' => $datas,
        ]);
    }
}
