<?php

namespace App\Http\Controllers\Apps\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apps\Base\ProxyTypeRequest;
use App\Repositories\Base\BaseRepositories;
use Illuminate\Http\Request;

class ProxyHostController extends Controller{
    // Constructor
    public function __construct(){
        $this->back = 'apps.base.proxy.host.index';
        $this->model = 'App\Models\BaseProxyHost';
        $this->resource = 'App\Http\Resources\BaseProxyHostResource';
    }

    // Index
    public function index(){
        if(request()->ajax()){
            return BaseRepositories::datatable([
                'model'     => $this->model,
                'resource'  => $this->resource,
                'route'     => 'apps.base.proxy.host',
                'orderBy'   => ['base_proxy_type_id', 'ASC'],
                'with'      => ['belongsToBaseProxyType'],
            ]);
        }

        return view('pages/apps/base/proxy/host/index');
    }

    // Add
    public function add(){
        return view('pages/apps/base/proxy/host/add');
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
        
        return view('pages/apps/base/proxy/host/edit', [
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
        ], $this->back, 'Proxy Host');
    }
}
