<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;

use App\Models\BaseAPI;
use App\Models\UserFeed;
use App\Models\UserLinkTracker;
use App\Repositories\Service\YoutubeRepositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class YoutubeCron extends Controller{
    public function fetchDebug(){
        // return YoutubeRepositories::apiCall('playlist', 'UULlJpxXt6L5d-XQ0cDdIyDQ');
    }

    public function init(){
        // Archive initialization
        UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['initialized', '=', false],
        ])->select('identifier', 'users_id')->chunk(100, function(Collection $chunks){
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
        ])->select('identifier', 'users_id')->chunk(100, function(Collection $chunks){
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
        ])->whereIn('base_status_id', ['7', '8'])->whereNotIn('base_status_id', ['5'])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Fetch stream activity
                    YoutubeRepositories::fetchVideoViaScraper($chunk->identifier);

                    // Update live streaming that have missing metadata
                    YoutubeRepositories::userFeedLiveMissingMetadata();
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

    public function profiler(){
        // Profile metadata
        UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['initialized', '=', true],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Update profile metadata daily
                    YoutubeRepositories::fetchProfile($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });
    }
}
