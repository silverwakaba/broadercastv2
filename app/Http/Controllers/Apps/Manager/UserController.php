<?php

namespace App\Http\Controllers\Apps\Manager;

use App\Http\Controllers\Controller;

use App\Http\Requests\Apps\Setting\UserAvatarRequest;
use App\Http\Requests\Apps\Setting\UserBiodataRequest;
use App\Http\Requests\Apps\Setting\UserContentRequest;
use App\Http\Requests\Apps\Setting\UserLinkRequest;

use App\Repositories\Setting\UserRepositories;
use App\Repositories\Setting\UserAvatarRepositories;
use App\Repositories\Setting\UserBiodataRepositories;
use App\Repositories\Setting\UserContentRepositories;
use App\Repositories\Setting\UserGenderRepositories;
use App\Repositories\Setting\UserLanguageRepositories;
use App\Repositories\Setting\UserLinkRepositories;
use App\Repositories\Setting\UserProfileRepositories;
use App\Repositories\Setting\UserRaceRepositories;

use App\Helpers\BaseHelper;
use App\Helpers\BasedataHelper;
use Illuminate\Http\Request;

// AA
use App\Repositories\Base\BaseAPIRepositories;

class UserController extends Controller{
    // Avatar
    public function avatar(){
        return view('pages/apps/setting/user/avatar');
    }

    public function avatarPost(UserAvatarRequest $request){
        return UserAvatarRepositories::change($request->avatar);
    }

    // Biodata
    public function biodata(){
        $datas = UserProfileRepositories::getProfile([
            'id'    => auth()->user()->id,
            'with'  => ['hasOneUserBiodata'],
        ]);

        return view('pages/apps/setting/user/biodata', [
            'datas' => $datas,
        ]);
    }

    public function biodataPost(UserBiodataRequest $request){
        return UserBiodataRepositories::update([
            'name'      => $request->name,
            'nickname'  => $request->nickname,
            'dob'       => $request->dob,
            'dod'       => $request->dod,
            'biography' => $request->biography,
        ]);
    }

    // Content
    public function content(){
        $datas = UserProfileRepositories::getProfile([
            'id'    => auth()->user()->id,
            'with'  => ['belongsToManyUserContent'],
        ], true);

        $repo = ($datas)->resolve();

        return view('pages/apps/setting/user/content', [
            'datas' => BasedataHelper::baseContent(),
            'value' => ($repo['content'])->pluck('id')->toArray(),
        ]);
    }

    public function contentPost(Request $request){
        return UserContentRepositories::sync($request->content);
    }

    // Gender
    public function gender(){
        $datas = UserProfileRepositories::getProfile([
            'id'    => auth()->user()->id,
            'with'  => ['belongsToManyUserGender'],
        ], true);

        $repo = ($datas)->resolve();

        return view('pages/apps/setting/user/gender', [
            'datas' => BasedataHelper::baseGender(),
            'value' => ($repo['gender'])->pluck('id')->toArray(),
        ]);
    }

    public function genderPost(Request $request){
        return UserGenderRepositories::sync($request->gender);
    }

    // Language
    public function language(){
        $datas = UserProfileRepositories::getProfile([
            'id'    => auth()->user()->id,
            'with'  => ['belongsToManyUserLanguage'],
        ], true);

        $repo = ($datas)->resolve();

        return view('pages/apps/setting/user/language', [
            'datas' => BasedataHelper::baseLanguage(),
            'value' => ($repo['language'])->pluck('id')->toArray(),
        ]);
    }

    public function languagePost(Request $request){
        return UserLanguageRepositories::sync($request->language);
    }

    // Link
    public function link(){
        // return UserLinkRepositories::datatable([
        //     'id'    => auth()->user()->id,
        //     'route' => 'apps.manager.link',
        // ]);

        if(request()->ajax()){
            return UserLinkRepositories::datatable([
                'id'    => auth()->user()->id,
                'route' => 'apps.manager.link',
            ]);
        }

        return view('pages/apps/setting/user/link/index');
    }

    // Link Add
    public function linkAdd(){
        return view('pages/apps/setting/user/link/add', [
            'services' => BasedataHelper::baseLink(),
        ]);
    }

    public function linkAddPost(UserLinkRequest $request){
        return UserLinkRepositories::upsert([
            'users_id'      => auth()->user()->id,
            'base_link_id'  => $request->service,
            'link'          => $request->link,
        ], 'apps.manager.link');
    }

    // Link Edit
    public function linkEdit($id){
        $datas = UserLinkRepositories::getLink([
            'did'   => $id,
            'uid'   => auth()->user()->id,
            'with'  => ['belongsToBaseLink'],
        ]);

        return view('pages/apps/setting/user/link/edit', [
            'services'  => BasedataHelper::baseLink(),
            'datas'     => $datas,
            'protected' => in_array($datas->base_link_id, BaseHelper::getCheckedBaseLink()),
        ]);
    }

    public function linkEditPost(UserLinkRequest $request, $id){
        return UserLinkRepositories::upsert([
            'base_link_id'  => $request->service,
            'link'          => $request->link,
        ], 'apps.manager.link', $id);
    }

    // Link Edit
    public function linkVerify($id){
        $datas = UserLinkRepositories::getLinkToVerify([
            'did'   => $id,
            'uid'   => auth()->user()->id,
            'with'  => ['belongsToBaseDecision', 'belongsToBaseLink'],
        ]);

        // return $datas;

        return view('pages/apps/setting/user/link/verify', [
            'datas' => $datas,
        ]);
    }

    // Link Delete
    public function linkDelete($id){
        return UserLinkRepositories::delete([
            'did'   => $id,
            'uid'   => auth()->user()->id,
        ], 'apps.manager.link');
    }

    // Race
    public function race(){
        $datas = UserProfileRepositories::getProfile([
            'id'    => auth()->user()->id,
            'with'  => ['belongsToManyUserRace'],
        ], true);

        $repo = ($datas)->resolve();

        return view('pages/apps/setting/user/race', [
            'datas' => BasedataHelper::baseRace(),
            'value' => ($repo['race'])->pluck('id')->toArray(),
        ]);
    }

    public function racePost(Request $request){
        return UserRaceRepositories::sync($request->race);
    }
}
