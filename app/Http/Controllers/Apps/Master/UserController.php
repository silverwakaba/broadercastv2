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
use App\Repositories\Setting\UserAffiliationRepositories;
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

        if(request()->routeIs('apps.master.user.manage.*')){
            $this->backLink = route('apps.master.user.manage.link', ['uid' => request()->uid]);
            $this->backManage = route('apps.master.user.manage.index', ['uid' => request()->uid]);
        }
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
        return MasterUserRepositories::create([
            'name' => $request->name,
        ]);
    }

    // Index Manage
    public function manage($uid){
        $datas = MasterUserRepositories::find([
            'id' => $uid,
        ]);

        return view('pages/apps/master-data/user/manage/index', [
            'datas' => $datas,
        ]);
    }

    // Content
    public function affiliation($uid){
        $uid = BaseHelper::decrypt($uid);

        $datas = UserProfileRepositories::getProfile([
            'id'    => $uid,
            'with'  => ['belongsToManyUserAffiliation'],
        ]);

        return view('pages/apps/setting/user/affiliation', [
            'backURI'   => $this->backManage,
            'datas'     => BasedataHelper::baseAffiliation(),
            'value'     => collect($datas->affiliation)->pluck('id')->toArray(),
        ]);
    }

    public function affiliationPost(Request $request, $uid){
        $uid = BaseHelper::decrypt($uid);

        return UserAffiliationRepositories::sync([
            'id'    => $uid,
            'data'  => $request->content,
        ]);
    }

    // Biodata
    public function biodata($uid){
        $uid = BaseHelper::decrypt($uid);

        $datas = UserProfileRepositories::getProfile([
            'id'    => $uid,
            'with'  => ['hasOneUserBiodata'],
        ], false);

        return view('pages/apps/setting/user/biodata', [
            'backURI'   => $this->backManage,
            'datas'     => $datas,
        ]);
    }

    public function biodataPost(UserBiodataRequest $request, $uid){
        $uid = BaseHelper::decrypt($uid);
        
        return UserBiodataRepositories::update([
            'id'        => $uid,
            'name'      => $request->name,
            'nickname'  => $request->nickname,
            'dob'       => $request->dob,
            'dod'       => $request->dod,
            'dor'       => $request->dor,
            'biography' => $request->biography,
        ]);
    }

    // Content
    public function content($uid){
        $uid = BaseHelper::decrypt($uid);

        $datas = UserProfileRepositories::getProfile([
            'id'    => $uid,
            'with'  => ['belongsToManyUserContent'],
        ]);

        return view('pages/apps/setting/user/content', [
            'backURI'   => $this->backManage,
            'datas'     => BasedataHelper::baseContent(),
            'value'     => collect($datas->content)->pluck('id')->toArray(),
        ]);
    }

    public function contentPost(Request $request, $uid){
        $uid = BaseHelper::decrypt($uid);

        return UserContentRepositories::sync([
            'id'    => $uid,
            'data'  => $request->content,
        ]);
    }

    // Gender
    public function gender($uid){
        $uid = BaseHelper::decrypt($uid);

        $datas = UserProfileRepositories::getProfile([
            'id'    => $uid,
            'with'  => ['belongsToManyUserGender'],
        ]);

        return view('pages/apps/setting/user/gender', [
            'backURI'   => $this->backManage,
            'datas'     => BasedataHelper::baseGender(),
            'value'     => collect($datas->gender)->pluck('id')->toArray(),
        ]);
    }

    public function genderPost(Request $request, $uid){
        $uid = BaseHelper::decrypt($uid);

        return UserGenderRepositories::sync([
            'id'    => $uid,
            'data'  => $request->gender,
        ]);
    }

    // Language
    public function language($uid){
        $uid = BaseHelper::decrypt($uid);

        $datas = UserProfileRepositories::getProfile([
            'id'    => $uid,
            'with'  => ['belongsToManyUserLanguage'],
        ]);

        return view('pages/apps/setting/user/language', [
            'backURI'   => $this->backManage,
            'datas'     => BasedataHelper::baseLanguage(),
            'value'     => collect($datas->language)->pluck('id')->toArray(),
        ]);
    }

    public function languagePost(Request $request, $uid){
        $uid = BaseHelper::decrypt($uid);

        return UserLanguageRepositories::sync([
            'id'    => $uid,
            'data'  => $request->language,
        ]);
    }

    // Link
    public function link($uid){
        $uid = BaseHelper::decrypt($uid);

        if(request()->ajax()){
            return UserLinkRepositories::datatable([
                'id'    => $uid,
                'uid'   => true,
                'route' => 'apps.master.user.manage.link',
            ]);
        }

        return view('pages/apps/setting/user/link/index', [
            'addURI'    => route('apps.master.user.manage.link.add', ['uid' => request()->uid]),
            'backURI'   => $this->backManage,
        ]);
    }

    // Link Add
    public function linkAdd($uid){
        return view('pages/apps/setting/user/link/add', [
            'backURI'  => $this->backLink,
            'services' => BasedataHelper::baseLink(),
        ]);
    }

    public function linkAddPost(UserLinkRequest $request, $id){
        $id = BaseHelper::decrypt($id);

        return UserLinkRepositories::upsert([
            'users_id'      => $id,
            'base_link_id'  => $request->service,
            'link'          => $request->link,
        ], [
            'route' => 'apps.master.user.manage.link',
            'query' => ['uid' => request()->uid],
        ]);
    }

    // Link Edit
    public function linkEdit($uid, $did){
        $uid = BaseHelper::decrypt($uid);

        $datas = UserLinkRepositories::getLink([
            'did'   => $did,
            'uid'   => $uid,
            'with'  => ['belongsToBaseLink', 'hasOneUserLinkTracker'],
        ], 'edit');

        return view('pages/apps/setting/user/link/edit', [
            'backURI'   => $this->backLink,
            'services'  => BasedataHelper::baseLink(),
            'datas'     => $datas,
            'protected' => in_array($datas->base_link_id, BaseHelper::getCheckedBaseLink()),
        ]);
    }

    public function linkEditPost(UserLinkRequest $request, $uid, $did){
        return UserLinkRepositories::upsert([
            'base_link_id'  => $request->service,
            'link'          => $request->link,
        ], [
            'route' => 'apps.master.user.manage.link',
            'query' => ['uid' => request()->uid],
        ], $did);
    }

    // Link Verify
    public function linkVerify($uid, $did){
        $uid = BaseHelper::decrypt($uid);

        $datas = UserLinkRepositories::getLinkToVerify([
            'did'   => $did,
            'uid'   => $uid,
            'with'  => ['belongsToBaseDecision', 'belongsToBaseLink'],
        ]);

        if($datas->belongsToBaseLink->name == 'Twitch'){
            $structure = 'https://www.twitch.tv/wakaba6969';
        }
        elseif($datas->belongsToBaseLink->name == 'YouTube'){
            $structure = [
                'https://www.youtube.com/@wakaba69',
                'https://www.youtube.com/channel/UCIRQxP7jORi6jsLt0HmUmqQ',
            ];
        }

        return view('pages/apps/setting/user/link/verify', [
            'backURI'   => $this->backLink,
            'secret'    => 'vtl#' . BaseHelper::adler32($uid . date('d m Y') . $datas->belongsToBaseLink->name),
            'structure' => $structure,
            'datas'     => $datas,
        ]);
    }

    public function linkVerifyPost(UserLinkVerificationRequest $request, $uid, $did){
        $uid = BaseHelper::decrypt($uid);

        if($request->service == 'Twitch'){
            return "Twitch";
        }
        elseif($request->service == 'YouTube'){
            return YoutubeRepositories::verifyChannel($request->channel, $uid, $did, [
                'route' => 'apps.master.user.manage.link',
                'query' => ['uid' => request()->uid],
            ]);
        }
        else{
            return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. It seems that you are stranded.', 'error');
        }
    }

    // Link Delete
    public function linkDelete($uid, $did){
        $uid = BaseHelper::decrypt($uid);

        return UserLinkRepositories::delete([
            'did'   => $did,
            'uid'   => $uid,
        ], [
            'route' => 'apps.master.user.manage.link',
            'query' => ['uid' => request()->uid],
        ]);
    }

    // Link Delete - For Checked Base Link (Like YouTube, Twitch, etc)
    public function linkDeleteConfirm($uid, $did){
        $uid = BaseHelper::decrypt($uid);

        $datas = UserLinkRepositories::getLinkToConfirm([
            'did'   => $did,
            'uid'   => $uid,
            'with'  => ['belongsToBaseLink', 'hasOneUserLinkTracker'],
        ]);

        return view('pages/apps/setting/user/link/delete', [
            'backURI'   => $this->backLink,
            'datas'     => $datas,
        ]);
    }

    public function linkDeleteConfirmPost(UserLinkDeleteRequest $request, $uid, $did){
        $uid = BaseHelper::decrypt($uid);

        return UserLinkRepositories::deleteChannel([
            'did'           => $did,
            'uid'           => $uid,
            'identifier'    => $request->identifier,
        ], [
            'route' => 'apps.master.user.manage.link',
            'query' => ['uid' => request()->uid],
        ]);
    }

    // Race
    public function race($uid){
        $uid = BaseHelper::decrypt($uid);

        $datas = UserProfileRepositories::getProfile([
            'id'    => $uid,
            'with'  => ['belongsToManyUserRace'],
        ]);

        return view('pages/apps/setting/user/race', [
            'backURI'   => $this->backManage,
            'datas'     => BasedataHelper::baseRace(),
            'value'     => collect($datas->race)->pluck('id')->toArray(),
        ]);
    }

    public function racePost(Request $request, $uid){
        $uid = BaseHelper::decrypt($uid);

        return UserRaceRepositories::sync([
            'id'    => $uid,
            'data'  => $request->race,
        ]);
    }
}
