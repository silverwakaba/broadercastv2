<?php

namespace App\Http\Controllers\Apps\Base;

use App\Http\Controllers\Controller;
// use App\Http\Requests\Apps\Base\LinkRequest;
// use App\Repositories\Base\BaseRepositories;
use Illuminate\Http\Request;

class AffiliationController extends Controller{
    // Constructor
    public function __construct(){
        $this->back = 'apps.base.affiliation.index';
        $this->model = 'App\Models\BaseAffiliation';
        $this->resource = 'App\Http\Resources\BaseAffiliationResource';
    }

    // Index
    public function index(){
        if(request()->ajax()){
            return BaseRepositories::datatable([
                'model'     => $this->model,
                'resource'  => $this->resource,
                'route'     => 'apps.base.affiliation',
                // 'with'      => ['belongsToBaseDecision', 'hasOneUser'],
            ]);
        }

        return view('pages/apps/base/affiliation/index');
    }
}
