<?php

namespace App\Repositories\Base;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;
use App\Repositories\WrapperRepositories;
use Yajra\DataTables\Facades\DataTables;

class BaseRepositories{
    public static function datatable(array $data){
        return WrapperRepositories::tryCatch(function() use($data){
            $datas = $data['model']::with(isset($data['with']) ? $data['with'] : [])->whereIn(
                'base_decision_id', [2, 3, 6]
            )->orderBy('name', 'ASC')->get();
    
            return DataTables::of($datas)->setTransformer(function($datas) use($data){
                return [
                    'datas'  => $data['resource']::make($datas)->resolve(),
                    'action' => view('datatable.action-mod', [
                        'id'        => BaseHelper::encrypt($datas->id),
                        'decision'  => $datas->base_decision_id,
                        'route'     => $data['route'],
                    ])->render(),
                ];
            })->toJson();
        });
    }

    public static function upsert($model, array $data, $back = '', $id = '', $title = ''){
        return WrapperRepositories::tryCatch(function() use($model, $data, $back, $id, $title){
            if($id && $id !== null){
                $id = BaseHelper::decrypt($id);
            }
    
            $mode = $id ? 'update' : 'create';
    
            $model::updateOrCreate(['id' => $id], $data);

            return RedirectHelper::routeBack($back, 'success', $title, $mode);
        });
    }

    public static function find(array $data){
        return WrapperRepositories::tryCatch(function() use($data){
            $id = BaseHelper::decrypt($data['id']);

            $datas = $data['model']::findOrFail($id);

            return $datas;
        });
    }

    public static function decision(array $data, $back, $title = ''){
        return WrapperRepositories::tryCatch(function() use($data, $back, $title){
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

            return RedirectHelper::routeBack($back, 'success', $title);
        });
    }

    public static function delete(array $data, $back, $title = ''){
        return WrapperRepositories::tryCatch(function() use($data, $back, $title){
            $id = BaseHelper::decrypt($data['id']);

            $datas = $data['model']::findOrFail($id);

            $datas->delete();

            return RedirectHelper::routeBack($back, 'success', $title, 'delete');
        });
    }
}
