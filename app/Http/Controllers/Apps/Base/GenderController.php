<?php

namespace App\Http\Controllers\Apps\Base;
use App\Http\Controllers\Controller;
use App\Helpers\BaseHelper;

use App\Http\Requests\Apps\Base\GenderRequest;

use App\Http\Resources\BaseGenderResource;

use App\Models\BaseGender;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GenderController extends Controller{
    // Index
    public function index(){
        if(request()->ajax()){
            $datas = BaseGender::with([
                'belongsToBaseDecision', 'hasOneUser',
            ])->whereIn(
                'base_decision_id', [2, 6]
            )->orderBy('name', 'ASC')->get();

            return DataTables::of($datas)->setTransformer(function($data){
                return [
                    'datas'  => BaseGenderResource::make($data)->resolve(),
                    'action' => view('datatable.action', ['mode' => 'approval'])
                            ->with('decision', $data->base_decision_id)
                            ->with('action', route('apps.base.gender.decision', ['id' => BaseHelper::encrypt($data->id)]))
                            ->render(),
                ];
            })->toJson();
        }

        return view('pages/apps/base/gender/index');
    }

    // Add
    public function add(){
        return view('pages/apps/base/gender/add');
    }

    public function addPost(GenderRequest $request){
        $datas = BaseGender::create([
            'users_id'          => auth()->user()->id,
            'base_decision_id'  => '6',
            'name'              => $request->name,
        ]);

        return redirect()->route('apps.base.gender.index')->with('class', 'success')->with('message', 'Your base gender suggestion is submitted. Thank you.');
    }

    // Decision
    public function decision(Request $request, $id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseGender::findOrFail($did);

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
