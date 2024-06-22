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
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['streaming', '=', true],
                ['streaming_archive', '=', null],
                ['actual_end', '=', null],
                ['duration', '=', "P0D"],
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
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['streaming', '=', false],
                ['schedule', '!=', null],
                ['actual_end', '=', null],
                ['duration', '=', "P0D"],
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
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'      => [
                ['streaming', '=', false],
                ['actual_end', '!=', null],
                ['duration', '!=', "P0D"],
            ],
            'option'     => [
                'take'      => 15,
                'orderType' => 'archive',
                // 'pagination' => [
                //     'type' => 'cursor',
                // ],
            ],
        ]);

        return view('pages/index', [
            'feedLive' => $feedLive,
            'feedArchive' => $feedArchive,
        ]);
    }
}
