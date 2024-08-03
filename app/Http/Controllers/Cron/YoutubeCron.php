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
    // Debug
    public function fetchDebug(){
        // Commented

        // // Overdue scheduled stream
        // return UserFeed::where([
        //     ['base_link_id', '=', 2],
        //     ['schedule', '!=', null],
        //     ['actual_start', '=', null],
        //     ['actual_end', '=', null],
        //     ['duration', '=', null],
        // ])->whereDate('schedule', '<=', Carbon::now()->timezone(config('app.timezone'))->toDateTimeString())->whereIn('base_status_id', ['7'])->whereNotIn('base_status_id', ['5'])->select('identifier')->take(50)->get();
    }

    // Archive initialization
    public function init(){
        // Init
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

        // Metadata
        UserLinkTracker::where([
            ['base_link_id', '=', 2],
            ['initialized', '=', true],
        ])->select('identifier', 'users_id')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Fetch acrhive via Youtube Feed
                    YoutubeRepositories::fetchArchiveViaFeed($chunk->identifier, $chunk->users_id);

                    // Update archive metadata after fetched from Youtube API
                    YoutubeRepositories::userFeedInit();

                    // Update live streaming that overdue
                    YoutubeRepositories::userFeedLiveOverdue();
                }
                catch(\Throwable $th){}
            }
        });
    }

    // Feed Checker
    public function checker(){
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
    }

    // Profiler
    public function profiler(){
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
