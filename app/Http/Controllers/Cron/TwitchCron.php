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

        // return TwitchRepositories::fetchProfile('dttodot');
        // return TwitchRepositories::fetchProfile(715990491);

        // return TwitchRepositories::fetchProfile('emtsmaru');
        // return TwitchRepositories::fetchProfile(848822715);

        // return TwitchRepositories::scrapeChannel('dttodot');

        // return TwitchRepositories::scrapeChannel('dttodot');

        return TwitchRepositories::fetchVideoViaAPI(null, 715990491, 41492753431);
    }
}
