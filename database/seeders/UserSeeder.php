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

        User::create([
            'name'      => $faker->name(),
            'email'     => 'a@a.a',
            'password'  => bcrypt('123456789'),
        ])->assignRole('User');
    }
}
