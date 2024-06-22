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

        // return YoutubeRepositories::fetchArchiveViaAPI("UCuDY3ibSP2MFRgf7eo3cojg", 1);
        // return YoutubeRepositories::fetchArchiveViaFeed("UCNkj7b0jncXROUeIeROZ4Og", 1);

        // return YoutubeRepositories::fetchVideoStatus("5wb6-CQwkxk");
        return YoutubeRepositories::fetchVideoViaScraper("EnHwxzporvs", 1);

        // return YoutubeRepositories::userFeedArchived();
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
        $trackerUninitialized = UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['initialized', '=', false],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Fetch acrhive (via Youtube API)
                    YoutubeRepositories::fetchArchiveViaAPI($chunk->identifier, $chunk->users_id);

                    // Init archive metadata
                    YoutubeRepositories::userFeedInit();
                }
                catch(\Throwable $th){}
            }
        });

        $trackerInitialized = UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['initialized', '=', true],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Fetch acrhive (via Youtube Feed XML)
                    YoutubeRepositories::fetchArchiveViaFeed($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });
    }

    public function fetchUserFeedMinutely(){
        $onlineFeed = UserFeed::where([
            ['base_link_id', '=', 2],
            ['streaming_archive', '=', null],
            ['actual_end', '=', null],
            ['duration', '=', "P0D"],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Fetch stream activity
                    YoutubeRepositories::fetchVideoViaScraper($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });

        $offlineFeed = UserFeed::where([
            ['base_link_id', '=', 2],
            ['streaming', '=', false],
            ['streaming_archive', '=', true],
            ['actual_end', '=', null],
            ['duration', '=', "P0D"],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Update archive metadata after streaming goes offline
                    YoutubeRepositories::userFeedArchived();
                }
                catch(\Throwable $th){}
            }
        });
    }
}
