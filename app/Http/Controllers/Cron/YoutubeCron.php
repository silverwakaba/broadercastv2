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
use App\Helpers\BaseHelper;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

use Carbon\CarbonInterval;
// CarbonInterval::create("PT28M15S")->format('%H:%M:%S');

class YoutubeCron extends Controller{
    public function fetchDebug(){
        // return YoutubeRepositories::videoScrapper('oO7XZ86ePq0');

        // return CarbonInterval::create("PT28M15S")->format('%H:%M:%S');
        // return Carbon::createFromTimeStamp("PT4H28M15S")->toDateTimeString();

        // $now = Carbon::now()->timezone("Asia/Jakarta")->toDateTimeString();
        
        // return $published = Carbon::parse("2024-06-14T13:00:00Z")->timezone("Asia/Jakarta")->diffForHumans();//->toDateTimeString();

        // $count = Carbon::parse($now)->diffInDays($published);

        // if(($count <= 3) && ($count >= -3)){
        //     return "Bisa di cek";
        // }

        // return BaseHelper::diffInDays(7, "2024-06-14T13:00:57+00:00");

        // return YoutubeRepositories::fetchActivityViaCrawler("UCurEA8YoqFwimJcAuSHU0MQ", 1);
        // return YoutubeRepositories::fetchProfile("UCDe3iqZiVXIXQbgIR36mF6w", 1);

        // Via API
        // return YoutubeRepositories::fetchVideoStatus("H0Gz1LOUp2s");

        // return YoutubeRepositories::fetchArchiveViaAPI("UCNkj7b0jncXROUeIeROZ4Og", 1);
        // return YoutubeRepositories::fetchArchiveViaFeed("UCNkj7b0jncXROUeIeROZ4Og", 1);

        return YoutubeRepositories::userFeedInit("2");
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
                    // // Init acrhive (via Youtube API)
                    // YoutubeRepositories::fetchArchiveViaAPI($chunk->identifier, $chunk->users_id);
                    
                    // // Normal archive (via Scraper)
                    // YoutubeRepositories::fetchArchiveViaFeed($chunk->identifier, $chunk->users_id);

                    // Init archive metadata
                    YoutubeRepositories::userFeedInit();

                    // // Fetch channel activity
                    // YoutubeRepositories::fetchActivityViaCrawler($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){
                    return $th;
                }
            }
        });
    }

    public function fetchUserFeedMinutely(){
        $feed = UserFeed::where([
            ['base_link_id', '=', 2],
        ])->select('identifier')->chunk(50, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Archive Status (like delete the archive from DB if it isn't on YouTube anymore)
                    // YoutubeRepositories::fetchArchiveStatus($chunk->identifier);
                }
                catch(\Throwable $th){}
            }
        });

        $feedPool = YoutubeRepositories::poolUserFeedInit();
    }
}
