<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Http\Resources\UserFanboxResource;
use App\Http\Resources\UserFanboxSubmissionResource;

use App\Models\UserFanbox;
use App\Models\UserFanboxSubmission;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

class UserFanboxSubmissionRepositories{
    // Index
    public static function index(array $data){
        $datas = UserFanboxSubmission::where([
            ['users_fanbox_id', '=', $data['id']],
        ]);

        if(isset($data['with'])){
            $datas->with($data['with']);
        }
        
        $newDatas = $datas->orderBy('created_at', 'ASC')->paginate(1);

        return BaseHelper::resourceToJson(UserFanboxSubmissionResource::collection($newDatas)->response()->getData());
    }
    
    // Upsert: Update and/or Insert
    public static function upsert(array $data, $back = null, $id = null){
        // User id
        $uid = isset(auth()->user()->id) == true ? auth()->user()->id : null;

        // Fanbox id
        $fanbox = UserFanbox::where('identifier', '=', $data['id'])->select('id', 'identifier')->firstOrFail();
        $fId = $fanbox->id;

        // Fanbox submission id
        if(!isset($id) && !($id)){
            $id = null;
        }
        else{
            $id = BaseHelper::decrypt($id);
        }

        // Default value
        $default = [
            'users_fanbox_id' => $fId,
        ];

        if(isset($uid) && ($uid) && ($data['anonymous'] == true)){
            $default['users_id'] = $uid;
            $default['anonymous'] = true;
        }
        elseif(isset($uid) && ($uid) && ($data['anonymous'] == false)){
            $default['users_id'] = $uid;
            $default['anonymous'] = false;
        }
        else{
            $default['users_id'] = 2;
            $default['anonymous'] = true;
        }

        // Upsert data
        $upsert = array_merge($data, $default);

        $datas = UserFanboxSubmission::updateOrCreate(['id' => $id], $upsert);

        return redirect()->route('fanbox.answer.edit', ['id' => $fanbox->identifier, 'did' => BaseHelper::encrypt($datas->id)]);
    }

    // Find question or Fail
    public static function find(array $data){
        $datas = UserFanboxSubmission::query();

        if(isset($data['with'])){
            $datas->with($data['with']);
        }
        
        $datas->where([
            ['id', '=', BaseHelper::decrypt($data['did'])],
        ]);

        if(isset($data['resource']) && ($data['resource'] == true)){
            $resource = new UserFanboxSubmissionResource($datas->firstOrFail());

            $newDatas = BaseHelper::resourceToJson($resource);
        }
        else{
            $newDatas = $datas->firstOrFail();
        }

        return $newDatas;
    }

    // Delete
    public static function delete(array $data){
        // return $data;

        $datas = self::find([
            'did' => BaseHelper::encrypt($data['did']),
        ]);

        $datas->delete();

        if(isset($data['page'])){
            return redirect(urldecode($data['page']));
        }
        else{
            return redirect()->route('apps.manager.fanbox.submission.view', ['id' => $data['id']]);
        }
    }
}
