<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;

use App\Repositories\Service\TwitchRepositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TwitchCron extends Controller{
    // Debug
    public function fetchDebug(){
        // return TwitchRepositories::fetchProfile('dttodot');
        // return TwitchRepositories::fetchSubscriber('715990491');
        
        return TwitchRepositories::fetchVideoViaAPI('715990491');
    }
}
