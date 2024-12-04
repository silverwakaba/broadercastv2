<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;

use App\Models\UserLinkTracker;

use App\Repositories\Service\YoutubeRepositories;
use App\Repositories\Service\YoutubeAPIRepositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class YoutubeCron extends Controller{
    // Debug
    public function fetchDebug(){
        // return YoutubeAPIRepositories::scrapeLLChannels('@lisahanabusa');
        // self::init();
        // self::metadata();
        // self::checker();
    }

    // Archive Initialization
    public function init(){
        UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['initialized', '=', false],
        ])->select('id', 'identifier', 'users_id')->chunkById(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Fetch acrhive via Youtube API
                    YoutubeRepositories::fetchArchiveViaAPI($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });
    }

    // Archive Metadata
    public function metadata(){
        // Fetch acrhive via Youtube XML Feed
        YoutubeRepositories::fetchArchiveViaFeed();

        // Update archive metadata after fetching { API and XML Feed } from Youtube - Ok
        YoutubeRepositories::userFeedInit();
    }

    // Feed Checker
    public function checker(){
        YoutubeRepositories::fetchStreamStatusViaAPI();
    }

    // Profiler
    public function profiler(){
        return YoutubeRepositories::fetchProfile();
    }
}
