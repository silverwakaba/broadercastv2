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

use Carbon\Carbon;

class YoutubeCron extends Controller{
    public function fetchDebug(){
        // return YoutubeRepositories::fetchActivityViaCrawler("UCurEA8YoqFwimJcAuSHU0MQ", 1);
        // return YoutubeRepositories::fetchProfile("UCDe3iqZiVXIXQbgIR36mF6w", 1);

        // Via API
        return YoutubeRepositories::fetchVideoStatus("0Zr2l5ACFoU");

        // return YoutubeRepositories::fetchArchiveViaAPI("UC1tRqQTI3Bchs8XvUnj8yvQ", 1);
        // return YoutubeRepositories::fetchArchiveViaFeed("UCjXBuHmWkieBApgBhDuJMMQ", 1);
    }

    public function fetchUserLinkTrackerDaily(){
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

    public function fetchUserLinkTrackerMinutely(){
        $tracker = UserLinkTracker::where([
            ['base_link_id', '=', 2],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Initialization acrhive
                    YoutubeRepositories::fetchArchiveViaAPI($chunk->identifier, $chunk->users_id);
                    
                    // Normal archive
                    YoutubeRepositories::fetchArchiveViaFeed($chunk->identifier, $chunk->users_id);

                    // Fetch channel activity
                    YoutubeRepositories::fetchActivityViaCrawler($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });
    }

    public function fetchUserFeedMinutely(){
        $feed = UserFeed::where([
            ['base_link_id', '=', 2],
        ])->select('identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Archive Status (like delete the archive from DB if it isn't on YouTube anymore)
                    YoutubeRepositories::fetchArchiveStatus($chunk->identifier);
                }
                catch(\Throwable $th){}
            }
        });   
    }
}
