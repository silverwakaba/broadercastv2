<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;

use App\Models\UserLinkTracker;

use App\Repositories\Service\TwitchRepositories;
use App\Repositories\Service\TwitchAPIRepositories;

use Illuminate\Support\Collection;

class TwitchCron extends Controller{
    // Debug
    public function fetchDebug(){
        // 
    }

    // MISC
    public function misc(){
        // Update Bearer Token
        TwitchRepositories::updateBearerToken();
    }

    // Channel Initialization
    public function init(){
        TwitchRepositories::updateSubscriber(false);
    }

    // Channel Activity Checker
    public function checker(){
        TwitchRepositories::checkChannelActivity();
        
        TwitchRepositories::updateChannelActivity();
    }

    // Profiler
    public function profiler(){
        TwitchRepositories::updateProfile();

        TwitchRepositories::updateSubscriber(true);
    }
}
