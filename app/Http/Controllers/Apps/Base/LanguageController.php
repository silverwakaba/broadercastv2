<?php

namespace App\Http\Controllers\Apps\Base;
use App\Http\Controllers\Controller;
use App\Helpers\BaseHelper;

use App\Http\Requests\Apps\Base\LanguageRequest;

use App\Http\Resources\BaseLanguageResource;

use App\Models\BaseLanguage;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LanguageController extends Controller{
    // Index
    public function index(Request $request){
        if(request()->ajax()){
            $datas = BaseLanguage::with([
                'belongsToBaseDecision', 'hasOneUser',
            ])->whereIn(
                'base_decision_id', [2, 6]
            )->orderBy('name', 'ASC')->get();

            return DataTables::of($datas)->setTransformer(function($data){
                return [
                    'datas'  => BaseLanguageResource::make($data)->resolve(),
                    'action' => view('datatable.action', ['mode' => 'approval'])
                            ->with('decision', $data->base_decision_id)
                            ->with('action', route('apps.base.language.decision', ['id' => BaseHelper::encrypt($data->id)]))
                            ->render(),
                ];
            })->toJson();
        }

        return view('pages/apps/base/language/index');
    }

    // Add
    public function add(){
        return view('pages/apps/base/language/add');
    }

    public function addPost(LanguageRequest $request){
        $datas = BaseLanguage::create([
            'users_id'          => auth()->user()->id,
            'base_decision_id'  => '6',
            'name'              => $request->name,
        ]);

        return redirect()->route('apps.base.language.index')->with('class', 'success')->with('message', 'Your base language suggestion is submitted. Thank you.');
    }

    // Decision
    public function decision(Request $request, $id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseLanguage::findOrFail($did);

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
