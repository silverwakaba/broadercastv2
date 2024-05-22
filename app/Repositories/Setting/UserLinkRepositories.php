<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Http\Resources\UserLinkResource;

use App\Models\BaseLink;
use App\Models\UserLink;

use Yajra\DataTables\Facades\DataTables;

class UserLinkRepositories{
    public static function getLink(array $data){
        $datas = UserLink::with(isset($data['with']) ? $data['with'] : [])->where([
            ['id', '=', BaseHelper::decrypt($data['did'])],
            ['users_id', '=', $data['uid']],
        ])->firstOrFail();

        return $datas;
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
            ['users_id', '=', '1'],
        ])->orderBy('belongs_to_base_link_name')->get();

        return DataTables::of($datas)->setTransformer(function($datas) use($data){
            return [
                'datas'  => UserLinkResource::make($datas)->resolve(),
                'action' => view('datatable.action-user-link', [
                    'id'        => BaseHelper::encrypt($datas->id),
                    'decision'  => $datas->base_decision_id,
                    'protected' => in_array($datas->base_link_id, BaseHelper::getCheckedBaseLink()),
                    'route'     => $data['route'],
                ])->render(),
            ];
        })->toJson();
    }
    
    public static function upsert(array $data, $back, $id = ''){
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

    public static function delete(array $data, $back){
        $datas = UserLink::where([
            ['id', '=', BaseHelper::decrypt($data['did'])],
            ['users_id', '=', $data['uid']],
        ])->whereNotIn('base_link_id', BaseHelper::getCheckedBaseLink())->firstOrFail();

        $datas->delete();

        return RedirectHelper::routeBack($back, 'success', 'External Link', 'delete');
    }
}
