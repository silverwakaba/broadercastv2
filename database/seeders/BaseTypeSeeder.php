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
            [
                'base_decision_id'  => 2,
                'name'              => "General Content Creator",
            ],
            [
                'base_decision_id'  => 2,
                'name'              => "Virtual Content Creator",
            ],
        ]);
    }
}
