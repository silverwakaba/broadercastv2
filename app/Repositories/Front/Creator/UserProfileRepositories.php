<?php

namespace App\Repositories\Front\Creator;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;
use App\Repositories\Base\CookiesRepositories;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserChannelActivityResource;
use App\Http\Resources\UserLinkResource;
use App\Http\Resources\UserLinkTrackerResource;

use App\Models\User;
use App\Models\UserFeed;
use App\Models\UserLink;
use App\Models\UserLinkTracker;
use App\Models\UserRelation;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

class UserProfileRepositories{
    // Profile
    public static function getProfile(array $data){
        $datas = User::with(isset($data['with']) ? $data['with'] : [])->where([
            ['identifier', '=', $data['identifier']],
        ])->firstOrFail();

        return BaseHelper::resourceToJson(new UserResource($datas));
    }

    // Relationship
    public static function updateRelationship(array $data){
        $datas = User::with('belongsToUserRelationFollowed')->where('identifier', '=', $data['identifier'])->select('id', 'identifier', 'name')->first();

        if(isset($datas) && isset($datas->belongsToUserRelationFollowed)){
            $datas->belongsToUserRelationFollowed()->delete();
        }
        else{
            $datas->belongsToUserRelationFollowed()->insertOrIgnore([
                'users_follower_id' => auth()->user()->id,
                'users_followed_id' => $datas->id,
            ]);
        }

        return RedirectHelper::routeIntended(route('creator.profile', ['id' => $datas->identifier]));
    }

    // Link
    public static function getLink(array $data){
        $datas = UserLink::with([
            'belongsToBaseLink'
        ])->withAggregate('belongsToBaseLink', 'name')->where(
            isset($data['query']) ? $data['query'] : []
        )->orderBy('belongs_to_base_link_name')->get();

        return BaseHelper::resourceToJson(UserLinkResource::collection($datas));
    }

    // Tracker
    public static function getLinkTracker(array $data){
        // Get data
        $datas = UserLinkTracker::with(
            isset($data['with']) ? $data['with'] : []
        )->where(
            isset($data['query']) ? $data['query'] : []
        )->whereIn('base_link_id', BaseHelper::getCheckedBaseLink());

        // Order By
        if(
            (isset($data['option']['orderType']))
            &&
            (Str::contains($data['option']['orderType'], ['discovery']))
        ){
            // Request filter
            $request = $data['filter']['request'];

            // Channel-related
            $channel_name = $request->channelname;
            $profile_name = $request->profilename;

            // Subs Range
            $subs_range = $request->channelsubsrange;
            $channel_subs_range = $request->channelsubsrange ? explode(',', $subs_range) : null;

            $subs_range_from = $request->channelsubsrangefrom;
            $subs_range_to = $request->channelsubsrangeto;

            // Have their own base
            $affiliation = $request->affiliation;
            $content = $request->content;
            $gender = $request->gender;
            $language = $request->language;
            $persona = $request->persona;

            // Channel-related
            if($channel_name !== null){
                $datas->where([
                    ['name', 'like', '%' . $channel_name . '%']
                ]);
            }

            if($profile_name !== null){
                $datas->whereHas('belongsToUser', function($query) use($profile_name){
                    $query->where('name', 'like', '%' . $profile_name . '%');
                })->orWhereHas('hasOneBiodataThroughUser', function($query) use($profile_name){
                    $query->where('nickname', 'like', '%' . $profile_name . '%');
                });
            }

            if(
                ($subs_range_from !== null)
                &&
                ($subs_range_to !== null)
            ){
                $datas->whereBetween('subscriber', [$subs_range_from, $subs_range_to]);
            }

            // Have their own base
            if($affiliation !== null){
                $datas->whereHas('hasManyThroughUserAffiliation', function($query) use($affiliation){
                    $query->whereIn('base_affiliation_id', $affiliation);
                });
            }

            if($content !== null){
                $datas->whereHas('hasManyThroughUserContent', function($query) use($content){
                    $query->whereIn('base_content_id', $content);
                });
            }

            if($gender !== null){
                $datas->whereHas('hasManyThroughUserGender', function($query) use($gender){
                    $query->whereIn('base_gender_id', $gender);
                });
            }

            if($language !== null){
                $datas->whereHas('hasManyThroughUserLanguage', function($query) use($language){
                    $query->whereIn('base_language_id', $language);
                });
            }

            if($persona !== null){
                $datas->whereHas('hasManyThroughUserRace', function($query) use($persona){
                    $query->whereIn('base_race_id', $persona);
                });
            }

            // Sort Type
            $sort_type = $request->sorttype == 1 ? 'asc' : 'desc';

            // Sort By
            $sort_by = $request->sortby;

            if(($sort_by == null) || ($sort_by == 'time')){
                $datas->orderBy('updated_at', $sort_type);
            }
            elseif($sort_by == 'name'){
                $datas->orderBy('name', $sort_type);
            }
            elseif($sort_by == 'view'){
                $datas->orderBy('view', $sort_type);
            }

            elseif($sort_by == 'content'){
                $datas->orderBy('content', $sort_type);
            }
            elseif($sort_by == 'subscriber'){
                $datas->orderBy('subscriber', $sort_type);
            }
            elseif($sort_by == 'joined'){
                $datas->orderBy('joined', $sort_type);
            }
        }
        
        // Only takes
        if(isset($data['option'])){
            if(isset($data['option']['take']) && !isset($data['option']['pagination'])){
                $datas->take($data['option']['take']);
            }
        }

        // Takes with paginate data retrieval
        if(isset($data['option']['pagination'])){
            if($data['option']['pagination']['type'] == 'normal'){
                $newData = $datas->paginate($data['option']['take'])->fragment($data['option']['orderType'])->withQueryString();
            }
            elseif($data['option']['pagination']['type'] == 'cursor'){
                $newData = $datas->cursorPaginate($data['option']['take'])->fragment($data['option']['orderType'])->withQueryString();
            }
            else{
                $newData = $datas->paginate($data['option']['take'])->fragment($data['option']['orderType'])->withQueryString();
            }
        }
        else{
            $newData = $datas->get();
        }

        return BaseHelper::resourceToJson(UserLinkTrackerResource::collection($newData)->response()->getData());
    }

