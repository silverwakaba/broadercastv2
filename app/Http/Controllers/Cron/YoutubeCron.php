<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;

use App\Models\BaseAPI;
use App\Models\UserFeed;
use App\Models\UserLinkTracker;
use App\Repositories\Service\YoutubeRepositories;
use App\Repositories\Service\YoutubeAPIRepositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

// 
// use App\Helpers\BaseHelper;
// use Illuminate\Support\Arr;
// use Illuminate\Support\Str;
// use GuzzleHttp\Client;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;

class YoutubeCron extends Controller{
    // Debug
    public function fetchDebug(Request $request){
        // return YoutubeAPIRepositories::fetchPlaylistItems('UU-WX1CXssCtCtc2TNIRnJzg');
    }

    // Archive initialization - Ok
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
        // Fetch acrhive via Youtube XML Feed - Ok
        YoutubeRepositories::fetchArchiveViaFeed();

        // Update archive metadata after fetching { API and XML Feed } from Youtube - Ok
        YoutubeRepositories::userFeedInit();
    }

    // Feed Checker - Ok
    public function checker(){
        YoutubeRepositories::fetchStreamStatusViaAPI();
    }

    // Profiler - Ok
    public function profiler(){
        return YoutubeRepositories::fetchProfile();
    }
}
