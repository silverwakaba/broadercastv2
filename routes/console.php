<?php

use Illuminate\Support\Facades\Schedule;

// everyMinute();

/**
 * YouTube Block
**/
Schedule::command('app:cron-youtube-initial')->everyMinute()->timezone('Asia/Jakarta');//->runInBackground(); // everyFiveMinutes
// Schedule::command('app:cron-youtube-checker')->everyMinute()->timezone('Asia/Jakarta')->runInBackground(); // everyTwoMinutes
// Schedule::command('app:cron-youtube-fetch-profile')->daily()->timezone('Asia/Jakarta')->runInBackground();