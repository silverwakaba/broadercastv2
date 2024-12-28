<?php

namespace App\Http\Controllers\Apps\Manager;
use App\Http\Controllers\Controller;

use App\Helpers\BaseHelper;
use App\Helpers\BasedataHelper;

use App\Repositories\Setting\UserFanboxRepositories;
use App\Repositories\Setting\UserFanboxSubmissionRepositories;

use Illuminate\Http\Request;

class FanboxSubmissionController extends Controller{
    // Constructor
    public function __construct(){
        $this->back = route('apps.manager.fanbox.index');
    }

    // Index
    public function index($id){
        $question = UserFanboxRepositories::find([
            'id'    => $id,
            'uid'   => auth()->user()->id,
        ]);

        $datas = UserFanboxSubmissionRepositories::index([
            'id'    => $question->id,
            'with'  => ['belongsToUser', 'hasOneThroughUserAvatar'],
        ]);

        return view('pages/apps/setting/fanbox/view', [
            'backURI'   => $this->back,
            'question'  => $question,
            'datas'     => $datas,
        ]);
    }

    public function delete($id){
        return $datas = UserFanboxSubmissionRepositories::delete([
            'id'    => $id,
            'did'   => request()->did,
            'page'  => request()->page,
        ]);
    }
}
