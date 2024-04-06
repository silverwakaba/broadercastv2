<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseStatus;

class BaseStatusSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        BaseStatus::insert([
            ['name' => "Active"],
            ['name' => "Inactive"],
            ['name' => "Hiatus"],
            ['name' => "Retired"],
            ['name' => "Draft"],
            ['name' => "Unknown"],
        ]);
    }
}
