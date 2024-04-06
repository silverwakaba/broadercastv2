<?php

namespace App\Http\Controllers\Apps\Base;
use App\Http\Controllers\Controller;
use App\Helpers\BaseHelper;

use App\Events\BaseGenderCreated;
use App\Events\BaseGenderModified;
use App\Http\Requests\Apps\Base\GenderRequest;

use App\Http\Resources\BaseGenderResource;

use App\Models\BaseGender;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GenderController extends Controller{
    // Index
    public function index(Request $request){
        if(request()->ajax()){
            $datas = BaseGender::with([
                'belongsToBaseDecision', 'hasOneUser',
            ])->whereIn(
                'base_decision_id', [2, 6]
            )->orderBy('name', 'ASC')->get();

            return DataTables::of($datas)->setTransformer(function($data){
                return [
                    'datas'  => BaseGenderResource::make($data)->resolve(),
                    'action' => view('datatable.accept-decline')->with('id', BaseHelper::encrypt($data->id))->with('decision', $data->base_decision_id)->render(),
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

        // BaseGenderCreated::dispatch($datas);

        return redirect()->route('apps.base.gender.index')->with('class', 'success')->with('message', 'Your base gender suggestion is submitted. Thank you.');
    }

    // Accept
    public function accept($id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseGender::where('id', '=', $did)->update([
            'base_decision_id' => '2',
        ]);

        BaseGenderModified::dispatch($datas);

        return redirect()->route('apps.base.gender.index')->with('class', 'success')->with('message', 'Your selected base gender suggestion is accepted.');
    }

    // Decline
    public function decline($id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseGender::where('id', '=', $did)->update([
            'base_decision_id' => '3',
        ]);

        BaseGenderModified::dispatch($datas);

        return redirect()->route('apps.base.gender.index')->with('class', 'success')->with('message', 'Your selected base gender suggestion is declined.');
    }
}
