<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseAPI;

class BaseAPISeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        BaseAPI::insert([
            /**
             * Twitch API
            **/
            [
                'base_link_id'  => 1,
                'client_id'     => "7rrc3ifer1dcw4178d5iylqt7k0yzs",  // Main Twitch Client
                'client_key'    => null,
                'client_secret' => "f9t4j1yitz8vy47lrsa9bfdut1cdah",
                'bearer'        => "lks9e9c43wsfm12f3336u4ps9svdw6",
            ],
            // [
            //     'base_link_id'  => 1,
            //     'client_id'     => "j1sg2t54dwptembv45th3uuzqkgo6e",
            //     'client_key'    => null,
            //     'client_secret' => "p9t9i4fez9eoicclqif8o04joeggog",
            //     'bearer'        => "grbgx3zlr5vbv0ffubusawcp12acy3",
            // ],

            /**
             * Youtube API
            **/
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyCG2E8UACFHwuvVhb45dukAPkC0Agwj9WQ", // Main Youtube Key
                'client_secret' => null,
                'bearer'        => null,
            ],
            // [
            //     'base_link_id'  => 2,
            //     'client_id'     => null,
            //     'client_key'    => "AIzaSyA5-XF2wJ0RcQCiD1OIgPNDHqn1mFg1fmI",
            //     'client_secret' => null,
            //     'bearer'        => null,
            // ],
            // [
            //     'base_link_id'  => 2,
            //     'client_id'     => null,
            //     'client_key'    => "AIzaSyAnEyfCfXoM0Mccc2HlpgP8I75tH9YUl3Q",
            //     'client_secret' => null,
            //     'bearer'        => null,
            // ],
            // [
            //     'base_link_id'  => 2,
            //     'client_id'     => null,
            //     'client_key'    => "AIzaSyDB4uBVeLaw_fXoVL81RBSSHeqcLQcYo8M",
            //     'client_secret' => null,
            //     'bearer'        => null,
            // ],
        ]);
    }
}
