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
        // Validate Token
        // return TwitchRepositories::apiCall('validate-token', [
        //     'client_secret' => 'p9t9i4fez9eoicclqif8o04joeggog',
        //     'bearer'        => '6iz7bik93aonvo7oao861j3zpfogg6',
        // ]);
        
        // Create Token
        // return TwitchRepositories::apiCall('create-token', [
        //     'client_id'     => 'j1sg2t54dwptembv45th3uuzqkgo6e',
        //     'client_secret' => 'p9t9i4fez9eoicclqif8o04joeggog',
        // ]);
        
        // Fetch Profile
        // return TwitchRepositories::apiCall('profile', [
        //     'login' => 'dota2ti',
        // ]);

        // Fetch Channel
        // return TwitchRepositories::apiCall('channel', [
        //     'id' => 715990491,
        // ]);

        // Fetch Subscriber
        // return TwitchRepositories::apiCall('subscriber', [
        //     'id' => 715990491,
        // ]);

        // Fetch Stream
        // return TwitchRepositories::apiCall('stream', [
        //     'id' => 715990491,
        // ]);

        // Fetch Video and Archive
        // return TwitchRepositories::apiCall('video', [
        //     'user_id'   => 715990491,
        //     // 'video_id'  => $video,
        //     'stream_id' => 41564183287,
        // ]);

        // ***** \\

        // return TwitchRepositories::fetchProfile(715990491);
        // return TwitchRepositories::fetchProfile('dttodot');

        // return TwitchRepositories::fetchSubscriber(715990491);
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
