<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\BaseHelper;

use App\Events\UserCreated;

use App\Mail\UserVerifyEmail;
use App\Mail\UserRecoveryEmail;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\RecoverRequest;
use App\Http\Requests\Auth\ResetRequest;

use App\Models\User;
use App\Models\UserRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

//
use Illuminate\Support\Facades\Password;

class AuthController extends Controller{
    // Register
    public function register(){
        return view('pages/auth/register');
    }

    public function registerPost(RegisterRequest $request){
        $datas = User::create([
            'base_status_id'    => '6',
            'identifier'        => BaseHelper::adler32(),
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
        ])->assignRole('User');

        return redirect()->route('login')->with('class', 'info')->with('message', 'Your account is ready.');
    }

    // Login
    public function login(){
        return view('pages/auth/login');
    }

    public function loginPost(LoginRequest $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){
            $request->session()->regenerate();

            return redirect()->intended(route('apps.front.index'));
        }
        else{
            return back()->withErrors([
                'email' => "Something went wrong. Please try again.",
            ]);
        }
    }

    // Recover
    public function recover(){
        return view('pages/auth/recover');
    }

    public function recoverPost(RecoverRequest $request){
        $datas = User::where('email', '=', $request->email)->first();

        if($datas){
            $requests = UserRequest::create([
                'base_request_id'   => 2,
                'users_id'          => $datas->id,
                'token'             => BaseHelper::adler32(),
            ]);

            Mail::to($request->email)->send(new UserRecoveryEmail($requests->id));

            return redirect()->route('login')->with('class', 'info')->with('message', 'Please check your email to continue.');
        }
        else{
            return back()->withErrors([
                'email' => "Something went wrong. Please try again.",
            ]);
        }
    }

    // Reset
    public function reset(Request $request){
        $datas = UserRequest::where('token', '=', $request->id)->firstOrFail();

        return view('pages/auth/reset');
    }

    public function resetPost(ResetRequest $request){
        $datas = UserRequest::with([
            'belongsToUser',
        ])->where('token', '=', $request->id)->first();

        Auth::logout();
 
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();

        Auth::loginUsingId($datas->belongsToUser->id);

        $datas->update([
            'token' => null,
        ]);

        $datas->belongsToUser()->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->intended(route('apps.front.index'));
    }

    // Verify
    public function verify(Request $request){
        $email = BaseHelper::decrypt($request->id);

        $user = User::where('email', '=', $email);

        $first = $user->first();
        
        $update = $user->update([
            'email_verified_at' => now(),
        ]);

        Auth::logout();
 
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();

        Auth::loginUsingId($first->id);

        return redirect()->intended(route('apps.front.index'));
    }

    // Logout
    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect()->route('login')->with('class', 'success')->with('message', 'Successfully ended the session safely.');
    }
}
