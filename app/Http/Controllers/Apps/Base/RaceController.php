<?php

namespace App\Http\Controllers\Apps\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apps\Base\RaceRequest;
use App\Repositories\Base\BaseRepositories;
use Illuminate\Http\Request;

class RaceController extends Controller{
    // Constructor
    public function __construct(){
        $this->back = 'apps.base.race.index';
        $this->model = 'App\Models\BaseRace';
        $this->resource = 'App\Http\Resources\BaseRaceResource';
    }

    // Index
    public function index(Request $request){
        if(request()->ajax()){
            return BaseRepositories::datatable([
                'model'     => $this->model,
                'resource'  => $this->resource,
                'route'     => 'apps.base.race',
                'with'      => ['belongsToBaseDecision', 'hasOneUser'],
            ]);
        }

        return view('pages/apps/base/race/index');
    }

    // Add
    public function add(){
        return view('pages/apps/base/race/add');
    }

    public function addPost(RaceRequest $request){
        return BaseRepositories::upsert($this->model, [
            'users_id'          => auth()->user()->id,
            'base_decision_id'  => '6',
            'name'              => $request->name,
        ], $this->back);
    }

    // Edit
    public function edit($id){
        $datas = BaseRepositories::find([
            'id'    => $id,
            'model' => $this->model,
        ]);
        
        return view('pages/apps/base/race/edit', [
            'data' => $datas,
        ]);
    }

    public function editPost(RaceRequest $request, $id){
        return BaseRepositories::upsert($this->model, [
            'name' => $request->name,
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
