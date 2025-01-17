<?php

namespace App\Http\Controllers\Apps\Base;

use App\Http\Controllers\Controller;

use App\Helpers\RedirectHelper;
use App\Http\Requests\Apps\Base\AffiliationRequest;
use App\Repositories\Base\AffiliationRepositories;
use Illuminate\Http\Request;

class AffiliationController extends Controller{
    // Constructor
    public function __construct(){
        $this->back = 'apps.base.affiliation.index';
    }

    // Index
    public function index(){
        if(request()->ajax()){
            return AffiliationRepositories::datatable([
                'with'  => ['hasOneUser', 'belongsToBaseDecision'],
                'route' => 'apps.base.affiliation',
            ]);
        }

        return view('pages/apps/base/affiliation/index');
    }

    // Add
    public function add(){
        return view('pages/apps/base/affiliation/add');
    }

    public function addPost(Request $request){
        $explode = explode(PHP_EOL, $request->name);

        if(count($explode) == 1){
            return AffiliationRepositories::upsert([
                'name'  => $request->name,
            ], $this->back);
        }
        else{
            foreach($explode AS $name){
                AffiliationRepositories::upsert([
                    'name' => $name,
                ]);
            }

            return RedirectHelper::routeBack($this->back, 'success', 'Affiliation', 'create');
        }
    }

    // Edit
    public function edit($id){
        $datas = AffiliationRepositories::find([
            'id' => $id,
        ]);

        return view('pages/apps/base/affiliation/edit', [
            'data' => $datas,
        ]);
    }

    public function editPost(AffiliationRequest $request, $id){
        return AffiliationRepositories::upsert([
            'name'  => $request->name,
            'about' => $request->about
        ], $this->back, $id);
    }

    // Delete
    public function delete($id){
        return AffiliationRepositories::delete([
            'did' => $id,
            'uid' => auth()->user()->id,
        ], $this->back);
    }
}
