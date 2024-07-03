<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseCountry;
use Illuminate\Support\Facades\Http;

class BaseCountrySeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        $http = Http::acceptJson()->get('https://api.first.org/data/v1/countries', [
            'pretty'    => true,
            'scope'     => 'full',
            'limit'     => 512,
        ])->json();

        foreach($http['data'] as $datas){
            BaseCountry::create([
                'id2'   => $datas['id2'],
                'id3'   => $datas['id3'],
                'name'  => $datas['country'],
            ]);
        }
    }
}
