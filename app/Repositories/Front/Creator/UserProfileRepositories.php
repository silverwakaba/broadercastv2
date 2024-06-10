<?php

namespace App\Repositories\Front\Creator;

use App\Helpers\BaseHelper;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserChannelActivityResource;
use App\Http\Resources\UserLinkResource;
use App\Http\Resources\UserLinkTrackerResource;

use App\Models\User;
use App\Models\UserFeed;
use App\Models\UserLink;
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

    public static function getLink(array $data){
        $datas = UserLink::with([
            'belongsToBaseLink'
        ])->withAggregate('belongsToBaseLink', 'name')->where(
            isset($data['query']) ? $data['query'] : []
        )->whereNotIn('base_link_id', BaseHelper::getCheckedBaseLink())->orderBy('belongs_to_base_link_name')->get();

        return BaseHelper::resourceToJson(UserLinkResource::collection($datas));
    }

    public static function getLinkTracker(array $data){
        $datas = UserLinkTracker::with(
            isset($data['with']) ? $data['with'] : []
        )->where(
            isset($data['query']) ? $data['query'] : []
        )->whereIn('base_link_id', BaseHelper::getCheckedBaseLink())->orderBy('streaming', 'DESC');
        
        // Additional query
        if(isset($data['option'])){
            if(isset($data['option']['take']) && !isset($data['option']['pagination'])){
                $datas->take($data['option']['take']);
            }

            if(isset($data['option']['aggregate'])){
                $datas->withAggregate('belongsToActiveStream', 'published')->orderBy('belongs_to_active_stream_published', 'DESC');
            }
        }

        // Data retrieval
        if(isset($data['option']['pagination'])){
            if($data['option']['pagination']['type'] == 'normal'){
                $newData = $datas->paginate($data['option']['take']);
            }
            elseif($data['option']['pagination']['type'] == 'cursor'){
                $newData = $datas->cursorPaginate($data['option']['take']);
            }
            else{
                $newData = $datas->paginate($data['option']['take']);
            }
        }
        else{
            $newData = $datas->get();
        }

        return BaseHelper::resourceToJson(UserLinkTrackerResource::collection($newData)->response()->getData());
    }

    public static function getFeed(array $data, $datatable = false){
        $datas = UserFeed::with(
            isset($data['with']) ? $data['with'] : []
        )->where(
            isset($data['query']) ? $data['query'] : []
        )->orderBy('published', 'DESC')->get();
        
        if($datatable == true){
            return DataTables::of($datas)->setTransformer(function($datas){
                return UserChannelActivityResource::make($datas)->resolve();
            })->toJson();
        }

        return BaseHelper::resourceToJson(UserChannelActivityResource::collection($datas));
    }
}
