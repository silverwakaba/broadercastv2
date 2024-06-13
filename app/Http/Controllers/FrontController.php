<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Repositories\Front\Creator\UserProfileRepositories;

use Illuminate\Http\Request;

// Hapus
use App\Models\UserLinkTracker;

class FrontController extends Controller{
    // Index
    public function index(){
        // Tracker Channel
        $tracker = UserProfileRepositories::getLinkTracker([
            'with'       => [
                'belongsToBaseLink',
                'belongsToUserLink',
                'belongsToActiveStream',
            ],
            'query'      => [
                ['streaming', '=', true],
            ],
            'option'     => [
                // 'take'       => 6,
                'aggregate'  => true,
                // 'pagination' => [
                //     'type' => 'normal',
                // ],
            ],
        ]);

        // Feed
        $feed = UserProfileRepositories::getFeed([
            'with'  => [
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            // 'query'      => [
            //     // ['streaming', '=', true],
            // ],

            'option'     => [
                'take'       => 6,
                'pagination' => [
                    'type' => 'cursor',
                ],
            ],
        ]);

        return view('pages/index', [
            'tracker'   => $tracker,
            'feed'      => $feed,
        ]);
    }
}
