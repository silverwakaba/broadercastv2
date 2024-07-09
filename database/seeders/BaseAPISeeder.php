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
                'client_id'     => "7rrc3ifer1dcw4178d5iylqt7k0yzs",
                'client_key'    => null,
                'client_secret' => "f9t4j1yitz8vy47lrsa9bfdut1cdah",
                'bearer'        => "o7nixq1kknpp3csq5ajy9o0dstref3",
            ],
            [
                'base_link_id'  => 1,
                'client_id'     => "j1sg2t54dwptembv45th3uuzqkgo6e",
                'client_key'    => null,
                'client_secret' => "p9t9i4fez9eoicclqif8o04joeggog",
                'bearer'        => "grbgx3zlr5vbv0ffubusawcp12acy3",
            ],

            /**
             * Youtube API
            **/
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyDOahgrCf-qJi7JHPAl2x1jjEYJmGqrdQ8",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyA5-XF2wJ0RcQCiD1OIgPNDHqn1mFg1fmI",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyAnEyfCfXoM0Mccc2HlpgP8I75tH9YUl3Q",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyDB4uBVeLaw_fXoVL81RBSSHeqcLQcYo8M",
                'client_secret' => null,
                'bearer'        => null,
            ],

            // abetb152@gmail.com
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyBeYXYgdj5GFFKaMnPsomsoqx6JllBBiJQ",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyAwfdtxt1UxaE3LBoLA14L_QAthLkJjlYM",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyDNMP2UCqIEYvKWFavdc6qOAWzjaTpQdqE",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyC4nJGyq4kgnY7ihwVw-e_JnHctXHnMpFw",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyCFzLKSkmbNWXMSF9sz6QoFb2X8z6WOW8w",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyDw_PTf-7S2-Jabb2F3NKkvpNf6Ca4DBlY",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyCUPUpT1jK7l2ySX627_UJUp0_w5g-cB_w",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyD9dGrjPyTi9X6pwR0wsnt9yGS6xArd4qQ",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyBA7NGjOeVWyk5I0jzU8wJetQ67Tm-VTNQ",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyBaV8peBEqBqH2-tbYtc6S37sx6ehT7HDk",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyCA-AM53DEBjsyLqlPC0O_EV44ffp67Bgk",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyCNWa3s5c2Iu7ninZn404EUnjJelUUgVBU",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyDnKXW1_grmVIPBsRG3myK463yox3aFq7Y",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyBnkesczTETKRUn4Rj5JLsdaw-K3Xh9KYM",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyBD0PRLt3RaASyfm0ocp4HuOikqyjodGFc",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyCkrpufu4z5G2Gqu7e0fckNp70ds3ujjSQ",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyCHEkdGdjvV9RnbIlEerhsOEMs0vLYs67g",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyCNevrVoyoTESj0tx2FV-BlBL1i9hfdpPg",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyByYEhZCJZcHb6RRHGMRji2t4-smVYA-6M",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyAyZaKiw0WaXl-hZUtiMrQmTDFEsLdZddo",
                'client_secret' => null,
                'bearer'        => null,
            ],

            // wakadiscordbotserver@gmail.com
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyAdaa4YaEMVil-bAAEEy1yuVyvxIiqScW0",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyCq6Kmo16P0UuNAsQLg-Ptl2Zdu_sWzjO4",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyBOQ30jF6nHHMy1CDKUjSlaBFx4eIK6PLI",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyBBDMDBWQaqlA7_0-8V18fx9eTzrafyEJM",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyCk1I3S-fNYiKOdHrIyystFcTCMhnjJO5I",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyAyIfg17OcmBRVSzM-dwhIQdikQmZ8omuo",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyAk4_NaKFpiiVXkifbCAfYhLeqq6DB_EU0",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyDnTLK3LKi7vUm1-ObH_KIICyReASK8V0c",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyCwwVfWxIHfeq2b0H9wFYoxVxTyUmvDutQ",
                'client_secret' => null,
                'bearer'        => null,
            ],
            [
                'base_link_id'  => 2,
                'client_id'     => null,
                'client_key'    => "AIzaSyAMaPRNqnHN18p223optWRZdj30c4mPKKU",
                'client_secret' => null,
                'bearer'        => null,
            ],
        ]);
    }
}
