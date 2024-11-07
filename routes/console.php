<?php

use Illuminate\Support\Facades\Schedule;

// everyMinute();
// onOneServer()

/**
 * YouTube Block
**/

Schedule::command('app:cron-youtube-initial')->everyMinute()->timezone('Asia/Jakarta');//->runInBackground(); // everyTenMinutes
Schedule::command('app:cron-youtube-metadata')->everyMinute()->timezone('Asia/Jakarta');//->runInBackground(); // everyFiveMinutes
// Schedule::command('app:cron-youtube-checker')->everyMinute()->timezone('Asia/Jakarta');//->runInBackground(); // everyThreeMinutes
// Schedule::command('app:cron-youtube-fetch-profile')->daily()->timezone('Asia/Jakarta');//->runInBackground(); // daily

/**
 * Twitch Block
**/

// Schedule::command('app:cron-twitch-initial')->everyTenMinutes()->timezone('Asia/Jakarta')->runInBackground(); // everyTenMinutes
// Schedule::command('app:cron-twitch-checker')->everyThreeMinutes()->timezone('Asia/Jakarta')->runInBackground(); // everyThreeMinutes
// Schedule::command('app:cron-twitch-fetch-profile')->daily()->timezone('Asia/Jakarta')->runInBackground(); // daily
// Schedule::command('app:cron-twitch-fetch-misc')->daily()->timezone('Asia/Jakarta')->runInBackground(); // daily
