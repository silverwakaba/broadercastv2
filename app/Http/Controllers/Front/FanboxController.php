<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use App\Helpers\BaseHelper;
use App\Helpers\BasedataHelper;

use App\Http\Requests\Apps\Setting\UserFanboxSubmissionRequest;

use App\Repositories\Setting\UserFanboxRepositories;
use App\Repositories\Setting\UserFanboxSubmissionRepositories;

use Illuminate\Http\Request;

class FanboxController extends Controller{
    // Index
    public function index(){
        return "Index";
    }

    // Answer
    public function answer($id){
        $datas = UserFanboxRepositories::find([
            'id'        => $id,
            'resource'  => true,
            'with'      => ['belongsToUser', 'hasOneThroughUserAvatar'],
        ]);

        return view('pages/front/fanbox/answer/view', [
            'boolean'   => BasedataHelper::baseBoolean(),
            'datas'     => $datas,
        ]);
    }

    public function answerPost(UserFanboxSubmissionRequest $request, $id){
        return UserFanboxSubmissionRepositories::upsert([
            'id'        => $id,
            'anonymous' => $request->anonymous,
            'message'   => $request->answer,
        ]);
    }

    // Edit answer
    public function answerEdit($id, $did){
        $datas = UserFanboxSubmissionRepositories::find([
            'id'        => $id,
            'did'       => $did,
            'resource'  => true,
            'with'      => ['hasOneThroughUser', 'hasOneThroughUserAvatar', 'belongsToUserFanbox'],
        ]);

        return view('pages/front/fanbox/answer/edit', [
            'boolean'   => BasedataHelper::baseBoolean(),
            'datas'     => $datas,
        ]);
    }

    public function answerEditPost(UserFanboxSubmissionRequest $request, $id, $did){
        return UserFanboxSubmissionRepositories::upsert([
            'id'        => $id,
            'anonymous' => $request->anonymous,
            'message'   => $request->answer,
        ], null, $did);
    }
}
