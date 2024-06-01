<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;

use App\Models\BaseAPI;
use App\Models\UserFeed;
use App\Models\UserLinkTracker;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Repositories\Service\YoutubeRepositories;

// Delete
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class YoutubeCron extends Controller{
    public function fetchDebug(){
        // $videoID = 'Bvj-LQDBqBQ';
        // $videoLink = "www.youtube.com/watch?v=$videoID";

        // $http = Http::get('https://web.scraper.workers.dev', [
        //     'url'       => $videoLink,
        //     'selector'  => 'title,script',
        //     'scrape'    => 'text',
        //     'spaced'    => 'true',
        //     'pretty'    => 'true',
        // ])->json();

        // $notFound = "- YouTube";

        // if(($http['result']['title'] == $notFound)){
        //     return "Not Found and delete";
        // }

        return YoutubeRepositories::fetchArchiveStatus("ded");
    }

    public function fetchEveryDay(){
        UserLinkTracker::where([
            ['base_link_id', '=', 2],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Profile
                    YoutubeRepositories::fetchProfile($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });
    }

    public function fetchEveryMinuteOne(){
        $tracker = UserLinkTracker::where([
            ['base_link_id', '=', 2],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Archive
                    YoutubeRepositories::fetchArchiveViaFeed($chunk->identifier, $chunk->users_id);

                    // Activity
                    YoutubeRepositories::fetchActivity($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });
    }

    public function fetchEveryMinuteTwo(){
        $feed = UserFeed::where([
            ['base_link_id', '=', 2],
        ])->select('identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Archive Status
                    YoutubeRepositories::fetchArchiveStatus($chunk->identifier);
                }
                catch(\Throwable $th){}
            }
        });   
    }
}
