<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;

use App\Mail\UserRecoveryEmail;

use App\Models\User;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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

            Mail::to($data['email'])->send(new UserRecoveryEmail($request->id));

            return redirect()->route($back)->with('class', 'info')->with('message', 'Please check your email to continue.');
        }
        else{
            return back()->withErrors([
                'email' => "Something went wrong. Please try again.",
            ]);
        }
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
}
