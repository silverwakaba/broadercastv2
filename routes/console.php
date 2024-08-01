<?php

use Illuminate\Support\Facades\Schedule;

// everyMinute();

/**
 * YouTube Block
**/
Schedule::command('app:cron-youtube-initial')->everyTenMinutes()->timezone('Asia/Jakarta')->runInBackground(); // everyTenMinutes
Schedule::command('app:cron-youtube-checker')->everyFiveMinutes()->timezone('Asia/Jakarta')->runInBackground(); // everyFiveMinutes
Schedule::command('app:cron-youtube-fetch-profile')->daily()->timezone('Asia/Jakarta')->runInBackground();
