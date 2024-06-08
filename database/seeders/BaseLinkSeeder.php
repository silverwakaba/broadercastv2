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
                'icon'              => null,
                'url_content'       => null,
                'url_thumbnail'     => null,
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => true,
                'name'              => "YouTube",
                'icon'              => null,
                'url_content'       => "https://www.youtube.com/watch?v=REPLACETHISPLACEHOLDER",
                'url_thumbnail'     => "https://i.ytimg.com/vi/REPLACETHISPLACEHOLDER/maxresdefault_live.jpg",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Bilibili (Bstation)",
                'icon'              => "Bilibili",
                'url_content'       => null,
                'url_thumbnail'     => null,
            ],

            // Social Media - Showcase
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Twitter",
                'icon'              => "X",
                'url_content'       => null,
                'url_thumbnail'     => null,
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Tiktok",
                'icon'              => null,
                'url_content'       => null,
                'url_thumbnail'     => null,
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Instagram",
                'icon'              => null,
                'url_content'       => null,
                'url_thumbnail'     => null,
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Carrd",
                'icon'              => null,
                'url_content'       => null,
                'url_thumbnail'     => null,
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Discord Server",
                'icon'              => "Discord",
                'url_content'       => null,
                'url_thumbnail'     => null,
            ],

            // Tips
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Socialbuzz",
                'icon'              => "404",
                'url_content'       => null,
                'url_thumbnail'     => null,
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Streamlabs",
                'icon'              => null,
                'url_content'       => null,
                'url_thumbnail'     => null,
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Trakteer",
                'icon'              => "404",
                'url_content'       => null,
                'url_thumbnail'     => null,
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "Saweria",
                'icon'              => "404",
                'url_content'       => null,
                'url_thumbnail'     => null,
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'checking'          => false,
                'name'              => "KoFi",
                'icon'              => null,
                'url_content'       => null,
                'url_thumbnail'     => null,
            ],
        ]);
    }
}
