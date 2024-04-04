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
            ['name' => 'Registration'],
            ['name' => 'Password Recovery'],
        ]);
    }
}
