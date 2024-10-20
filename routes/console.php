<?php

use Illuminate\Support\Facades\Schedule;

// everyMinute();

/**
 * YouTube Block
**/

Schedule::command('app:cron-youtube-initial')->everyTenMinutes()->onOneServer()->timezone('Asia/Jakarta')->runInBackground(); // everyTenMinutes
Schedule::command('app:cron-youtube-metadata')->everyFiveMinutes()->onOneServer()->timezone('Asia/Jakarta')->runInBackground(); // everyFiveMinutes
Schedule::command('app:cron-youtube-checker')->everyThreeMinutes()->onOneServer()->timezone('Asia/Jakarta')->runInBackground(); // everyThreeMinutes
Schedule::command('app:cron-youtube-fetch-profile')->daily()->onOneServer()->timezone('Asia/Jakarta')->runInBackground(); // daily

/**
 * Twitch Block
**/

Schedule::command('app:cron-twitch-initial')->everyTenMinutes()->onOneServer()->timezone('Asia/Jakarta')->runInBackground(); // everyTenMinutes
Schedule::command('app:cron-twitch-checker')->everyThreeMinutes()->onOneServer()->timezone('Asia/Jakarta')->runInBackground(); // everyThreeMinutes
Schedule::command('app:cron-twitch-fetch-profile')->daily()->onOneServer()->timezone('Asia/Jakarta')->runInBackground(); // daily
Schedule::command('app:cron-twitch-fetch-misc')->daily()->onOneServer()->timezone('Asia/Jakarta')->runInBackground(); // daily
