<?php

use Illuminate\Support\Facades\Schedule;

/**
 * YouTube Block
 * Fetch every day: profile
 * Fetch every minute: archive > activity
*/
// Schedule::call('App\Http\Controllers\Cron\YoutubeCron@fetchUserLinkTrackerDaily')->daily();

Schedule::call('App\Http\Controllers\Cron\YoutubeCron@fetchUserLinkTrackerMinutely')->everyMinute();
Schedule::call('App\Http\Controllers\Cron\YoutubeCron@fetchUserFeedMinutely')->everyMinute();