<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;

use App\Models\BaseAPI;
use App\Models\UserLinkTracker;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Repositories\Service\YoutubeRepositories;

class YoutubeCron extends Controller{
    public function fetchProfile(){
        UserLinkTracker::where([
            ['base_link_id', '=', 2],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    YoutubeRepositories::fetchProfile($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });
    }

    public function fetchArchive(){
        UserLinkTracker::where([
            ['base_link_id', '=', 2],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    YoutubeRepositories::fetchArchive($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });
    }

    public function fetchActivity(){
        UserLinkTracker::where([
            ['base_link_id', '=', 2],
        ])->select('users_id', 'identifier')->chunk(100, function(Collection $chunks){
            foreach($chunks as $chunk){
                try{
                    YoutubeRepositories::fetchActivity($chunk->identifier, $chunk->users_id);
                }
                catch(\Throwable $th){}
            }
        });
    }
}
