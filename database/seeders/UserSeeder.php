<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        $faker = \Faker\Factory::create();

        // User::factory(1)->create();

        User::create([
            'base_status_id'    => '6',
            'confirmed'         => true,
            'identifier'        => 'waka',
            'email'             => 'a@a.a',
            'password'          => bcrypt('123456789'),
        ])->assignRole('Admin');

        User::create([
            'base_status_id'    => '6',
            'confirmed'         => true,
            'identifier'        => $faker->name(),
            'email'             => $faker->email(),
            'password'          => bcrypt('123456789'),
        ])->assignRole('User');
    }
}
