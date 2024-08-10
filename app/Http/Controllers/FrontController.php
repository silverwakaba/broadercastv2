<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Repositories\Front\Creator\UserProfileRepositories;

use Illuminate\Http\Request;

class FrontController extends Controller{
    // Index
    public function index(){
        // Live
        $live = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 8],
            ],
            'option'    => [
                'take'      => 4,
                'orderType' => 'live',
                'dayLoad'   => 7,
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
            ],
            'option'    => [
                'take'      => 4,
                'orderType' => 'schedule',
                'dayLoad'   => 7,
            ],
        ]);

        return view('pages/index', [
            'live'      => $live,
            'schedule'  => $schedule,
        ]);
    }
}
