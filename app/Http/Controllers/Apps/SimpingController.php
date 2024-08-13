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
        // return UserFeed::has('belongsToUserRelationFollowed')->get();

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
                'orderType'  => 'live',
                // 'simping'    => true,
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/apps/simp/index', [
            'datas' => $datas,
        ]);
    }
}
