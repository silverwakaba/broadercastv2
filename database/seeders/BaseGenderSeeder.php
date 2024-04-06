<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseGender;

class BaseGenderSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        BaseGender::insert([
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Agender",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Female",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Genderfluid",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Genderflux",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Male",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Non-binary",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Transgender",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Transgender Female",
            ],
            [
                'base_decision_id'  => '2',
                'users_id'          => '1',
                'name'              => "Transgender Male",
            ],
        ]);
    }
}
