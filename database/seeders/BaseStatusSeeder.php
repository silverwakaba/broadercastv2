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
            // Profile status
            ['name' => "Active"],
            ['name' => "Inactive"],
            ['name' => "Hiatus"],
            ['name' => "Retired"],
            ['name' => "Draft"], // 5
            ['name' => "Unknown"], // 6

            // Feed status, weighted from the most important
            ['name' => "Scheduled"], // 7
            ['name' => "Live"], // 8
            ['name' => "Archived"], // 9
            ['name' => "Direct Upload"], // 10

            // Other status
            ['name' => "System Generated User"], // 11
        ]);
    }
}
