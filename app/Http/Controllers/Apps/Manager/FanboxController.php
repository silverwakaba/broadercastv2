<?php

namespace App\Http\Controllers\Apps\Manager;
use App\Http\Controllers\Controller;

use App\Helpers\BaseHelper;
use App\Helpers\BasedataHelper;

use App\Repositories\Setting\UserFanboxRepositories;

use Illuminate\Http\Request;

class FanboxController extends Controller{
    // Constructor
    public function __construct(){
        $this->back = route('apps.manager.index');
        $this->backFanbox = route('apps.manager.fanbox.index');
    }

    // Index
    public function index(){
        if(request()->ajax()){
            return UserFanboxRepositories::datatable([
                'id'    => auth()->user()->id,
                'route' => 'apps.manager.fanbox',
            ]);
        }

        return view('pages/apps/setting/fanbox/index', [
            'backURI'   => $this->back,
            'addURI'    => route('apps.manager.fanbox.add'),
        ]);
    }

    // Add
    public function add(){
        return view('pages/apps/setting/fanbox/add', [
            'backURI'   => $this->backFanbox,
            'boolean'   => BasedataHelper::baseBoolean(),
        ]);
    }

    public function addPost(Request $request){
        return UserFanboxRepositories::upsert([
            'users_id'      => auth()->user()->id,
            'public'        => (boolean) $request->public,
            'title'         => $request->title,
            'description'   => $request->description,
        ], 'apps.manager.fanbox.index');
    }

    // Edit
    public function edit($id){
        $datas = UserFanboxRepositories::find([
            'id'    => $id,
            'uid'   => auth()->user()->id,
        ]);

        return view('pages/apps/setting/fanbox/edit', [
            'backURI'   => $this->backFanbox,
            'boolean'   => BasedataHelper::baseBoolean(),
            'datas'     => $datas,
        ]);
    }

    public function editPost(Request $request, $id){
        return UserFanboxRepositories::upsert([
            'public'        => (boolean) $request->public,
            'active'        => (boolean) $request->active,
            'title'         => $request->title,
            'description'   => $request->description,
        ], null, $id); // null or 'apps.manager.fanbox.index'
    }

    // Delete
    public function delete($id){
        return $datas = UserFanboxRepositories::delete([
            'id'    => $id,
            'uid'   => auth()->user()->id,
        ]);
    }

    // View
    public function view($id){
        return $id;
    }
}
