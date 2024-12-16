<?php

namespace App\Http\Controllers\Apps\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apps\Base\ProxyTypeRequest;
use App\Repositories\Base\BaseRepositories;
use Illuminate\Http\Request;

class ProxyTypeController extends Controller{
    // Constructor
    public function __construct(){
        $this->back = 'apps.base.proxy.type.index';
        $this->model = 'App\Models\BaseProxyType';
        $this->resource = 'App\Http\Resources\BaseProxyTypeResource';
    }

    // Index
    public function index(){
        if(request()->ajax()){
            return BaseRepositories::datatable([
                'model'     => $this->model,
                'resource'  => $this->resource,
                'route'     => 'apps.base.proxy.type',
            ]);
        }

        return view('pages/apps/base/proxy/type/index');
    }

    // Add
    public function add(){
        return view('pages/apps/base/proxy/type/add');
    }

    public function addPost(ProxyTypeRequest $request){
        return BaseRepositories::upsert($this->model, [
            'name' => $request->name,
        ], $this->back);
    }

    // Edit
    public function edit($id){
        $datas = BaseRepositories::find([
            'id'    => $id,
            'model' => $this->model,
        ]);
        
        return view('pages/apps/base/proxy/type/edit', [
            'data' => $datas,
        ]);
    }

    public function editPost(ProxyTypeRequest $request, $id){
        return BaseRepositories::upsert($this->model, [
            'name' => $request->name,
        ], $this->back, $id);
    }

    // Delete
    public function delete($id){
        return BaseRepositories::delete([
            'id'    => $id,
            'model' => $this->model,
        ], $this->back, 'Proxy Type');
    }
}
