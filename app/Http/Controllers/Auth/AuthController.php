<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\BaseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\RecoverRequest;
use App\Http\Requests\Auth\ResetRequest;
use App\Repositories\Setting\UserRepositories;
use Illuminate\Http\Request;

class AuthController extends Controller{
    // Register
    public function register(){
        return view('pages/auth/register');
    }

    public function registerPost(RegisterRequest $request){
        return UserRepositories::register([
            'base_status_id'    => 6,
            'identifier'        => BaseHelper::adler32(),
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
        ], 'login');
    }

    // Login
    public function login(){
        return view('pages/auth/login');
    }

    public function loginPost(LoginRequest $request){
        return UserRepositories::login([
            'email'     => $request->email,
            'password'  => $request->password,
            'remember'  => $request->remember,
        ]);
    }

    // Recover
    public function recover(){
        return view('pages/auth/recover');
    }

    public function recoverPost(RecoverRequest $request){
        return UserRepositories::recover([
            'email' => $request->email,
        ], 'login');
    }

    // Reset
    public function reset(Request $request){
        $datas = UserRepositories::getReset([
            'id' => $request->id,
        ]);

        return view('pages/auth/reset', [
            'datas' => $datas,
        ]);
    }

    public function resetPost(ResetRequest $request){
        return UserRepositories::reset([
            'token'     => $request->token,
            'email'     => $request->email,
            'password'  => $request->password,
        ], 'apps.front.index');
    }

    // Verify
    public function verify(Request $request){
        return UserRepositories::verify([
            'id' => $request->id,
        ], 'apps.front.index');
    }

    // Logout
    public function logout(Request $request){
        return UserRepositories::logout();
    }
}
