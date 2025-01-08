<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Helpers\BasedataHelper;
use App\Helpers\RedirectHelper;
use App\Http\Requests\Front\DiscoveryRequest;
use App\Http\Requests\Front\Creator\ClaimRequest;
use App\Repositories\Base\CookiesRepositories;
use App\Repositories\Front\Creator\UserProfileRepositories;
use App\Repositories\Service\TwitchRepositories;
use App\Repositories\Service\YoutubeRepositories;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class CreatorController extends Controller{
    // Index
    public function index(Request $request){
        $datas = UserProfileRepositories::getLinkTracker([
            'with'  => [
                'belongsToUser',
                'belongsToBaseLink',
                'belongsToUserLink',
            ],
            'option'    => [
                'take'          => 2,
                'orderType'     => 'discovery',
                'pagination'    => [
                    'type' => 'normal',
                ],
            ],
            'filter'    => [
                'request' => $request,
            ],
        ]);

        $affiliation = BasedataHelper::baseAffiliation();
        $content = BasedataHelper::baseContent();
        $gender = BasedataHelper::baseGender();
        $language = BasedataHelper::baseLanguage();
        $persona = BasedataHelper::baseRace();
        $sortType = BasedataHelper::baseSort();

        $sortBy = [
            ['id' => 'time', 'name' => 'Latest Activity'],
            ['id' => 'name', 'name' => 'Channel Name'],
            ['id' => 'view', 'name' => 'Total View'],
            ['id' => 'content', 'name' => 'Total Content'],
            ['id' => 'subscriber', 'name' => 'Total Subscriber'],
        ];

        return view('pages/front/creator/index', [
            'datas'         => $datas,
            'affiliation'   => $affiliation,
            'content'       => $content,
            'gender'        => $gender,
            'language'      => $language,
            'persona'       => $persona,
            'sortType'      => $sortType,
            'sortBy'        => json_decode(json_encode($sortBy)),
        ]);
    }

    public function indexSearch(DiscoveryRequest $request){
        return redirect()->route('creator.index', [
            'channelname'           => $request->channelname,
            'profilename'           => $request->profilename,
            'channelsubsrangefrom'  => $request->channelsubsrangefrom,
            'channelsubsrangeto'    => $request->channelsubsrangeto,
            'affiliation'           => $request->affiliation,
            'content'               => $request->content,
            'gender'                => $request->gender,
            'language'              => $request->language,
            'persona'               => $request->persona,
            'sorttype'              => $request->sorttype,
            'sortby'                => $request->sortby,
        ]);
    }

    // Profile
    public function profile($id){
        // Search
        $sort = BasedataHelper::baseSort();
        $timezone = BasedataHelper::baseTimezone();
        $timezone_value = CookiesRepositories::timezone();
        $live_value = CookiesRepositories::actualStart();
        $schedule_value = CookiesRepositories::schedule();
        $vod_value = CookiesRepositories::published();
        $streamTitle = request()->title;

        // Profile
        $profile = UserProfileRepositories::getProfile([
            'identifier'    => $id,
            'with'          => [
                'belongsToManyUserAffiliation',
                'hasOneUserAvatar',
                'hasOneUserBiodata',
                'belongsToManyUserContent',
                'belongsToManyUserGender',
                'belongsToManyUserLanguage',
                'belongsToManyUserRace',
                'belongsToManyUserLink',
                'belongsToUserRelationFollowed',
            ],
        ]);

        // Link
        $link = UserProfileRepositories::getLink([
            'query' => [
                ['users_id', '=', $profile->id],
            ],
        ]);

        // Tracker Channel
        $tracker = UserProfileRepositories::getLinkTracker([
            'with'  => [
                'belongsToBaseLink',
                'belongsToUserLink',
            ],
            'query' => [
                ['users_id', '=', $profile->id],
            ],
        ]);

        // Live Feed
        $liveFeed = UserProfileRepositories::getFeed([
            'with'  => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query' => [
                ['users_id', '=', $profile->id],
                ['base_status_id', '=', 8],
                ['title', 'like', '%' . $streamTitle . '%'],
            ],
            'option'        => [
                'take'          => 3,
                'orderType'     => 'live',
                'pagination'    => [
                    'type'  => 'normal',
                ],
            ],
        ]);

        // Schedule Feed
        $scheduleFeed = UserProfileRepositories::getFeed([
            'with'  => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query' => [
                ['users_id', '=', $profile->id],
                ['base_status_id', '=', 7],
                ['title', 'like', '%' . $streamTitle . '%'],
            ],
            'option'        => [
                'take'          => 3,
                'orderType'     => 'schedule',
                'pagination'    => [
                    'type'  => 'normal',
                ],
            ],
        ]);

        // Archived and VOD Feed
        $archivodFeed = UserProfileRepositories::getFeed([
            'with'  => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query' => [
                ['users_id', '=', $profile->id],
                ['title', 'like', '%' . $streamTitle . '%'],
            ],
            'option'        => [
                'take'          => 3,
                'orderType'     => 'archivod',
                'pagination'    => [
                    'type'  => 'normal',
                ],
            ],
        ]);

        return view('pages/front/creator/profile', [
            'sort'              => $sort,
            'timezone'          => $timezone,
            'timezone_value'    => $timezone_value,
            'live_value'        => $live_value,
            'schedule_value'    => $schedule_value,
            'vod_value'         => $vod_value,
            'profile'           => $profile,
            'link'              => $link,
            'tracker'           => $tracker,
            'liveFeed'          => $liveFeed,
            'scheduleFeed'      => $scheduleFeed,
            'archivodFeed'      => $archivodFeed,
        ]);
    }

    public function profilePost(Request $request, $id){
        $expire = (60 * 24) * 30;

        Cookie::queue('timezone', $request->timezone, $expire);
        Cookie::queue('actual_start', $request->live_content, $expire);
        Cookie::queue('schedule', $request->schedule_content, $expire);
        Cookie::queue('published', $request->vod_content, $expire);

        return redirect()->route('creator.profile', [
            'id'    => $id,
            'title' => $request->title,
        ]);
    }

    // Update Rels
    public function rels($id){
        return $datas = UserProfileRepositories::updateRelationship([
            'identifier' => $id,
        ]);
    }

    // Claim
    public function claim($id){
        $profile = UserProfileRepositories::getProfile([
            'identifier'    => $id,
            'with'          => [
                'belongsToBaseStatus',
            ],
            'option'        => [
                'sgu' => true, // Ref: SGU = System Generated User
            ],
        ]);

        $tracker = UserProfileRepositories::getLinkTracker([
            'with'  => [
                'belongsToBaseLink',
                'belongsToUserLink',
            ],
            'query' => [
                ['users_id', '=', $profile->id],
            ],
        ]);

        return view('pages/front/creator/claim', [
            'profile'   => $profile,
            'tracker'   => $tracker,
            'secret'    => Str::of('vtl#')->append($id),
        ]);
    }

    public function claimVia($id, $ch){
        $profile = UserProfileRepositories::getProfile([
            'identifier'    => $id,
            'with'          => [
                'belongsToBaseStatus',
            ],
            'option'        => [
                'sgu' => true, // Ref: SGU = System Generated User
            ],
        ]);

        $tracker = UserProfileRepositories::getLinkTracker([
            'with'  => [
                'belongsToBaseLink',
                'belongsToUserLink',
            ],
            'query' => [
                ['users_id', '=', $profile->id],
                ['identifier', '=', $ch],
            ],
        ]);

        if((isset($profile)) && (isset($tracker)) && (count($tracker->data) == 1)){
            return view('pages/front/creator/claim-via', [
                'profile'   => $profile,
                'tracker'   => $tracker,
                'secret'    => Str::of('vtl#')->append($id),
            ]);
        }
        else{
            return abort(404);
        }
    }

    public function claimViaPost(ClaimRequest $request, $id, $ch){
        if($request->service == 'Twitch'){
            return TwitchRepositories::claimViaChannel($request->identifier, $request->unique, $id, $request->email, [
                'route' => 'login',
            ]);
        }
        elseif($request->service == 'YouTube'){
            return YoutubeRepositories::claimViaChannel($request->identifier, $request->unique, $id, $request->email, [
                'route' => 'login',
            ]);
        }
    }
}
