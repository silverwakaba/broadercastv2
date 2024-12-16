<?php

namespace App\Repositories\Base;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;
use Yajra\DataTables\Facades\DataTables;

class BaseRepositories{
    public static function datatable(array $data){
        $datas = $data['model']::with(isset($data['with']) ? $data['with'] : []);

        if(isset($data['query']) && count(array_keys($data['query'], 'decision')) >= 1){
            $datas->whereIn('base_decision_id', [2, 3, 6]);
        }

        if(isset($data['orderBy'])){
            $datas->orderBy($data['orderBy'][0], $data['orderBy'][1]);
        }
        
        $newDatas = $datas->get();

        return DataTables::of($newDatas)->setTransformer(function($newDatas) use($data){
            return [
                'datas'  => $data['resource']::make($newDatas)->resolve(),
                'action' => view('datatable.action-mod', [
                    'id'        => BaseHelper::encrypt($newDatas->id),
                    'decision'  => $newDatas->base_decision_id,
                    'route'     => $data['route'],
                ])->render(),
            ];
        })->toJson();
    }

    public static function upsert($model, array $data, $back = '', $id = '', $title = ''){
        if($id && $id !== null){
            $id = BaseHelper::decrypt($id);
        }

        $mode = $id ? 'update' : 'create';

        $model::updateOrCreate(['id' => $id], $data);

        return RedirectHelper::routeBack($back, 'success', $title, $mode);
    }

    public static function find(array $data){
        $id = BaseHelper::decrypt($data['id']);

        $datas = $data['model']::findOrFail($id);

        return $datas;
    }

    public static function decision(array $data, $back, $title = ''){
        $id = BaseHelper::decrypt($data['id']);

        $datas = $data['model']::findOrFail($id);

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

        return RedirectHelper::routeBack($back, 'success', $title, 'decision');
    }

    public static function delete(array $data, $back, $title = ''){
        $id = BaseHelper::decrypt($data['id']);

        $datas = $data['model']::findOrFail($id);

        $datas->delete();

        return RedirectHelper::routeBack($back, 'success', $title, 'delete');
    }
}
