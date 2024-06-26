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
// use App\Helpers\BaseHelper;
// use Carbon\Carbon;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Http;

class YoutubeCron extends Controller{
    public function fetchDebug(){
        // return YoutubeRepositories::fetchArchiveViaAPI('UC-WX1CXssCtCtc2TNIRnJzg', 1);
        // return YoutubeRepositories::userFeedInit();

        // Ngecek Bentar
        // return YoutubeRepositories::fetchVideoStatus('og7UWM65nOU');
        // return YoutubeRepositories::fetchVideoViaScraper('eGn4klwJcLs', 1);

        // return YoutubeRepositories::userFeedArchived();
    }

    public function init(){
        // Archive initialization
        UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['initialized', '=', false],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Fetch acrhive via Youtube API
                    YoutubeRepositories::fetchArchiveViaAPI($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });

        // Archive metadata
        UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['initialized', '=', true],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    YoutubeRepositories::fetchArchiveViaFeed($chunk->identifier, $chunk->users_id);

                    // Update archive metadata after fetched from Youtube API
                    YoutubeRepositories::userFeedInit();
                }
                catch(\Throwable $th){}
            }
        });
    }

    public function checker(){
        // Live Streaming
        UserFeed::where([
            ['base_link_id', '=', 2],
            ['actual_end', '=', null],
            ['duration', '=', "P0D"],
        ])->whereIn('base_status_id', ['7', '8'])->whereNotIn('base_status_id', ['5'])->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Fetch stream activity
                    YoutubeRepositories::fetchVideoViaScraper($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });

        // Offline Streaming
        UserFeed::where([
            ['base_link_id', '=', 2],
            ['base_status_id', '=', 9],
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
