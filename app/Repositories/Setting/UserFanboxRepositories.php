<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Http\Resources\UserFanboxResource;

use App\Models\UserFanbox;

use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

class UserFanboxRepositories{
    // Datatable
    public static function datatable(array $data){
        $datas = UserFanbox::where([
            ['users_id', '=', $data['id']],
        ]);

        if(isset($data['with'])){
            $datas->with($data['with']);
        }
        
        $newDatas = $datas->orderBy('id', 'DESC')->get();

        return DataTables::of($newDatas)->setTransformer(function($newDatas) use($data){
            return [
                'datas'     => UserFanboxResource::make($newDatas)->resolve(),
                'action'    => view('datatable.action-user', [
                    'id'    => BaseHelper::encrypt($newDatas->id),
                    'route' => $data['route'],
                ])->render(),
            ];
        })->toJson();
    }
    
    // Upsert: Update and/or Insert
    public static function upsert(array $data, $back = null, $id = null){
        $state = $id ? 'update' : 'create';

        $did = $id ? BaseHelper::decrypt($id) : $id;

        if($state == 'create'){ // Let's fugin...
            $default = [
                'identifier'    => BaseHelper::adler32(),
                'active'        => true,
                'attachment'    => false,
            ];
        }
        else{ // ...separate this sbhit!
            $default = [];
        }

        $upsert = array_merge($data, $default);

        UserFanbox::updateOrCreate(['id' => $did], $upsert);

        return RedirectHelper::routeBack($back, 'success', 'Fanbox', $state);
    }

    // Find question or Fail
    public static function find(array $data){
        $datas = UserFanbox::query();

        if(Str::length($data['id']) == 8){ // For answer
            $id = $data['id'];

            $datas->where([
                ['active', '=', true],
                ['identifier', '=', $id],
            ]);
        }
        else{ // For management, eg. crud
            $id = BaseHelper::decrypt($data['id']);

            $datas->where([
                ['id', '=', $id],
                ['users_id', '=', $data['uid']],
            ]);
        }

        if(isset($data['with'])){
            $datas->with($data['with']);
        }

        if(isset($data['resource']) && ($data['resource'] == true)){
            $resource = new UserFanboxResource($datas->firstOrFail());

            $newDatas = BaseHelper::resourceToJson($resource);
        }
        else{
            $newDatas = $datas->firstOrFail();
        }

        return $newDatas;
    }

    // Delete
    public static function delete(array $data){
        $datas = self::find([
            'id'    => $data['id'],
            'uid'   => $data['uid'],
        ]);

        $datas->delete();

        return RedirectHelper::routeBack(null, 'success', 'Fanbox', 'delete');
    }
}
