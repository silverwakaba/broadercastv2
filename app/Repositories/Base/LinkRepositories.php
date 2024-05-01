<?php

namespace App\Repositories\Base;

use App\Models\BaseLink;
use App\Helpers\BaseHelper;
use App\Http\Resources\BaseLinkResource;
use Yajra\DataTables\Facades\DataTables;

class LinkRepositories{
    public static function datatable(array $data){
        $datas = BaseLink::with([
            'belongsToBaseDecision', 'hasOneUser',
        ])->whereIn(
            'base_decision_id', [2, 3, 6]
        )->orderBy('name', 'ASC')->get();

        return DataTables::of($datas)->setTransformer(function($datas) use($data){
            return [
                'datas'  => BaseLinkResource::make($datas)->resolve(),
                'action' => view('datatable.action', [
                    'id'        => BaseHelper::encrypt($datas->id),
                    'decision'  => $datas->base_decision_id,
                    'route'     => $data['route'],
                ])->render(),
            ];
        })->toJson();
    }

    public static function add(array $data){
        BaseLink::create($data);
    }

    public static function decision(array $data){
        try{
            $id = BaseHelper::decrypt($data['id']);

            $datas = BaseLink::findOrFail($id);

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

            $datas = BaseLink::findOrFail($id);

            $datas->delete();
        }
        catch(\Throwable $th) {
            return abort(404);
        }
    }
}
