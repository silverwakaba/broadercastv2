<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Repositories\Front\Creator\UserProfileRepositories;

use Illuminate\Http\Request;

class FrontController extends Controller{
    // Index
    public function index(){
        // Feed Live
        $feedLive = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 7],
            ],
            'option'    => [
                'take'       => 15,
                'orderType' => 'live',
                // 'pagination' => [
                //     'type' => 'cursor',
                // ],
            ],
        ]);

        // Feed Upcoming
        $feedUpcoming = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 8],
            ],
            'option'    => [
                'take'       => 15,
                'orderType' => 'upcoming',
                // 'pagination' => [
                //     'type' => 'cursor',
                // ],
            ],
        ]);

        // Feed Archive
        $feedArchive = UserProfileRepositories::getFeed([
            'with'  => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'      => [
                ['base_status_id', '=', 9],
            ],
            'option'     => [
                'take'      => 15,
                'orderType' => 'archive',
                // 'pagination' => [
                //     'type' => 'cursor',
                // ],
            ],
        ]);

        // Uploaded Content
        $feedUploaded = UserProfileRepositories::getFeed([
            'with'  => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'      => [
                ['base_status_id', '=', 10],
            ],
            'option'     => [
                'take'      => 15,
                // 'pagination' => [
                //     'type' => 'cursor',
                // ],
            ],
        ]);

        return view('pages/index', [
            'feedLive'      => $feedLive,
            'feedUpcoming'  => $feedUpcoming,
            'feedArchive'   => $feedArchive,
            'feedUploaded'  => $feedUploaded,
        ]);
    }
}
