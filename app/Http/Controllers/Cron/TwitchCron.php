<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;

use App\Models\UserLinkTracker;

use App\Repositories\Service\TwitchRepositories;
use App\Repositories\Service\TwitchAPIRepositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TwitchCron extends Controller{
    // Debug
    public function fetchDebug(){
        // return TwitchAPIRepositories::createToken('7rrc3ifer1dcw4178d5iylqt7k0yzs', 'f9t4j1yitz8vy47lrsa9bfdut1cdah'); // Ok so commented
        // return TwitchAPIRepositories::validateToken('f9t4j1yitz8vy47lrsa9bfdut1cdah', 'qv4fu7ggy8xm7kcrp2tz9dk42unmk7');  // Ok so commented

        // return TwitchAPIRepositories::fetchProfile('ran_hinokuma');
        return TwitchAPIRepositories::fetchChannel('517857559');
        // return TwitchAPIRepositories::fetchSubscriber('517857559');
        // return TwitchAPIRepositories::fetchStream('517857559');
        // return TwitchAPIRepositories::fetchVideo('517857559');

        // return TwitchRepositories::fetchVideo(null, 517857559, null);
    }

    // MISC
    public function misc(){
        // Update Bearer Token
        TwitchRepositories::updateBearerToken();
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
