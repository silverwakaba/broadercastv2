<?php

namespace App\Http\Controllers\Apps\Base;
use App\Http\Controllers\Controller;
use App\Helpers\BaseHelper;

use App\Events\BaseLinkCreated;
use App\Events\BaseLinkModified;
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
                    'action' => view('datatable.accept-decline')->with('id', BaseHelper::encrypt($data->id))->with('decision', $data->base_decision_id)->render(),
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

        // BaseLinkCreated::dispatch($datas);

        return redirect()->route('apps.base.link.index')->with('class', 'success')->with('message', 'Your base link suggestion is submitted. Thank you.');
    }

    // Accept
    public function accept($id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseLink::where('id', '=', $did)->update([
            'base_decision_id' => '2',
        ]);

        BaseLinkModified::dispatch($datas);

        return redirect()->route('apps.base.link.index')->with('class', 'success')->with('message', 'Your selected base link suggestion is accepted.');
    }

    // Decline
    public function decline($id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseLink::where('id', '=', $did)->update([
            'base_decision_id' => '3',
        ]);

        BaseLinkModified::dispatch($datas);

        return redirect()->route('apps.base.link.index')->with('class', 'success')->with('message', 'Your selected base link suggestion is declined.');
    }
}
