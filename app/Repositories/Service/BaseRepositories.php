<?php

namespace App\Repositories\Service;

use App\Models\BaseProxyHost;
use App\Models\User;
use App\Models\UserRequest;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

use Carbon\Carbon;

class BaseRepositories{
    public static function initSetup(){
        // 
    }

    public static function hostCheck(){
        try{
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
        catch(\Throwable $th){
            // 
        }
    }

    public static function userRequestCleanup(){
        try{
            $carbon = new Carbon();

            $data = UserRequest::select('id', 'created_at')->chunkById(100, function(Collection $chunks) use($carbon){
                $compareData = $carbon->now()->subHour(1)->timezone(config('app.timezone'))->timestamp;
                
                foreach($chunks as $key => $chunk){
                    if($carbon->parse($chunk->created_at)->timestamp <= $compareData){
                        $chunk->delete();
                    }
                }
            });
        }
        catch(\Throwable $th){
            // 
        }
    }

    /**
     * Sitemap-related function
     * We're using internal cdn from Cloudflare R2, that won't leave residue when the file is overwritten, unlike Blackblaze
    **/

    public static function sitemapDisk(){
        return "public";
    }

    public static function sitemapPath(){
        return "sitemap";
    }

    public static function sitemapMainIndex(){
        try{
            $listURL = [
                // Index
                route('index'),
                
                // Creator
                route('creator.index'),
                
                // Content
                route('content.live'),
                route('content.scheduled'),
                route('content.archived'),
                route('content.uploaded'),
            ];
    
            $createSitemap = Sitemap::create();
    
            foreach($listURL as $key => $url){
                if($key == 0){
                    $createSitemap->add(Url::create($url)->setLastModificationDate(Carbon::yesterday())->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)->setPriority(1.0));
                }
                else{
                    $createSitemap->add(Url::create($url)->setLastModificationDate(Carbon::yesterday())->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)->setPriority(0.8));
                }
            }
    
            $datas = $createSitemap->writeToDisk(self::sitemapDisk(), self::sitemapPath() . 'sitemap-index-main.xml', true);
        }
        catch(\Throwable $th){
            // 
        }
    }

    public static function sitemapUserDaily(){
        try{
            $addToSitemap = User::where([
                ['sitemaped', '=', false],
            ])->select('id', 'identifier')->whereHas('belongsToManyUserLinkTrackerAsSitemapableQuery')->whereHas('belongsToManyUserFeedAsSitemapableQuery')->get();

            if(isset($addToSitemap) && ($addToSitemap) && ($addToSitemap->count() >= 1)){
                $sitemapUser = Sitemap::create()
                    ->add($addToSitemap)
                ->writeToDisk(self::sitemapDisk(), self::sitemapPath() . 'sitemap-user-' . Carbon::now()->format('Y-m-d-his') .'.xml', true);
        
                $updateUserAddToSitemap = User::where([
                    ['sitemaped', '=', false],
                ])->whereIn('id', $addToSitemap->pluck('id'))->update([
                    'sitemaped' => true,
                ]);
            }
        }
        catch(\Throwable $th){
            // 
        }
    }

    public static function sitemapUserIndex(){
        try{
            $existingUserSitemap = Storage::disk(self::sitemapDisk())->files(self::sitemapPath());

            $existingUserSitemapCollection = collect($existingUserSitemap)->filter(function ($item){
                if(!Str::contains($item, ['sitemap-index-main.xml', 'sitemap-index-user.xml'])){
                    return $item;
                }
            })->all();

            $existingUserSitemaps = array_values($existingUserSitemapCollection);

            if(isset($existingUserSitemaps) && ($existingUserSitemaps) && (count($existingUserSitemaps) >= 1)){
                $createSitemap = SitemapIndex::create();

                foreach($existingUserSitemaps as $key => $url){
                    $createSitemap->add(Str::of(config('app.cdn_internal_url') . '/')->append($url));
                }
        
                $datas = $createSitemap->writeToDisk(self::sitemapDisk(), self::sitemapPath() . 'sitemap-index-user.xml', true);
            }
        }
        catch(\Throwable $th){
            // 
        }
    }
}
