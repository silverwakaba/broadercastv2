<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseType;

class BaseTypeSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        BaseType::insert([
            // v-Ism
            [
                'base_decision_id'  => 2,
                'name'              => "vTuber",
            ],
            [
                'base_decision_id'  => 2,
                'name'              => "vSinger",
            ],
            [
                'base_decision_id'  => 2,
                'name'              => "vInfluencer",
            ],

            // General
            [
                'base_decision_id'  => 2,
                'name'              => "Clipper",
            ],
            [
                'base_decision_id'  => 2,
                'name'              => "Streamer",
            ],
        ]);
    }
}
