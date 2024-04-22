<?php

namespace App\Http\Controllers\Apps\Base;
use App\Http\Controllers\Controller;
use App\Helpers\BaseHelper;

use App\Http\Requests\Apps\Base\ContentRequest;

use App\Http\Resources\BaseContentResource;

use App\Models\BaseContent;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContentController extends Controller{
    // Index
    public function index(){
        if(request()->ajax()){
            $datas = BaseContent::with([
                'belongsToBaseDecision', 'hasOneUser',
            ])->whereIn(
                'base_decision_id', [2, 6]
            )->orderBy('name', 'ASC')->get();

            return DataTables::of($datas)->setTransformer(function($data){
                return [
                    'datas'  => BaseContentResource::make($data)->resolve(),
                    'action' => view('datatable.action', ['mode' => 'approval'])
                            ->with('decision', $data->base_decision_id)
                            ->with('action', route('apps.base.content.decision', ['id' => BaseHelper::encrypt($data->id)]))
                            ->render(),
                ];
            })->toJson();
        }

        return view('pages/apps/base/content/index');
    }

    // Add
    public function add(){
        return view('pages/apps/base/content/add');
    }

    public function addPost(ContentRequest $request){
        $datas = BaseContent::create([
            'users_id'          => auth()->user()->id,
            'base_decision_id'  => '6',
            'name'              => $request->name,
        ]);

        return redirect()->route('apps.base.content.index')->with('class', 'success')->with('message', 'Your base content suggestion is submitted. Thank you.');
    }

    // Decision
    public function decision(Request $request, $id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseContent::findOrFail($did);

        if($request->action == 'accept'){
            $datas->update([
                'base_decision_id' => '2',
            ]);
        }
        elseif($request->action == 'decline'){
            $datas->delete();
        }

        return back()->with('class', 'success')->with('message', 'Your decision is recorded. Thanks.');
    }
}
