<?php

namespace App\Repositories\Front\Creator;

use App\Helpers\BaseHelper;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserChannelActivityResource;
use App\Http\Resources\UserLinkTrackerResource;

use App\Models\User;
use App\Models\UserFeed;
use App\Models\UserLinkTracker;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

class UserProfileRepositories{
    public static function getProfile(array $data){
        $datas = User::with(isset($data['with']) ? $data['with'] : [])->where([
            ['identifier', '=', $data['identifier']],
        ])->firstOrFail();

        return BaseHelper::resourceToJson(new UserResource($datas));
    }

    public static function getLinkTracker(array $data){
        $datas = UserLinkTracker::with([
            'belongsToBaseLink',
            'belongsToUserLink',
            'belongsToActiveStream',
        ])->where([
            ['users_id', '=', $data['id']],
        ])->orderBy('streaming', 'DESC')->orderBy('name', 'ASC')->get();

        return BaseHelper::resourceToJson(UserLinkTrackerResource::collection($datas));
    }

    public static function getFeed(array $data, $datatable = false){
        $datas = UserFeed::with([
            'belongsToBaseLink',
        ])->where([
            ['users_id', '=', $data['id']],
        ])
        ->orderBy('published', 'DESC')
        ->get();
        
        if($datatable == true){
            return DataTables::of($datas)->setTransformer(function($datas){
                return [
                    'datas'  => UserChannelActivityResource::make($datas)->resolve(),
                    
                    // 'action' => view('datatable.action-user', [
                    //     'id'        => BaseHelper::encrypt($datas->id),
                    //     'route'     => 'apps.base.content',
                    // ])->render(),
                ];
            })->toJson();
        }

        return BaseHelper::resourceToJson(UserChannelActivityResource::collection($datas));
    }
}
