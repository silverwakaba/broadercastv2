<?php

namespace Database\Seeders;

use App\Helpers\BaseHelper;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        // User::factory(1)->create();

        // $faker = \Faker\Factory::create();
        
        // Waka
        User::create([
            'base_status_id'    => '1',
            'confirmed'         => true,
            'identifier'        => BaseHelper::adler32(),
            'name'              => 'Kurokuma Wakaba',
            'email'             => 'a@a.a',
            'password'          => bcrypt('123456789'),
        ])->assignRole('Admin');

        // Robot
        User::create([
            'base_status_id'    => '1',
            'confirmed'         => true,
            'identifier'        => 'robot404',
            'name'              => 'Robot',
            'email'             => BaseHelper::randomEmail(),
            'password'          => BaseHelper::randomPassword(),
        ]);
    }
}
