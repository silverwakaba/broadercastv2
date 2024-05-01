<?php

namespace App\Repositories\Base;

use App\Models\BaseGender;
use App\Helpers\BaseHelper;
use App\Http\Resources\BaseGenderResource;
use Yajra\DataTables\Facades\DataTables;

class GenderRepositories{
    public static function datatable(array $data){
        $datas = BaseGender::with([
            'belongsToBaseDecision', 'hasOneUser',
        ])->whereIn(
            'base_decision_id', [2, 3, 6]
        )->orderBy('name', 'ASC')->get();

        return DataTables::of($datas)->setTransformer(function($datas) use($data){
            return [
                'datas'  => BaseGenderResource::make($datas)->resolve(),
                'action' => view('datatable.action', [
                    'id'        => BaseHelper::encrypt($datas->id),
                    'decision'  => $datas->base_decision_id,
                    'route'     => $data['route'],
                ])->render(),
            ];
        })->toJson();
    }

    public static function upsert(array $data, $id = ''){
        if($id){
            $id = BaseHelper::decrypt($id);
        }

        BaseGender::updateOrCreate(['id' => $id], $data);
    }

    public static function decision(array $data){
        try{
            $id = BaseHelper::decrypt($data['id']);

            $datas = BaseGender::findOrFail($id);

            if($data['action'] == 'accept'){
                $datas->update([
                    'base_decision_id' => '2',
                ]);
            }
            elseif($data['action'] == 'decline'){
                $datas->update([
                    'base_decision_id' => '3',
                ]);
            }
        }
        catch(\Throwable $th) {
            return abort(404);
        }
    }

    public static function delete($data){
        try{
            $id = BaseHelper::decrypt($data);

            $datas = BaseGender::findOrFail($id);

            $datas->delete();
        }
        catch(\Throwable $th) {
            return abort(404);
        }
    }
}
