<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseSort;

class BaseSortSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        BaseSort::insert([
            ['name' => "ASC", 'description' => "Smallest/newest to largest/oldest (eg. 1 to 10)"],
            ['name' => "DESC", 'description' => "Largest/oldest to smallest/newest (eg. 10 to 1)"],
        ]);
    }
}
