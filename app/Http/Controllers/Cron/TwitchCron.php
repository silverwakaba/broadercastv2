<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;

use App\Models\UserLinkTracker;

use App\Repositories\Service\TwitchRepositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TwitchCron extends Controller{
    // Debug
    public function fetchDebug(){
        // Profiler
        // TwitchRepositories::updateProfile(883696964, 1);
        // TwitchRepositories::updateSubscriber($chunk->identifier, $chunk->users_id);
        
        // return $this->init();
        // return $this->checker();
        return $this->profiler();
    }

    // Channel Initialization
    public function init(){
        UserLinkTracker::where([
            ['base_link_id', '=', 1],
            ['initialized', '=', false],
        ])->select('identifier', 'users_id')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Update Subscriber Count
                    TwitchRepositories::updateSubscriber($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });
    }

    // Channel Activity Checker
    public function checker(){
        UserLinkTracker::where([
            ['base_link_id', '=', 1],
            ['initialized', '=', true],
        ])->select('identifier', 'handler', 'users_id')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Update Activity
                    TwitchRepositories::fetchChannelActivity($chunk->handler, $chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });
    }

    // Profiler
    public function profiler(){
        UserLinkTracker::where([
            ['base_link_id', '=', 1],
            ['initialized', '=', true],
        ])->select('identifier', 'users_id')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    // Update Profile
                    $id = (int) $chunk->identifier;
                    TwitchRepositories::updateProfile($id, $chunk->users_id);

                    // Update Subscriber
                    TwitchRepositories::updateSubscriber($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });
    }
}
