<?php

namespace App\Http\Controllers\Apps\Base;
use App\Http\Controllers\Controller;
use App\Helpers\BaseHelper;

use App\Events\BaseRaceCreated;
use App\Events\BaseRaceModified;
use App\Http\Requests\Apps\Base\RaceRequest;

use App\Http\Resources\BaseRaceResource;

use App\Models\BaseRace;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RaceController extends Controller{
    // Index
    public function index(Request $request){
        if(request()->ajax()){
            $datas = BaseRace::with([
                'belongsToBaseDecision', 'hasOneUser',
            ])->whereIn(
                'base_decision_id', [2, 6]
            )->orderBy('name', 'ASC')->get();

            return DataTables::of($datas)->setTransformer(function($data){
                return [
                    'datas'  => BaseRaceResource::make($data)->resolve(),
                    'action' => view('datatable.accept-decline')->with('id', BaseHelper::encrypt($data->id))->with('decision', $data->base_decision_id)->render(),
                ];
            })->toJson();
        }

        return view('pages/apps/base/race/index');
    }

    // Add
    public function add(){
        return view('pages/apps/base/race/add');
    }

    public function addPost(RaceRequest $request){
        $datas = BaseRace::create([
            'users_id'          => auth()->user()->id,
            'base_decision_id'  => '6',
            'name'              => $request->name,
        ]);

        // BaseRaceCreated::dispatch($datas);

        return redirect()->route('apps.base.race.index')->with('class', 'success')->with('message', 'Your base race suggestion is submitted. Thank you.');
    }

    // Accept
    public function accept($id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseRace::where('id', '=', $did)->update([
            'base_decision_id' => '2',
        ]);

        BaseRaceModified::dispatch($datas);

        return redirect()->route('apps.base.race.index')->with('class', 'success')->with('message', 'Your selected base race suggestion is accepted.');
    }

    // Decline
    public function decline($id){
        $did = BaseHelper::decrypt($id);

        $datas = BaseRace::where('id', '=', $did)->update([
            'base_decision_id' => '3',
        ]);

        BaseRaceModified::dispatch($datas);

        return redirect()->route('apps.base.race.index')->with('class', 'success')->with('message', 'Your selected base race suggestion is declined.');
    }
}
