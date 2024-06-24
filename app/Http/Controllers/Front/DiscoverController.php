<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Repositories\Front\Creator\UserProfileRepositories;

use Illuminate\Http\Request;

class DiscoverController extends Controller{
    public function index(){}

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
                'take'       => 3,
                'orderType' => 'live',
                'pagination' => [
                    'type' => 'cursor',
                ],
            ],
        ]);

        return view('pages/front/discover/live', [
            'datas' => $datas,
        ]);
    }

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
                'take'       => 3,
                'orderType' => 'upcoming',
                'pagination' => [
                    'type' => 'cursor',
                ],
            ],
        ]);

        return view('pages/front/discover/scheduled', [
            'datas' => $datas,
        ]);
    }

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
                'take'       => 3,
                'orderType' => 'archive',
                'pagination' => [
                    'type' => 'cursor',
                ],
            ],
        ]);

        return view('pages/front/discover/scheduled', [
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
                'take'       => 3,
                'pagination' => [
                    'type' => 'cursor',
                ],
            ],
        ]);

        return view('pages/front/discover/uploaded', [
            'datas' => $datas,
        ]);
    }
}
