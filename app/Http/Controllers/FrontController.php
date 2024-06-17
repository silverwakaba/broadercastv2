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

        // return $feed;

        return view('pages/index', [
            'feed' => $feed,
        ]);
    }
}
