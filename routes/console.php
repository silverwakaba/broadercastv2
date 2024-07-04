<?php

use Illuminate\Support\Facades\Schedule;

/**
 * YouTube Block
**/
Schedule::command('app:cron-youtube-initial')->everyMinute()->timezone('Asia/Jakarta')->runInBackground();
Schedule::command('app:cron-youtube-checker')->everyMinute()->timezone('Asia/Jakarta')->runInBackground();
Schedule::command('app:cron-youtube-fetch-profile')->daily()->timezone('Asia/Jakarta')->runInBackground();

// Schedule::call('App\Http\Controllers\Cron\YoutubeCron@init')->everyMinute();
// Schedule::call('App\Http\Controllers\Cron\YoutubeCron@checker')->everyMinute();