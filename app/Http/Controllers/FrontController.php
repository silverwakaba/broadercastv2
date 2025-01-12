<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Repositories\Front\Creator\UserProfileRepositories;

use Illuminate\Http\Request;

// Debug
use App\Helpers\BaseHelper;
use Illuminate\Support\Facades\Http;

class FrontController extends Controller{
    public function fetchDebug(){
        $http = Http::withOptions([
            'proxy' => BaseHelper::baseProxy(),
        ])->get('http://ip-api.com/json')->json();

        return $http;
    }

    // Index
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
                'take'      => 4,
                'orderType' => 'live',
                'dayLoad'   => 7,
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
