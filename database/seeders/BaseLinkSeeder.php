<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseLink;

class BaseLinkSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        BaseLink::insert([
            // Streaming
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => true,
                'name'              => "Twitch",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => true,
                'name'              => "YouTube",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Bilibili",
            ],

            // Social Media - Showcase
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Twitter",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Tiktok",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Instagram",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Carrd",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Discord",
            ],

            // Tips
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Socialbuzz",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Streamlabs",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Trakteer",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Saweria",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "KoFi",
            ],
        ]);
    }
}
