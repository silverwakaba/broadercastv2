<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseLanguage;

class BaseLanguageSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        BaseLanguage::insert([
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Arabic",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Cantonese",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Chinese",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "English",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Filipino",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "French",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "German",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Greek",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Hindi",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Hungarian",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Indonesian",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Italian",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Japanese",

            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Korean",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Malay",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Polish",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Portuguese",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Russian",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Spanish",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Swedish",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Thai",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Turkish",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Ukrainian",
            ],
        ]);
    }
}
