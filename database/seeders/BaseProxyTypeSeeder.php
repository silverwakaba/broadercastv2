<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseProxyType;

class BaseProxyTypeSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        BaseProxyType::insert([
            ['name' => 'Tor'], // 1
            ['name' => 'YTS'], // 2
        ]);
    }
}
