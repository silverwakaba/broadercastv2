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
            ['name' => "Active"], // 1
            ['name' => "Inactive"], // 2
            ['name' => "Hiatus"], // 3
            ['name' => "Retired"], // 4
            ['name' => "Draft"], // 5
            ['name' => "Unknown"], // 6
            ['name' => "Live"], // 7
            ['name' => "Scheduled"], // 8
            ['name' => "Archived"], // 9
            ['name' => "Direct Upload"], // 10
        ]);
    }
}
