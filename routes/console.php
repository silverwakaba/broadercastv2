<?php

use Illuminate\Support\Facades\Schedule;

// everyMinute();

/**
 * YouTube Block
**/

Schedule::command('app:cron-youtube-initial')->everyTenMinutes()->onOneServer()->timezone('Asia/Jakarta')->runInBackground(); // everyTenMinutes
Schedule::command('app:cron-youtube-metadata')->everyFiveMinutes()->onOneServer()->timezone('Asia/Jakarta')->runInBackground(); // everyTenMinutes
Schedule::command('app:cron-youtube-checker')->everyThreeMinutes()->onOneServer()->timezone('Asia/Jakarta')->runInBackground(); // everyFiveMinutes
Schedule::command('app:cron-youtube-fetch-profile')->daily()->onOneServer()->timezone('Asia/Jakarta')->runInBackground();

/**
 * Twitch Block
**/

// Not yet, you fucking dipshit
