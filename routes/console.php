<?php

use Illuminate\Support\Facades\Schedule;

/**
 * YouTube Block
**/
Schedule::command('app:cron-youtube-initial')->everyMinute()->runInBackground();
Schedule::command('app:cron-youtube-checker')->everyMinute()->runInBackground();
Schedule::command('app:cron-youtube-fetch-profile')->hourly()->runInBackground();

// Schedule::call('App\Http\Controllers\Cron\YoutubeCron@init')->everyMinute();
// Schedule::call('App\Http\Controllers\Cron\YoutubeCron@checker')->everyMinute();