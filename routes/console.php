<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('test-user', function () {
    $faker = \Faker\Factory::create();

    \App\Models\User::query()->create([
            'name' => $faker->name(),
            'email' => $faker->email(),
            'password' => bcrypt('123456789'),
        ]);
});