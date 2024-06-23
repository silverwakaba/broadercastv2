<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseFeedType;

class BaseFeedTypeSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    
    // Khusus untuk tipe feed "mis: Gaming, Music, Cover, dll
    
    public function run() : void{
        BaseFeedType::insert([
            // ['name' => "Unknown"],
            // ['name' => "Live"],
            // ['name' => "Scheduled"],
            // ['name' => "Archived"],
            // ['name' => "Direct Upload"],
        ]);
    }
}
