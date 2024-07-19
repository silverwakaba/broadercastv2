<?php

namespace App\Http\Controllers\Apps\Master;
use App\Http\Controllers\Controller;

use App\Helpers\BaseHelper;
use App\Helpers\BasedataHelper;

use App\Http\Requests\Apps\Master\UserRequest;
use App\Http\Requests\Apps\Setting\UserAvatarRequest;
use App\Http\Requests\Apps\Setting\UserBiodataRequest;
use App\Http\Requests\Apps\Setting\UserContentRequest;
use App\Http\Requests\Apps\Setting\UserLinkRequest;
use App\Http\Requests\Apps\Setting\UserLinkDeleteRequest;
use App\Http\Requests\Apps\Setting\UserLinkVerificationRequest;

use App\Repositories\Master\UserRepositories as MasterUserRepositories;
use App\Repositories\Setting\UserRepositories;
use App\Repositories\Setting\UserAvatarRepositories;
use App\Repositories\Setting\UserBiodataRepositories;
use App\Repositories\Setting\UserContentRepositories;
use App\Repositories\Setting\UserGenderRepositories;
use App\Repositories\Setting\UserLanguageRepositories;
use App\Repositories\Setting\UserLinkRepositories;
use App\Repositories\Setting\UserProfileRepositories;
use App\Repositories\Setting\UserRaceRepositories;
use App\Repositories\Service\YoutubeRepositories;

use Illuminate\Http\Request;

class UserController extends Controller{
    // Constructor
    public function __construct(){
        $this->title = 'Master User';
        $this->back = 'apps.master.user.index';
    }

    // Index
    public function index(){
        if(request()->ajax()){
            return MasterUserRepositories::datatable([
                'route' => 'apps.master.user',
            ]);
        }

        return view('pages/apps/master-data/user/index');
    }

    // Add
    public function add(){
        return view('pages/apps/master-data/user/add');
    }

    public function addPost(UserRequest $request){
        return UserRepositories::create([
            'name' => $request->name,
        ]);
    }

    // Index Manage
    public function manage($id){
        $datas = MasterUserRepositories::find([
            'id' => $id,
        ]);

        return view('pages/apps/master-data/user/manage/index', [
            'datas' => $datas,
        ]);
    }

    // Biodata
    public function biodata($id){
        $id = BaseHelper::decrypt($id);

        $datas = UserProfileRepositories::getProfile([
            'id'    => $id,
            'with'  => ['hasOneUserBiodata'],
        ], false);

        return view('pages/apps/setting/user/biodata', [
            'datas' => $datas,
        ]);
    }

    public function biodataPost(UserBiodataRequest $request, $id){
        $id = BaseHelper::decrypt($id);
        
        return UserBiodataRepositories::update([
            'id'        => $id,
            'name'      => $request->name,
            'nickname'  => $request->nickname,
            'dob'       => $request->dob,
            'dod'       => $request->dod,
            'biography' => $request->biography,
        ]);
    }

    // Content
    public function content($id){
        $id = BaseHelper::decrypt($id);

        $datas = UserProfileRepositories::getProfile([
            'id'    => $id,
            'with'  => ['belongsToManyUserContent'],
        ]);

        return view('pages/apps/setting/user/content', [
            'datas' => BasedataHelper::baseContent(),
            'value' => collect($datas->content)->pluck('id')->toArray(),
        ]);
    }

    public function contentPost(Request $request, $id){
        $id = BaseHelper::decrypt($id);

        return UserContentRepositories::sync([
            'id'    => $id,
            'data'  => $request->content,
        ]);
    }

    // Gender
    public function gender($id){
        $id = BaseHelper::decrypt($id);

        $datas = UserProfileRepositories::getProfile([
            'id'    => $id,
            'with'  => ['belongsToManyUserGender'],
        ]);

        return view('pages/apps/setting/user/gender', [
            'datas' => BasedataHelper::baseGender(),
            'value' => collect($datas->gender)->pluck('id')->toArray(),
        ]);
    }

    public function genderPost(Request $request, $id){
        $id = BaseHelper::decrypt($id);

        return UserGenderRepositories::sync([
            'id'    => $id,
            'data'  => $request->gender,
        ]);
    }

    // Language
    public function language($id){
        $id = BaseHelper::decrypt($id);

        $datas = UserProfileRepositories::getProfile([
            'id'    => $id,
            'with'  => ['belongsToManyUserLanguage'],
        ]);

        return view('pages/apps/setting/user/language', [
            'datas' => BasedataHelper::baseLanguage(),
            'value' => collect($datas->language)->pluck('id')->toArray(),
        ]);
    }

    public function languagePost(Request $request, $id){
        $id = BaseHelper::decrypt($id);

        return UserLanguageRepositories::sync([
            'id'    => $id,
            'data'  => $request->language,
        ]);
    }

    // Link
    public function link($id){
        $id = BaseHelper::decrypt($id);

        if(request()->ajax()){
            return UserLinkRepositories::datatable([
                'id'    => $id,
                'route' => 'apps.master.user.manage.link',
            ]);
        }

        return view('pages/apps/setting/user/link/index');
    }

    // Link Add
    public function linkAdd($id){
        return view('pages/apps/setting/user/link/add', [
            'services' => BasedataHelper::baseLink(),
        ]);
    }

    public function linkAddPost(UserLinkRequest $request, $id){
        $id = BaseHelper::decrypt($id);

        return UserLinkRepositories::upsert([
            'users_id'      => $id,
            'base_link_id'  => $request->service,
            'link'          => $request->link,
        ], 'apps.manager.link');
    }

    // Race
    public function race($id){
        $id = BaseHelper::decrypt($id);

        $datas = UserProfileRepositories::getProfile([
            'id'    => $id,
            'with'  => ['belongsToManyUserRace'],
        ]);

        return view('pages/apps/setting/user/race', [
            'datas' => BasedataHelper::baseRace(),
            'value' => collect($datas->race)->pluck('id')->toArray(),
        ]);
    }

    public function racePost(Request $request, $id){
        $id = BaseHelper::decrypt($id);

        return UserRaceRepositories::sync([
            'id'    => $id,
            'data'  => $request->race,
        ]);
    }
}
