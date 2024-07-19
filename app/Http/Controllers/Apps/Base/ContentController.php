<?php

namespace App\Http\Controllers\Apps\Base;
use App\Http\Controllers\Controller;

use App\Http\Requests\Apps\Base\ContentRequest;
use App\Repositories\Base\BaseRepositories;

use Illuminate\Http\Request;

class ContentController extends Controller{
    // Constructor
    public function __construct(){
        $this->title = 'Content Type';
        $this->back = 'apps.base.content.index';
        $this->model = 'App\Models\BaseContent';
        $this->resource = 'App\Http\Resources\BaseContentResource';
    }

    // Index
    public function index(){
        if(request()->ajax()){
            return BaseRepositories::datatable([
                'model'     => $this->model,
                'resource'  => $this->resource,
                'route'     => 'apps.base.content',
                'with'      => ['belongsToBaseDecision', 'hasOneUser'],
            ]);
        }

        return view('pages/apps/base/content/index');
    }

    // Add
    public function add(){
        return view('pages/apps/base/content/add');
    }

    public function addPost(ContentRequest $request){
        return BaseRepositories::upsert($this->model, [
            'users_id'          => auth()->user()->id,
            'base_decision_id'  => '6',
            'name'              => $request->name,
        ], $this->back, null, $this->title);
    }

    // Edit
    public function edit($id){
        $datas = BaseRepositories::find([
            'id'    => $id,
            'model' => $this->model,
        ]);
        
        return view('pages/apps/base/content/edit', [
            'data' => $datas,
        ]);
    }

    public function editPost(ContentRequest $request, $id){
        return BaseRepositories::upsert($this->model, [
            'name' => $request->name,
        ], $this->back, $id, $this->title);
    }

    // Decision
    public function decision(Request $request, $id){
        return BaseRepositories::decision([
            'id'        => $id,
            'model'     => $this->model,
            'action'    => $request->action,
        ], $this->back, $this->title);
    }

    // Delete
    public function delete($id){
        return BaseRepositories::delete([
            'id'    => $id,
            'model' => $this->model,
        ], $this->back, $this->title);
    }
}
