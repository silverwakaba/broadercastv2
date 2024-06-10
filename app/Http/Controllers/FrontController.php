<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Repositories\Front\Creator\UserProfileRepositories;

use Illuminate\Http\Request;

class FrontController extends Controller{
    // Index
    public function index(){
        return view('pages/blank');

        // Tracker Channel
        $tracker = UserProfileRepositories::getLinkTracker([
            'with'       => [
                'belongsToBaseLink',
                'belongsToUserLink',
                'belongsToActiveStream',
            ],
            'query'      => [
                // ['id', '=', 'xray'],
                ['streaming', '=', true],
            ],
            'option'     => [
                'take'      => 6,
                'aggregate' => true,
            ],
            'pagination' => true,
        ]);

        // Feed
        $feed = UserProfileRepositories::getFeed([
            'with'  => [
                'belongsToUser',
                'hasOneThroughUserAvatar',
                'belongsToBaseLink'
            ],
        ], true);

        // return $feed;

        if(request()->ajax()){
            return $feed;
        }

        return view('pages/index', [
            'tracker' => $tracker,
        ]);
    }
}
