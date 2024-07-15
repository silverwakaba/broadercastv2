<?php

use Illuminate\Support\Facades\Schedule;

/**
 * YouTube Block
**/
Schedule::command('app:cron-youtube-initial')->everyFiveMinutes()->timezone('Asia/Jakarta')->runInBackground(); // everyFiveMinutes
Schedule::command('app:cron-youtube-checker')->everyTwoMinutes()->timezone('Asia/Jakarta')->runInBackground(); // everyTwoMinutes
Schedule::command('app:cron-youtube-fetch-profile')->daily()->timezone('Asia/Jakarta')->runInBackground();

// Schedule::call('App\Repositories\Service\YoutubeCron@init')->everyMinute();