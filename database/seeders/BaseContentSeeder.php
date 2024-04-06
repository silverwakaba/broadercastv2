<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseContent;

class BaseContentSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        BaseContent::insert([
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Anime",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Art",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "ASMR",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Chatting",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Comedy",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Cooking",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Education",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Gaming",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Horror",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "LGBTQ+",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Manga",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Mature",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Music",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Voice Acting",
            ],
        ]);
    }
}
