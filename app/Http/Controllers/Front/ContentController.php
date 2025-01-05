<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Helpers\BasedataHelper;
use App\Helpers\RedirectHelper;
use App\Http\Requests\Front\DiscoveryRequest;
use App\Repositories\Base\CookiesRepositories;
use App\Repositories\Front\Creator\UserProfileRepositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ContentController extends Controller{
    // Live
    public function live(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 8],
            ],
            'option'    => [
                'take'       => 4,
                'orderType'  => 'live',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/content/live', [
            'datas' => $datas,
        ]);
    }

    // Scheduled
    public function scheduled(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 7],
            ],
            'option'    => [
                'take'       => 4,
                'orderType'  => 'schedule',
                'dayLoad'    => 30,
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/content/scheduled', [
            'datas' => $datas,
        ]);
    }

    // Archived
    public function archived(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 9],
            ],
            'option'    => [
                'take'       => 4,
                'orderType'  => 'archive',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/content/archived', [
            'datas' => $datas,
        ]);
    }

    // VOD
    public function uploaded(){
        $datas = UserProfileRepositories::getFeed([
            'with'      => [
                'belongsToUser',
                'belongsToBaseLink',
                'hasOneThroughUserLink',
                'belongsToUserLinkTracker',
            ],
            'query'     => [
                ['base_status_id', '=', 10],
            ],
            'option'    => [
                'take'       => 4,
                'orderType'  => 'vod',
                'pagination' => [
                    'type' => 'normal',
                ],
            ],
        ]);

        return view('pages/front/content/uploaded', [
            'datas' => $datas,
        ]);
    }

    // Watch
    public function watch($id){
        return view('pages/front/content/watch');
    }

    // Setting
    public function setting(Request $request){
        $sort = BasedataHelper::baseSort();
        $timezone = BasedataHelper::baseTimezone();
        $timezone_value = CookiesRepositories::timezone();
        $live_value = CookiesRepositories::actualStart();
        $schedule_value = CookiesRepositories::schedule();
        $vod_value = CookiesRepositories::published();

        return view('pages/front/content/setting', [
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

        return RedirectHelper::routeBack(null, 'success', 'Content preference', 'update');
    }
}
