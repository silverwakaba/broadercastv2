<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseRequest;

class BaseRequestSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        BaseRequest::insert([
            ['name' => "Email Verification"],
            ['name' => "Email Change"],
            ['name' => "Password Reset"],
            ['name' => "Login via OTP / 2FA / Authenticator-like"],
            ['name' => "Login via Reserved 1"],
            ['name' => "Login via Reserved 2"],
            ['name' => "Login via Reserved 3"],
            ['name' => "Login via Reserved 4"],
            ['name' => "Login via Reserved 5"],
            ['name' => "Claim Account - SGU"],
            ['name' => "Claim Account - Reserved 1"],
            ['name' => "Claim Account - Reserved 2"],
            ['name' => "Claim Account - Reserved 3"],
            ['name' => "Claim Account - Reserved 4"],
            ['name' => "Claim Account - Reserved 5"],
        ]);
    }
}
