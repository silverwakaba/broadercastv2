<?php

namespace App\Http\Controllers\Apps\Base;
use App\Http\Controllers\Controller;
use App\Helpers\BaseHelper;

use App\Events\BaseLanguageCreated;
use App\Events\BaseLanguageModified;
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
                    'action' => view('datatable.accept-decline')->with('id', BaseHelper::encrypt($data->id))->with('decision', $data->base_decision_id)->render(),
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

        // BaseLanguageCreated::dispatch($datas);

        return redirect()->route('apps.base.language.index')->with('class', 'success')->with('message', 'Your base language suggestion is submitted. Thank you.');
    }

    // Accept
    public function accept($id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseLanguage::where('id', '=', $did)->update([
            'base_decision_id' => '2',
        ]);

        BaseLanguageModified::dispatch($datas);

        return redirect()->route('apps.base.language.index')->with('class', 'success')->with('message', 'Your selected base language suggestion is accepted.');
    }

    // Decline
    public function decline($id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseLanguage::where('id', '=', $did)->update([
            'base_decision_id' => '3',
        ]);

        BaseLanguageModified::dispatch($datas);

        return redirect()->route('apps.base.language.index')->with('class', 'success')->with('message', 'Your selected base language suggestion is declined.');
    }
}
