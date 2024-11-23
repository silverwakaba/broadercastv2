<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserLinkResource;

use App\Mail\UserRecoveryEmail;

use App\Models\BaseLink;
use App\Models\User;
use App\Models\UserLink;
use App\Models\UserRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class UserRepositories{
    public static function register(array $data, $back, $role = ''){
        if(!$role){
            $role = 'User';
        }

        $user = User::create($data)->assignRole($role);

        $user->hasOneUserRequest()->create([
            'base_request_id'   => 1,
            'users_id'          => $user->id,
        ]);
        
        return redirect()->route($back)->with('class', 'info')->with('message', 'The registered account is ready.');
    }

    public static function login(array $data){
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $data['remember'])){
            request()->session()->regenerate();

            return redirect()->intended(route('apps.front.index'));
        }
        else{
            return back()->withErrors([
                'email' => "Something went wrong. Please try again.",
            ]);
        }
    }

    public static function recover(array $data, $back){
        $user = User::where('email', '=', $data['email'])->first();

        if($user){
            $request = $user->hasOneUserRequest()->create([
                'base_request_id'   => 2,
                'users_id'          => $user->id,
                'token'             => BaseHelper::adler32(),
            ]);

            Mail::mailer('mailerdefault')->to($data['email'])->send(new UserRecoveryEmail($request->id));

            return redirect()->route($back)->with('class', 'info')->with('message', 'Please check your email to continue.');
        }
        else{
            return back()->withErrors([
                'email' => "Something went wrong. Please try again.",
            ]);
        }
    }

    public static function getReset(array $data){
        return UserRequest::with([
            'belongsToUser'
        ])->where('token', '=', $data['id'])->firstOrFail();
    }

    public static function reset(array $data, $back){
        $user = User::where('email', '=', $data['email'])->first();

        Auth::logout();

        request()->session()->invalidate();
        
        request()->session()->regenerateToken();

        Auth::loginUsingId($user->id);

        if($data['token']){
            $token = $user->hasOneUserRequest()->where('token', '=', $data['token'])->first();

            $token->update([
                'token' => null,
            ]);
        }

        $user->update([
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route($back)->with('class', 'success')->with('message', 'Your password has been successfully changed.');
    }

    public static function verify(array $data, $back){
        $email = BaseHelper::decrypt($data['id']);

        $user = User::where('email', '=', $email)->first();
        
        $user->update([
            'email_verified_at' => now(),
        ]);

        Auth::logout();

        request()->session()->invalidate();
        
        request()->session()->regenerateToken();

        Auth::loginUsingId($user->id);

        return redirect()->route($back)->with('class', 'success')->with('message', 'Your email has been successfully verified.');
    }

    public static function logout(){
        Auth::logout();
 
        request()->session()->invalidate();
        
        request()->session()->regenerateToken();
    
        return redirect()->route('login')->with('class', 'success')->with('message', 'Successfully ended the session safely.');
    }

    public static function avatar($data){
        $dir = 'system/avatar';

        $user = User::find(auth()->user()->id);

        $storage = Storage::disk('s3public');

        if($user->hasOneUserAvatar->path){
            $storage->delete($dir . '/' . $user->hasOneUserAvatar->path);
        }

        $avatar = $storage->put($dir, $data);

        $user->hasOneUserAvatar()->update([
            'path' => Str::of($avatar)->basename(),
        ]);

        return back()->with('class', 'success')->with('message', "Your avatar is changed successfully.");
    }

    public static function getProfile(array $data, $resource = false){
        $user = User::with(isset($data['with']) ? $data['with'] : [])->where([
            ['id', '=', $data['id']],
        ])->first();

        if($resource == true){
            return new UserResource($user);
        }

        return $user;
    }

    public static function linkDatatable(array $data){
        $datas = UserLink::with([
            'belongsToBaseDecision', 'belongsToBaseLink'
        ])->withAggregate('belongsToBaseLink', 'name')->where([
            ['users_id', '=', '1'],
        ])->orderBy('belongs_to_base_link_name')->get();

        return DataTables::of($datas)->setTransformer(function($datas) use($data){
            return [
                'datas'  => UserLinkResource::make($datas)->resolve(),
                'action' => view('datatable.action-user', [
                    'id'        => BaseHelper::encrypt($datas->id),
                    'decision'  => $datas->base_decision_id,
                    'route'     => $data['route'],
                ])->render(),
            ];
        })->toJson();
    }

    public static function biodata(array $data){
        $user = User::find(auth()->user()->id);

        $user->update([
            'name' => $data['name'],
        ]);

        $user->hasOneUserBiodata()->update([
            'nickname'  => $data['nickname'],
            'dob'       => $data['dob'],
            'dod'       => $data['dod'],
            'biography' => $data['biography'],
        ]);

        return back()->with('class', 'success')->with('message', "Your biodata is changed successfully.");
    }

    public static function content($data){
        $user = User::find(auth()->user()->id);

        $user->belongsToManyUserContent()->sync($data);

        return back()->with('class', 'success')->with('message', "Your focus content is changed successfully.");
    }

    public static function gender($data){
        $user = User::find(auth()->user()->id);

        $user->belongsToManyUserGender()->sync($data);

        return back()->with('class', 'success')->with('message', "Your gender representation is changed successfully.");
    }

    public static function language($data){
        $user = User::find(auth()->user()->id);

        $user->belongsToManyUserLanguage()->sync($data);

        return back()->with('class', 'success')->with('message', "Your main language is changed successfully.");
    }
    
    public static function upsertLink(array $data, $back = '', $id = ''){
        $checking = BaseLink::select('checking')->where([
            ['id', '=', $data['base_link_id']]
        ])->first();

        $default = [
            'base_decision_id' => $checking->checking == true ? 1 : 2,
        ];

        if($id && $id !== null){
            $id = BaseHelper::decrypt($id);

            $upsert = $data;
        }
        else{
            $upsert = array_merge($data, $default);
        }

        $state = $id ? 'changed' : 'added';

        UserLink::updateOrCreate(['id' => $id], $upsert);

        return redirect()->route($back)->with('class', 'success')->with('message', "Your external link is $state successfully.");
    }

    public static function race($data){
        $user = User::find(auth()->user()->id);

        $user->belongsToManyUserRace()->sync($data);

        return back()->with('class', 'success')->with('message', "Your character race is changed successfully.");
    }
}
