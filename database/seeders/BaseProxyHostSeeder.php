<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BaseProxyHost;

class BaseProxyHostSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        BaseProxyHost::insert([
            // Tor
            [
                'base_proxy_type_id'    => 1,
                'online'                => true,
                'host'                  => 'http://103.76.129.3:12053',
            ],

            // YTS
            [
                'base_proxy_type_id'    => 2,
                'online'                => true,
                'host'                  => 'http://yts.spn.my.id',
            ],
        ]);
    }
}
