<?php

namespace App\Repositories\Base;

use App\Helpers\BaseHelper;
use Yajra\DataTables\Facades\DataTables;

class BaseRepositories{
    public static function datatable(array $data){
        $datas = $data['model']::with(isset($data['with']) ? $data['with'] : [])->whereIn(
            'base_decision_id', [2, 3, 6]
        )->orderBy('name', 'ASC')->get();

        return DataTables::of($datas)->setTransformer(function($datas) use($data){
            return [
                'datas'  => $data['resource']::make($datas)->resolve(),
                'action' => view('datatable.action', [
                    'id'        => BaseHelper::encrypt($datas->id),
                    'decision'  => $datas->base_decision_id,
                    'route'     => $data['route'],
                ])->render(),
            ];
        })->toJson();
    }

    public static function upsert($model, array $data, $back = '', $id = ''){
        try{
            if($id && $id !== null){
                $id = BaseHelper::decrypt($id);
            }
    
            $state = $id ? 'change' : 'suggestion';
    
            $model::updateOrCreate(['id' => $id], $data);
    
            return redirect()->route($back)->with('class', 'success')->with('message', "Your $state is submitted successfully. Thank you.");
        }
        catch(\Throwable $th) {
            return back()->with('class', 'warning')->with('message', 'There is an error. Try again in a moment.');
        }
    }

    public static function find(array $data){
        try{
            $id = BaseHelper::decrypt($data['id']);

            $datas = $data['model']::findOrFail($id);

            return $datas;
        }
        catch(\Throwable $th) {
            return abort(404);
        }
    }

    public static function decision(array $data, $back){
        try{
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

            return redirect()->route($back)->with('class', 'success')->with('message', "Your decision is submitted successfully. Thank you.");
        }
        catch(\Throwable $th) {
            return back()->with('class', 'warning')->with('message', 'There is an error. Try again in a moment.');
        }
    }

    public static function delete(array $data, $back){
        try{
            $id = BaseHelper::decrypt($data['id']);

            $datas = $data['model']::findOrFail($id);

            $datas->delete();

            return redirect()->route($back)->with('class', 'success')->with('message', "Data deleted successfully. Thank you.");
        }
        catch(\Throwable $th){
            return back()->with('class', 'warning')->with('message', 'There is an error. Try again in a moment.');
        }
    }
}
