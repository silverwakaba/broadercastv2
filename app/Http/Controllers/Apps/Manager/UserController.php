<?php

namespace App\Http\Controllers\Apps\Manager;

use App\Http\Controllers\Controller;

use App\Helpers\BaseHelper;
use App\Helpers\BasedataHelper;

use App\Http\Requests\Apps\Setting\UserAvatarRequest;
use App\Http\Requests\Apps\Setting\UserBiodataRequest;
use App\Http\Requests\Apps\Setting\UserContentRequest;
use App\Http\Requests\Apps\Setting\UserEmailRequest;
use App\Http\Requests\Apps\Setting\UserHandlerRequest;
use App\Http\Requests\Apps\Setting\UserLinkRequest;
use App\Http\Requests\Apps\Setting\UserLinkDeleteRequest;
use App\Http\Requests\Apps\Setting\UserLinkVerificationRequest;
use App\Http\Requests\Apps\Setting\UserPasswordRequest;

use App\Repositories\Setting\UserRepositories;
use App\Repositories\Setting\UserAvatarRepositories;
use App\Repositories\Setting\UserBiodataRepositories;
use App\Repositories\Setting\UserContentRepositories;
use App\Repositories\Setting\UserEmailRepositories;
use App\Repositories\Setting\UserGenderRepositories;
use App\Repositories\Setting\UserHandlerRepositories;
use App\Repositories\Setting\UserLanguageRepositories;
use App\Repositories\Setting\UserLinkRepositories;
use App\Repositories\Setting\UserPasswordRepositories;
use App\Repositories\Setting\UserProfileRepositories;
use App\Repositories\Setting\UserRaceRepositories;
use App\Repositories\Service\TwitchRepositories;
use App\Repositories\Service\YoutubeRepositories;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller{
    // Constructor
    public function __construct(){
        $this->back = route('apps.manager.index');
        $this->backLink = route('apps.manager.link');
    }

    // Avatar
    public function avatar(){
        return view('pages/apps/setting/user/avatar', [
            'backURI' => $this->back,
        ]);
    }

    public function avatarPost(UserAvatarRequest $request){
        return UserAvatarRepositories::change($request->avatar);
    }

    // Biodata
    public function biodata(){
        $datas = UserProfileRepositories::getProfile([
            'id'    => auth()->user()->id,
            'with'  => ['hasOneUserBiodata'],
        ], false);

        return view('pages/apps/setting/user/biodata', [
            'backURI'   => $this->back,
            'datas'     => $datas,
        ]);
    }

    public function biodataPost(UserBiodataRequest $request){
        return UserBiodataRepositories::update([
            'id'        => auth()->user()->id,
            'name'      => $request->name,
            'nickname'  => $request->nickname,
            'dob'       => $request->dob,
            'dod'       => $request->dod,
            'dor'       => $request->dor,
            'biography' => $request->biography,
        ]);
    }

    // Content
    public function content(){
        $datas = UserProfileRepositories::getProfile([
            'id'    => auth()->user()->id,
            'with'  => ['belongsToManyUserContent'],
        ]);

        return view('pages/apps/setting/user/content', [
            'backURI'   => $this->back,
            'datas'     => BasedataHelper::baseContent(),
            'value'     => collect($datas->content)->pluck('id')->toArray(),
        ]);
    }

    public function contentPost(Request $request){
        return UserContentRepositories::sync([
            'id'    => auth()->user()->id,
            'data'  => $request->content,
        ]);
    }

    // Email
    public function email(){
        return view('pages/apps/setting/user/email', [
            'backURI' => $this->back,
        ]);
    }

    public function emailPost(UserEmailRequest $request){
        return UserEmailRepositories::update([
            'id'    => auth()->user()->id,
            'email' => $request->email,
        ]);
    }

    // Handler
    public function handler(){
        return view('pages/apps/setting/user/handler', [
            'backURI'   => $this->back,
            'handler'   => BaseHelper::getCustomizedIdentifier(auth()->user()->identifier),
        ]);
    }

    public function handlerPost(UserHandlerRequest $request){
        return UserHandlerRepositories::update([
            'id'        => auth()->user()->id,
            'handler'   => $request->handler,
        ]);
    }

    // Gender
    public function gender(){
        $datas = UserProfileRepositories::getProfile([
            'id'    => auth()->user()->id,
            'with'  => ['belongsToManyUserGender'],
        ]);

        return view('pages/apps/setting/user/gender', [
            'backURI'   => $this->back,
            'datas'     => BasedataHelper::baseGender(),
            'value'     => collect($datas->gender)->pluck('id')->toArray(),
        ]);
    }

    public function genderPost(Request $request){
        return UserGenderRepositories::sync([
            'id'    => auth()->user()->id,
            'data'  => $request->gender,
        ]);
    }

    // Language
    public function language(){
        $datas = UserProfileRepositories::getProfile([
            'id'    => auth()->user()->id,
            'with'  => ['belongsToManyUserLanguage'],
        ]);

        return view('pages/apps/setting/user/language', [
            'backURI'   => $this->back,
            'datas'     => BasedataHelper::baseLanguage(),
            'value'     => collect($datas->language)->pluck('id')->toArray(),
        ]);
    }

    public function languagePost(Request $request){
        return UserLanguageRepositories::sync([
            'id'    => auth()->user()->id,
            'data'  => $request->language,
        ]);
    }

    // Link
    public function link(){
        if(request()->ajax()){
            return UserLinkRepositories::datatable([
                'id'    => auth()->user()->id,
                'route' => 'apps.manager.link',
            ]);
        }

        return view('pages/apps/setting/user/link/index', [
            'addURI'    => route('apps.manager.link.add'),
            'backURI'   => $this->back,
        ]);
    }

    // Link Add
    public function linkAdd(){
        return view('pages/apps/setting/user/link/add', [
            'captcha'   => true,
            'backURI'   => $this->backLink,
            'services'  => BasedataHelper::baseLink(),
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
            'with'  => ['belongsToBaseLink', 'hasOneUserLinkTracker'],
        ], 'edit');

        return view('pages/apps/setting/user/link/edit', [
            'backURI'   => $this->backLink,
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

    // Link Verify
    public function linkVerify($id){
        $datas = UserLinkRepositories::getLinkToVerify([
            'did'   => $id,
            'uid'   => auth()->user()->id,
            'with'  => ['belongsToBaseDecision', 'belongsToBaseLink'],
        ]);

        if($datas->belongsToBaseLink->name == 'Twitch'){
            $structure = [
                'https://www.twitch.tv/waka377ch',
            ];
        }
        elseif($datas->belongsToBaseLink->name == 'YouTube'){
            $structure = [
                'https://www.youtube.com/@waka377ch',
                'https://www.youtube.com/channel/UCIRQxP7jORi6jsLt0HmUmqQ',
            ];
        }
        else{
            $structure = [
                'what r u doin blud?',
            ];
        }

        return view('pages/apps/setting/user/link/verify', [
            'captcha'   => true,
            'backURI'   => $this->backLink,
            'secret'    => Str::of('vtl#')->append(BaseHelper::adler32(auth()->user()->id . date('d m Y') . $datas->belongsToBaseLink->name)),
            'structure' => $structure,
            'datas'     => $datas,
        ]);
    }

    public function linkVerifyPost(UserLinkVerificationRequest $request, $id){
        if($request->service == 'Twitch'){
            return TwitchRepositories::verifyChannel($request->channel, $request->unique, $id, [
                'route' => 'apps.manager.link',
            ]);
        }
        elseif($request->service == 'YouTube'){
            return YoutubeRepositories::verifyChannel($request->channel, $request->unique, $id, [
                'route' => 'apps.manager.link',
            ]);
        }
        else{
            return RedirectHelper::routeBack(null, 'danger', 'Channel Verification. It seems that you are stranded.', 'error');
        }
    }

    // Link Delete
    public function linkDelete($id){
        return UserLinkRepositories::delete([
            'did'   => $id,
            'uid'   => auth()->user()->id,
        ], 'apps.manager.link');
    }

    // Link Delete - For Checked Base Link (Like YouTube, Twitch, etc)
    public function linkDeleteConfirm($id){
        $datas = UserLinkRepositories::getLinkToConfirm([
            'did'   => $id,
            'uid'   => auth()->user()->id,
            'with'  => ['belongsToBaseLink', 'hasOneUserLinkTracker'],
        ]);

        if(isset($datas->hasOneUserLinkTracker)){
            return view('pages/apps/setting/user/link/delete', [
                'backURI'   => $this->backLink,
                'datas'     => $datas,
            ]);
        }
        else{
            return redirect()->route('apps.manager.link.delete', ['did' => $id]);
        }
    }

    public function linkDeleteConfirmPost(UserLinkDeleteRequest $request, $id){
        return UserLinkRepositories::deleteChannel([
            'did'           => $id,
            'uid'           => auth()->user()->id,
            'identifier'    => $request->identifier,
        ], 'apps.manager.link');
    }

    // Password
    public function password(){
        return view('pages/apps/setting/user/password', [
            'backURI' => $this->back,
        ]);
    }

    public function passwordPost(UserPasswordRequest $request){
        return UserPasswordRepositories::update([
            'id'            => auth()->user()->id,
            'new_password'  => $request->new_password,
        ]);
    }

    // Race
    public function race(){
        $datas = UserProfileRepositories::getProfile([
            'id'    => auth()->user()->id,
            'with'  => ['belongsToManyUserRace'],
        ]);

        return view('pages/apps/setting/user/race', [
            'backURI'   => $this->back,
            'datas'     => BasedataHelper::baseRace(),
            'value'     => collect($datas->race)->pluck('id')->toArray(),
        ]);
    }

    public function racePost(Request $request){
        return UserRaceRepositories::sync([
            'id'    => auth()->user()->id,
            'data'  => $request->race,
        ]);
    }
}
