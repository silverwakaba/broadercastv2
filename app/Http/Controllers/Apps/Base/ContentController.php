<?php

namespace App\Http\Controllers\Apps\Base;
use App\Http\Controllers\Controller;
use App\Helpers\BaseHelper;

use App\Events\BaseContentCreated;
use App\Events\BaseContentModified;
use App\Http\Requests\Apps\Base\ContentRequest;

use App\Http\Resources\BaseContentResource;

use App\Models\BaseContent;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContentController extends Controller{
    // Index
    public function index(Request $request){
        if(request()->ajax()){
            $datas = BaseContent::with([
                'belongsToBaseDecision', 'hasOneUser',
            ])->whereIn(
                'base_decision_id', [2, 6]
            )->orderBy('name', 'ASC')->get();

            return DataTables::of($datas)->setTransformer(function($data){
                return [
                    'datas'  => BaseContentResource::make($data)->resolve(),
                    'action' => view('datatable.accept-decline')->with('id', BaseHelper::encrypt($data->id))->with('decision', $data->base_decision_id)->render(),
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

        // BaseContentCreated::dispatch($datas);

        return redirect()->route('apps.base.content.index')->with('class', 'success')->with('message', 'Your base content suggestion is submitted. Thank you.');
    }

    // Accept
    public function accept($id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseContent::where('id', '=', $did)->update([
            'base_decision_id' => '2',
        ]);

        BaseContentModified::dispatch($datas);

        return redirect()->route('apps.base.content.index')->with('class', 'success')->with('message', 'Your selected base content suggestion is accepted.');
    }

    // Decline
    public function decline($id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseContent::where('id', '=', $did)->update([
            'base_decision_id' => '3',
        ]);

        BaseContentModified::dispatch($datas);

        return redirect()->route('apps.base.content.index')->with('class', 'success')->with('message', 'Your selected base content suggestion is declined.');
    }
}
