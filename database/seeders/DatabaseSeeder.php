<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    /**
     * Seed the application's database.
     */
    public function run() : void{
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            BaseDecisionSeeder::class,
            BaseStatusSeeder::class,
            UserSeeder::class,
            BaseRequestSeeder::class,
            BaseTypeSeeder::class,
            BaseContentSeeder::class,
            BaseLanguageSeeder::class,
            BaseGenderSeeder::class,
            BaseRaceSeeder::class,
            BaseLinkSeeder::class,
            BaseAPISeeder::class,
            BaseTimezoneSeeder::class,
            // BaseActivitySeeder::class,
        ]);
    }
}
