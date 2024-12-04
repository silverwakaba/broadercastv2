<?php

namespace App\Repositories\Service;

use App\Models\BaseProxyHost;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class BaseRepositories{
    public static function initSetup(){
        // 
    }

    public static function hostCheck(){
        BaseProxyHost::select('id', 'host')->chunkById(10, function(Collection $chunks) use(&$endpoint, &$host){
            foreach($chunks as $key => $chunk){
                $endpoint[] = [
                    'id'    => $chunk->id,
                    'host'  => $chunk->host,
                ];
            }

            $responses = Http::pool(fn (Pool $pool) => [
                ...array_map(fn ($endpoint) => $pool->as($endpoint['id'])->timeout(1)->get($endpoint['host']), $endpoint),
            ]);

            $result = collect($responses)->whereNotNull('cookies')->all();

            foreach($result as $key => $status){
                $host[] = [
                    'id' => $key,
                ];
            }

            $online = collect($host)->pluck('id')->all();

            BaseProxyHost::whereIn('id', $online)->update([
                'online' => true,
            ]);
            
            BaseProxyHost::whereNotIn('id', $online)->update([
                'online' => false,
            ]);
        });
    }
}
