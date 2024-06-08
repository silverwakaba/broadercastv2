<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Repositories\Front\Creator\UserProfileRepositories;

use Illuminate\Http\Request;

class FrontController extends Controller{
    // Index
    public function index(){
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

        return view('pages/index');
    }
}
