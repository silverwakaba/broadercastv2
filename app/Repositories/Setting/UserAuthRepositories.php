<?php

namespace App\Repositories\Setting;

use App\Helpers\BaseHelper;
use App\Helpers\BaseMailer;
use App\Helpers\RedirectHelper;

use App\Mail\User2FAEmail; // rename as User2FALoginEmail later
use App\Mail\UserRecoveryEmail;
use App\Mail\UserVerifyEmail;

use App\Models\User;
use App\Models\UserRequest;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserAuthRepositories{
    // Register
    public static function register(array $data, $back, $role = ''){
        if(!$role){
            $role = 'User';
        }

        $user = User::create($data)->assignRole($role);

        return RedirectHelper::routeBack($back, 'success', 'Registration', 'register');
    }

    // Login
    public static function login(array $data){
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $data['remember'])){
            $secured = User::where([
                ['email', '=', $data['email']],
                ['2fa', '=', true],
            ])->whereNotNull('email_verified_at')->first();

            if($secured){
                $request = $secured->hasOneUserRequest()->where([
                    ['base_request_id', '=', 4],
                    ['users_id', '=', $secured->id],
                    ['token', '!=', null],
                ])->first();
    
                if($secured){
                    if($request){
                        $mId = $request->id;
                    }
                    else{
                        $cmId = $secured->hasOneUserRequest()->create([
                            'base_request_id'   => 4,
                            'users_id'          => $secured->id,
                            'token'             => BaseHelper::adler32(),
                        ]);
                    
                        $mId = $cmId->id;
                    }
    
                    Mail::to($data['email'])->send(new User2FAEmail($mId));
                }

                Auth::logout();
     
                request()->session()->invalidate();
                
                request()->session()->regenerateToken();

                return RedirectHelper::routeBack('login', 'info', 'Login Securely', '2falogin');
            }
            else{
                request()->session()->regenerate();
    
                return RedirectHelper::routeIntended(route('apps.front.index'));
            }
        }
        else{
            return RedirectHelper::routeBackWithErrors([
                'email'     => "Is the email valid?",
                'password'  => "Is the password correct?",
            ]);
        }
    }

    // Login 2FA
    public static function login2FA(array $data, $back){
        $request = UserRequest::with([
            'belongsToUser'
        ])->where([
            ['base_request_id', '=', 4],
            ['token', '=', $data['id']],
        ])->firstOrFail();

        $user = $request->belongsToUser;

        Auth::logout();

        request()->session()->invalidate();
        
        request()->session()->regenerateToken();

        Auth::loginUsingId($user->id);

        $request->update([
            'token' => null,
        ]);
        
        return RedirectHelper::routeBack($back, 'success', 'Login Securely', '2faloginsuccess');
    }

    // Recover
    public static function recover(array $data, $back){
        $user = User::where([
            ['email', '=', $data['email']],
        ])->whereNotNull('email_verified_at')->first();

        if($user){
            $request = $user->hasOneUserRequest()->where([
                ['base_request_id', '=', 2],
                ['users_id', '=', $user->id],
                ['token', '!=', null],
            ])->first();

            if($request){
                $mId = $request->id;
            }
            else{
                $cmId = $user->hasOneUserRequest()->create([
                    'base_request_id'   => 2,
                    'users_id'          => $user->id,
                    'token'             => BaseHelper::adler32(),
                ]);

                $mId = $cmId->id;
            }

            Mail::to($data['email'])->send(new UserRecoveryEmail($mId));

            return RedirectHelper::routeBack($back, 'success', 'Recover', 'recover');
        }
        else{
            return RedirectHelper::routeBackWithErrors([
                'email' => "Something went wrong. Please try again.",
            ]);
        }
    }

    // Reset
    public static function getReset(array $data){
        return UserRequest::with([
            'belongsToUser'
        ])->where([
            ['base_request_id', '=', 2],
            ['token', '=', $data['id']],
        ])->firstOrFail();
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
            'password' => bcrypt($data['new_password']),
        ]);

        return RedirectHelper::routeBack($back, 'success', 'Reset', 'reset');
    }

    // Verify
    public static function verify(array $data, $back){
        $request = UserRequest::with([
            'belongsToUser'
        ])->where([
            ['base_request_id', '=', 1],
            ['token', '=', $data['id']],
        ])->firstOrFail();

        $user = $request->belongsToUser;
        
        $user->update([
            'confirmed'         => true,
            'email_verified_at' => Carbon::now()->timezone(config('app.timezone'))->toDateTimeString(),
        ]);

        Auth::logout();

        request()->session()->invalidate();
        
        request()->session()->regenerateToken();

        Auth::loginUsingId($user->id);

        $request->update([
            'token' => null,
        ]);
        
        return RedirectHelper::routeBack($back, 'success', 'Verify', 'verify');
    }

    // Verify Resend
    public static function verifyResend(array $data, $back){
        $user = User::where([
            ['email', '=', $data['email']],
            ['confirmed', '=', false],
            ['email_verified_at', '=', null],
        ])->first();

        if($user){
            $request = $user->hasOneUserRequest()->where([
                ['base_request_id', '=', 1],
                ['users_id', '=', $user->id],
                ['token', '!=', null],
            ])->first();

            if($request){
                $mId = $request->id;
            }
            else{
                $cmId = $user->hasOneUserRequest()->create([
                    'base_request_id'   => 2,
                    'users_id'          => $user->id,
                    'token'             => BaseHelper::adler32(),
                ]);

                $mId = $cmId->id;
            }

            Mail::to($data['email'])->send(new UserVerifyEmail($mId));

            return RedirectHelper::routeBack($back, 'success', 'Verify', 'reverify');
        }
        else{
            return RedirectHelper::routeBackWithErrors([
                'email' => "Something went wrong. Please try again.",
            ]);
        }
    }

    // Claim
    public static function getClaim(array $data){
        return UserRequest::with([
            'belongsToUser'
        ])->where([
            ['base_request_id', '=', 3],
            ['token', '=', $data['id']],
        ])->firstOrFail();
    }

    public static function claim(array $data, $back){
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
            'base_status_id'    => 1,
            'email'             => $data['new_email'],
            'password'          => bcrypt($data['new_password']),
        ]);

        if(!$user->hasRole('User')){
            $user->assignRole('User');
        }

        return RedirectHelper::routeBack($back, 'success', 'Reset', 'reset');
    }

    // Logout
    public static function logout(){
        Auth::logout();
 
        request()->session()->invalidate();
        
        request()->session()->regenerateToken();
    
        return RedirectHelper::routeBack('login', 'success', 'Logout');
    }
}
