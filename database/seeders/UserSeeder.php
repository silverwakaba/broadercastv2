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
            
        User::create([
            'base_status_id'    => '6',
            'confirmed'         => true,
            'identifier'        => BaseHelper::adler32(),
            'email'             => 'a@a.a',
            'password'          => bcrypt('123456789'),
        ])->assignRole('Admin');

        // User::create([
        //     'base_status_id'    => '6',
        //     'confirmed'         => false,
        //     'identifier'        => BaseHelper::adler32(),
        //     'email'             => 'b@a.a',
        //     'password'          => bcrypt('123456789'),
        // ])->assignRole('User');
    }
}
