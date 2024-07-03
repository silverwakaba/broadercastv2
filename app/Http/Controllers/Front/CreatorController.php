<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Helpers\BasedataHelper;
use App\Repositories\Base\CookiesRepositories;
use App\Repositories\Front\Creator\UserProfileRepositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CreatorController extends Controller{
    // Index
    public function index(){
        return "List semua creator";
    }

    // Profile
    public function profile($id){
        // Profile
        $profile = UserProfileRepositories::getProfile([
            'identifier'    => $id,
            'with'          => [
                'hasOneUserAvatar',
                'hasOneUserBiodata',
                'belongsToManyUserContent',
                'belongsToManyUserGender',
                'belongsToManyUserLanguage',
                'belongsToManyUserRace',
                'belongsToManyUserLink',
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

        $feed = UserProfileRepositories::getFeed([
            'with'  => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query' => [
                ['users_id', '=', $profile->id],
            ],
            'option'     => [
                'take'       => 3,
                'orderType' => 'all',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/creator/profile', [
            'profile'   => $profile,
            'link'      => $link,
            'tracker'   => $tracker,
            'feed'      => $feed,
        ]);
    }

    // Live
    public function live(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 8],
            ],
            'option'    => [
                'take'       => 4,
                'orderType' => 'live',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/creator/live', [
            'datas' => $datas,
        ]);
    }

    // Scheduled
    public function scheduled(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 7],
            ],
            'option'    => [
                'take'       => 4,
                'orderType' => 'schedule',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/creator/scheduled', [
            'datas' => $datas,
        ]);
    }

    // Archived
    public function archived(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 9],
            ],
            'option'    => [
                'take'       => 4,
                'orderType' => 'archive',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/creator/archived', [
            'datas' => $datas,
        ]);
    }

    public function uploaded(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 10],
            ],
            'option'    => [
                'take'       => 4,
                'orderType' => 'vod',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/creator/uploaded', [
            'datas' => $datas,
        ]);
    }

    public function setting(Request $request){
        $sort = BasedataHelper::baseSort();
        $timezone = BasedataHelper::baseTimezone();
        $timezone_value = CookiesRepositories::timezone();
        $live_value = CookiesRepositories::actualStart();
        $schedule_value = CookiesRepositories::schedule();
        $vod_value = CookiesRepositories::published();

        return view('pages/front/creator/setting', [
            'sort'              => $sort,
            'timezone'          => $timezone,
            'timezone_value'    => $timezone_value,
            'live_value'        => $live_value,
            'schedule_value'    => $schedule_value,
            'vod_value'         => $vod_value,
        ]);
    }

    public function settingPost(Request $request){
        $expire = (60 * 24) * 30;

        Cookie::queue('timezone', $request->timezone, $expire);
        Cookie::queue('actual_start', $request->live_content, $expire);
        Cookie::queue('schedule', $request->schedule_content, $expire);
        Cookie::queue('published', $request->vod_content, $expire);

        return redirect()->back();
    }
}
