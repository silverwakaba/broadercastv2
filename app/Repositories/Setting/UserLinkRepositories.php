<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Http\Resources\UserLinkResource;

use App\Models\BaseLink;
use App\Models\UserLink;

use Yajra\DataTables\Facades\DataTables;

class UserLinkRepositories{
    public static function getLink(array $data, $mode = null){
        $id = BaseHelper::decrypt($data['did']);

        $datas = UserLink::with(isset($data['with']) ? $data['with'] : [])->where([
            ['id', '=', $id],
            ['users_id', '=', $data['uid']],
        ])->firstOrFail();

        $trackerCounter = $datas->hasOneUserLinkTracker()->where([
            ['users_link_id', '=', $id]
        ])->count();

        if(
            ($trackerCounter == 0) xor ($mode !== 'edit')
        ){
            return $datas;
        }
        else{
            return abort(403);
        }
    }

    public static function getLinkToVerify(array $data){
        $datas = UserLink::with(isset($data['with']) ? $data['with'] : [])->where([
            ['id', '=', BaseHelper::decrypt($data['did'])],
            ['users_id', '=', $data['uid']],
            ['base_decision_id', '=', 1],
        ])->whereIn('base_link_id', BaseHelper::getCheckedBaseLink())->firstOrFail();

        return $datas;
    }

    public static function getLinkToConfirm(array $data){
        $datas = UserLink::with(isset($data['with']) ? $data['with'] : [])->where([
            ['id', '=', BaseHelper::decrypt($data['did'])],
            ['users_id', '=', $data['uid']],
            ['base_decision_id', '=', 2],
        ])->whereIn('base_link_id', BaseHelper::getCheckedBaseLink())->firstOrFail();

        return $datas;
    }

    public static function datatable(array $data){
        $datas = UserLink::with([
            'belongsToBaseDecision', 'belongsToBaseLink'
        ])->withAggregate('belongsToBaseLink', 'name')->where([
            ['users_id', '=', $data['id']],
        ])->orderBy('belongs_to_base_link_name')->get();

        return DataTables::of($datas)->setTransformer(function($datas) use($data){
            return [
                'datas'  => UserLinkResource::make($datas)->resolve(),
                'action' => view('datatable.action-user-link', [
                    'did'       => BaseHelper::encrypt($datas->id),
                    'uid'       => isset($data['uid']) ? BaseHelper::encrypt($datas->users_id) : null,
                    'decision'  => $datas->base_decision_id,
                    'protected' => in_array($datas->base_link_id, BaseHelper::getCheckedBaseLink()),
                    'route'     => $data['route'],
                ])->render(),
            ];
        })->toJson();
    }
    
    public static function upsert(array $data, $back = null, $id = null){
        try{
            $checking = BaseLink::select('checking')->where([
                ['id', '=', $data['base_link_id']]
            ])->first();
    
            $default = [
                'base_decision_id' => $checking->checking == true ? 1 : 2,
            ];
    
            if($id && $id !== null){
                $id = BaseHelper::decrypt($id);
    
                $upsert = $data;
            }
            else{
                $upsert = array_merge($data, $default);
            }
    
            $state = $id ? 'update' : 'create';
    
            UserLink::updateOrCreate(['id' => $id], $upsert);
    
            return RedirectHelper::routeBack($back, 'success', 'External Link', $state);
        }
        catch(\Throwable $th){
            return RedirectHelper::routeBack($back, 'error', 'External Link', $state);
        }
    }

    public static function delete(array $data, $back = null){
        try{
            $datas = UserLink::where([
                ['id', '=', BaseHelper::decrypt($data['did'])],
                ['users_id', '=', $data['uid']],
            ])->firstOrFail();
    
            $datas->forceDelete();
    
            return RedirectHelper::routeBack($back, 'success', 'External Link', 'delete');
        }
        catch(\Throwable $th){
            return RedirectHelper::routeBack($back, 'error', 'External Link', 'delete');
        }
    }

    public static function deleteChannel(array $data, $back = null){
        try{
            $datas = UserLink::where([
                ['id', '=', BaseHelper::decrypt($data['did'])],
                ['users_id', '=', $data['uid']],
            ])->firstOrFail();
    
            $datas->hasOneUserLinkTracker()->where('identifier', '=', $data['identifier'])->firstOrFail()->update([
                'users_feed_id' => null,
            ]);
    
            $datas->forceDelete();
    
            return RedirectHelper::routeBack($back, 'success', 'External Link and Channel', 'delete');
        }
        catch(\Throwable $th){
            return RedirectHelper::routeBack($back, 'error', 'External Link and Channel', 'delete');
        }
    }
}