    // Feed
    public static function getFeed(array $data, $datatable = false){
        // Get Data
        $datas = UserFeed::with(
            isset($data['with']) ? $data['with'] : []
        )->where(
            isset($data['query']) ? $data['query'] : []
        );

        // Simping Mode
        if(
            (isset($data['option']['simping']))
            &&
            ($data['option']['simping'] == true)
        ){
            $datas->has('belongsToUserRelationFollowed');
        }

        // Order By
        if(
            (isset($data['option']['orderType']))
            &&
            (Str::contains($data['option']['orderType'], ['live', 'archive']))
        ){
            $datas->orderBy('actual_start', CookiesRepositories::actualStart());
        }
        elseif(
            (isset($data['option']['orderType']))
            &&
            (Str::contains($data['option']['orderType'], ['schedule']))
        ){
            $datas->orderBy('schedule', CookiesRepositories::schedule());

            if((isset($data['option']['dayLoad']))){
                $datas->whereBetween('schedule', [Carbon::now()->toDateTimeString(), Carbon::now()->addDays($data['option']['dayLoad'])->toDateTimeString()]);
            }
        }
        elseif(
            (isset($data['option']['orderType']))
            &&
            (Str::contains($data['option']['orderType'], ['all']))
        ){
            $datas->orderByRaw("CASE WHEN schedule IS NULL THEN 0 ELSE 1 END DESC")->orderBy('schedule', 'DESC')->orderBy('actual_start', 'DESC')->orderBy('published', 'DESC');
        }
        else{
            $datas->orderBy('published', CookiesRepositories::published());
        }

        // Only takes
        if(isset($data['option'])){
            if(isset($data['option']['take']) && !isset($data['option']['pagination'])){
                $datas->take($data['option']['take']);
            }
        }

        // Paginate data retrieval
        if(isset($data['option']['pagination'])){
            if($data['option']['pagination']['type'] == 'normal'){
                $newDatas = $datas->paginate($data['option']['take'])->fragment($data['option']['orderType'])->withQueryString();
            }
            elseif($data['option']['pagination']['type'] == 'cursor'){
                $newDatas = $datas->cursorPaginate($data['option']['take'])->fragment($data['option']['orderType'])->withQueryString();
            }
            else{
                $newDatas = $datas->paginate($data['option']['take'])->fragment($data['option']['orderType'])->withQueryString();
            }
        }
        else{
            $newDatas = $datas->get();
        }
        
        if($datatable == true){
            return DataTables::of($newDatas)->setTransformer(function($newDatas){
                return UserChannelActivityResource::make($newDatas)->resolve();
            })->toJson();
        }

        return BaseHelper::resourceToJson(UserChannelActivityResource::collection($newDatas)->response()->getData());
    }
}
