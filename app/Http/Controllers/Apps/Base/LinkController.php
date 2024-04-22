<?php

namespace App\Http\Controllers\Apps\Base;
use App\Http\Controllers\Controller;
use App\Helpers\BaseHelper;

use App\Http\Requests\Apps\Base\LinkRequest;

use App\Http\Resources\BaseLinkResource;

use App\Models\BaseLink;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LinkController extends Controller{
    // Index
    public function index(Request $request){
        if(request()->ajax()){
            $datas = BaseLink::with([
                'belongsToBaseDecision', 'hasOneUser',
            ])->whereIn(
                'base_decision_id', [2, 6]
            )->orderBy('name', 'ASC')->get();

            return DataTables::of($datas)->setTransformer(function($data){
                return [
                    'datas'  => BaseLinkResource::make($data)->resolve(),
                    'action' => view('datatable.action', ['mode' => 'approval'])
                            ->with('decision', $data->base_decision_id)
                            ->with('action', route('apps.base.link.decision', ['id' => BaseHelper::encrypt($data->id)]))
                            ->render(),
                ];
            })->toJson();
        }

        return view('pages/apps/base/link/index');
    }

    // Add
    public function add(){
        return view('pages/apps/base/link/add');
    }

    public function addPost(LinkRequest $request){
        $datas = BaseLink::create([
            'users_id'          => auth()->user()->id,
            'base_decision_id'  => '6',
            'name'              => $request->name,
            'icon'              => $request->icon,
            'color'             => $request->color,
            'checking'          => $request->checking ? true : false,
        ]);

        return redirect()->route('apps.base.link.index')->with('class', 'success')->with('message', 'Your base link suggestion is submitted. Thank you.');
    }

    // Decision
    public function decision(Request $request, $id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseLink::findOrFail($did);

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
