<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// T
use App\Models\User;
use App\Events\UserCreated;

class FrontController extends Controller{
    // Index
    public function index(){
        return view('pages/index');
    }

    public function indexPost(Request $request){
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
        ])->assignRole('User');

        return $user;
    }

    public function faker(){
        $faker = \Faker\Factory::create();

        $user = User::create([
            'name'      => $faker->name(),
            'email'     => $faker->email(),
            'password'  => bcrypt('123456789'),
        ])->assignRole('User');

        return UserCreated::dispatch($user);
    }
}
