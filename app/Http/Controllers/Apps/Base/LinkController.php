<?php

namespace App\Http\Controllers\Apps\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apps\Base\LinkRequest;
use App\Repositories\Base\BaseRepositories;
use Illuminate\Http\Request;

class LinkController extends Controller{
    // Constructor
    public function __construct(){
        $this->back = 'apps.base.link.index';
        $this->model = 'App\Models\BaseLink';
        $this->resource = 'App\Http\Resources\BaseLinkResource';
    }

    // Index
    public function index(){
        if(request()->ajax()){
            return BaseRepositories::datatable([
                'model'     => $this->model,
                'resource'  => $this->resource,
                'route'     => 'apps.base.link',
                'with'      => ['belongsToBaseDecision', 'hasOneUser'],
            ]);
        }

        return view('pages/apps/base/link/index');
    }

    // Add
    public function add(){
        return view('pages/apps/base/link/add');
    }

    public function addPost(LinkRequest $request){
        return BaseRepositories::upsert($this->model, [
            'users_id'          => auth()->user()->id,
            'base_decision_id'  => '6',
            'name'              => $request->name,
            'icon'              => $request->icon,
            'color'             => $request->color,
            'checking'          => $request->checking ? true : false,
        ], $this->back);
    }

    // Edit
    public function edit($id){
        $datas = BaseRepositories::find([
            'id'    => $id,
            'model' => $this->model,
        ]);
        
        return view('pages/apps/base/link/edit', [
            'data' => $datas,
        ]);
    }

    public function editPost(LinkRequest $request, $id){
        return BaseRepositories::upsert($this->model, [
            'name'      => $request->name,
            'icon'      => $request->icon,
            'color'     => $request->color,
            'checking'  => $request->checking ? true : false,
        ], $this->back, $id);
    }

    // Decision
    public function decision(Request $request, $id){
        return BaseRepositories::decision([
            'id'        => $id,
            'model'     => $this->model,
            'action'    => $request->action,
        ], $this->back);
    }

    // Delete
    public function delete($id){
        return BaseRepositories::delete([
            'id'    => $id,
            'model' => $this->model,
        ], $this->back);
    }
}
