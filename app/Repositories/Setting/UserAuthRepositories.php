<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;

use App\Mail\UserRecoveryEmail;

use App\Models\User;
use App\Models\UserRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserAuthRepositories{
    public static function register(array $data, $back, $role = ''){
        if(!$role){
            $role = 'User';
        }

        $user = User::create($data)->assignRole($role);

        $user->hasOneUserRequest()->create([
            'base_request_id'   => 1,
            'users_id'          => $user->id,
        ]);

        return RedirectHelper::routeBack($back, 'success', 'Registration', 'register');
    }

    public static function login(array $data){
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $data['remember'])){
            request()->session()->regenerate();

            return RedirectHelper::routeIntended(route('apps.front.index'));
        }
        else{
            return RedirectHelper::routeBackWithErrors([
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

            return RedirectHelper::routeBack($back, 'success', 'Recover', 'recover');
        }
        else{
            return RedirectHelper::routeBackWithErrors([
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

        return RedirectHelper::routeBack($back, 'success', 'Reset', 'reset');
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
        
        return RedirectHelper::routeBack($back, 'success', 'Verify', 'verify');
    }

    public static function logout(){
        Auth::logout();
 
        request()->session()->invalidate();
        
        request()->session()->regenerateToken();
    
        return RedirectHelper::routeBack('login', 'success', 'Logout');
    }
}
