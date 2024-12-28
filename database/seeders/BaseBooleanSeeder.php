<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseBoolean;

class BaseBooleanSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        BaseBoolean::insert([
            [
                'name'  => "True",
                'value' => true,
            ],
            [
                'name'  => "False",
                'value' => false,
            ],
        ]);
    }
}
