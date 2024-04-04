<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\BaseHelper;

use App\Events\UserCreated;
use App\Mail\UserVerifyEmail;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller{
    // Register
    public function register(){
        return view('pages/auth/register');
    }

    public function registerPost(RegisterRequest $request){
        $datas = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
        ])->assignRole('User');

        UserCreated::dispatch($datas);

        Mail::to($request->email)->send(new UserVerifyEmail($datas->id));

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

    // Logout
    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect()->route('login')->with('class', 'success')->with('message', 'Successfully ended the session safely.');
    }

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
}
