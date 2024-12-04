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
                'online'                => false,
                'host'                  => 'http://85.208.9.45:12053',
            ],
            [
                'base_proxy_type_id'    => 1,
                'online'                => false,
                'host'                  => 'http://85.208.9.143:12053',
            ],
            [
                'base_proxy_type_id'    => 1,
                'online'                => false,
                'host'                  => 'http://103.76.129.30:12053',
            ],

            // YTS
            [
                'base_proxy_type_id'    => 2,
                'online'                => false,
                'host'                  => 'http://yts.spn.my.id',
            ],
            [
                'base_proxy_type_id'    => 2,
                'online'                => false,
                'host'                  => 'http://yts-1.spn.my.id',
            ],
            [
                'base_proxy_type_id'    => 2,
                'online'                => false,
                'host'                  => 'http://yts-2.spn.my.id',
            ],
            [
                'base_proxy_type_id'    => 2,
                'online'                => false,
                'host'                  => 'http://yts-3.spn.my.id',
            ],
        ]);
    }
}
