<?php

namespace App\Repositories\Base;

use App\Models\BaseAffiliation;
use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;
use App\Http\Resources\BaseAffiliationResource;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AffiliationRepositories{
    public static function datatable(array $data){
        $datas = BaseAffiliation::with(isset($data['with']) ? $data['with'] : [])->orderBy('name', 'ASC')->get();

        return DataTables::of($datas)->setTransformer(function($datas) use($data){
            return [
                'datas'  => BaseAffiliationResource::make($datas)->resolve(),
                'action' => view('datatable.action-mod', [
                    'id'    => BaseHelper::encrypt($datas->id),
                    'route' => $data['route'],
                ])->render(),
            ];
        })->toJson();
    }

    public static function upsert(array $data, $back = null, $id = null){
        $default = [
            'users_id'          => auth()->user()->id,
            'base_decision_id'  => 2,
            'identifier'        => BaseHelper::setIdentifier($data['name'], BaseHelper::adler32()),
        ];

        if($id && $id !== null){
            $id = BaseHelper::decrypt($id);

            $aff = BaseAffiliation::select('identifier', 'name')->find($id);

            if($data['name'] == $aff->name){
                $upsert = $data;
            }
            else{
                $identifier = [
                    'identifier' => BaseHelper::setIdentifier($data['name'], $aff->identifier, $aff->name),
                ];

                $upsert = array_merge($data, $identifier);
            }
        }
        else{
            $upsert = array_merge($data, $default);
        }

        $state = $id ? 'update' : 'create';

        $user = BaseAffiliation::updateOrCreate(['id' => $id], $upsert);

        return RedirectHelper::routeBack($back, 'success', 'Affiliation', $state);
    }

    public static function find(array $data){
        $id = BaseHelper::decrypt($data['id']);

        $datas = BaseAffiliation::findOrFail($id);

        return new BaseAffiliationResource($datas);
    }

    public static function delete(array $data, $back = null){
        $datas = BaseAffiliation::where([
            ['id', '=', BaseHelper::decrypt($data['did'])],
            ['users_id', '=', $data['uid']],
        ])->firstOrFail();

        $datas->delete();

        return RedirectHelper::routeBack($back, 'success', 'Affiliation', 'delete');
    }
}
