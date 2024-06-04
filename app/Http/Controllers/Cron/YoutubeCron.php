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
        // return YoutubeRepositories::fetchArchiveViaFeed("UC5OStgYPn8_UbILMFNFF_-w", 1);

        return YoutubeRepositories::fetchActivity("UCjXBuHmWkieBApgBhDuJMMQ", 1);
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

    public function fetchUserLinkTracker(){
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

    public function fetchUserFeed(){
        $feed = UserFeed::where([
            ['base_link_id', '=', 2],
        ])->select('identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Archive Status (like delete if it isn't on YouTube anymore)
                    YoutubeRepositories::fetchArchiveStatus($chunk->identifier);
                }
                catch(\Throwable $th){}
            }
        });   
    }
}
