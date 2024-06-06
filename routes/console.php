<?php

use Illuminate\Support\Facades\Schedule;

/**
 * YouTube Block
 * Fetch every day: profile
 * Fetch every minute: archive > activity
*/
Schedule::call('App\Http\Controllers\Cron\YoutubeCron@fetchProfile')->daily();
Schedule::call('App\Http\Controllers\Cron\YoutubeCron@fetchUserLinkTracker')->everyMinute();

// Schedule::call('App\Http\Controllers\Cron\YoutubeCron@fetchUserFeed')->everyMinute();