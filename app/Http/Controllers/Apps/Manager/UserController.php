<?php

namespace App\Http\Controllers\Apps\Manager;

use App\Http\Controllers\Controller;

use App\Http\Requests\Apps\Setting\UserAvatarRequest;
use App\Http\Requests\Apps\Setting\UserBiodataRequest;
use App\Http\Requests\Apps\Setting\UserContentRequest;
use App\Http\Requests\Apps\Setting\UserLinkRequest;

use App\Repositories\Setting\UserRepositories;
use Illuminate\Http\Request;

use App\Helpers\BasedataHelper;

class UserController extends Controller{
    // Avatar
    public function avatar(){
        return view('pages/apps/setting/user/avatar');
    }

    public function avatarPost(UserAvatarRequest $request){
        return UserRepositories::avatar($request->avatar);
    }

    // Biodata
    public function biodata(){
        $datas = UserRepositories::getProfile([
            'id'    => auth()->user()->id,
            'with'  => ['hasOneUserBiodata'],
        ]);

        return view('pages/apps/setting/user/biodata', [
            'datas' => $datas,
        ]);
    }

    public function biodataPost(UserBiodataRequest $request){
        return UserRepositories::biodata([
            'name'      => $request->name,
            'nickname'  => $request->nickname,
            'dob'       => $request->dob,
            'dod'       => $request->dod,
            'biography' => $request->biography,
        ]);
    }

    // Content
    public function content(){
        $datas = UserRepositories::getProfile([
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
        return UserRepositories::content($request->content);
    }

    // Gender
    public function gender(){
        $datas = UserRepositories::getProfile([
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
        return UserRepositories::gender($request->gender);
    }

    // Language
    public function language(){
        $datas = UserRepositories::getProfile([
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
        return UserRepositories::language($request->language);
    }

    // Link
    public function link(){
        if(request()->ajax()){
            return UserRepositories::linkDatatable([
                'id'    => auth()->user()->id,
                'route' => 'apps.manager.link',
            ], true);
        }

        return view('pages/apps/setting/user/link/index');
    }

    // Link Add
    public function linkAdd(){
        return view('pages/apps/setting/user/link/add', [
            'datas' => BasedataHelper::baseLink(),
        ]);
    }

    public function linkAddPost(Request $request){ // UserLinkRequest
        return UserRepositories::upsertLink([
            'users_id'          => auth()->user()->id,
            'base_link_id'      => $request->service,
            
            'base_decision_id'  => '6',

            'link'              => $request->link,
        ], 'apps.manager.link');
    }

    // Race
    public function race(){
        $datas = UserRepositories::getProfile([
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
        return UserRepositories::race($request->race);
    }
}
