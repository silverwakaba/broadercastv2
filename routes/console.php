<?php

use Illuminate\Support\Facades\Schedule;

// everyMinute();
// onOneServer()

/**
 * Base / General Block
**/

// Schedule::command('app:cron-proxy-host-checker')->everyFiveMinutes()->timezone('Asia/Jakarta')->runInBackground(); // everyFiveMinutes
Schedule::command('app:cron-user-request-cleanup')->hourly()->timezone('Asia/Jakarta')->withoutOverlapping()->runInBackground(); // hourly

/**
 * YouTube Block
**/

Schedule::command('app:cron-youtube-initial')->everyTenMinutes()->timezone('Asia/Jakarta')->withoutOverlapping()->runInBackground(); // everyTenMinutes
Schedule::command('app:cron-youtube-metadata')->everyFiveMinutes()->timezone('Asia/Jakarta')->withoutOverlapping()->runInBackground(); // everyFiveMinutes
Schedule::command('app:cron-youtube-checker')->everyThreeMinutes()->timezone('Asia/Jakarta')->withoutOverlapping()->runInBackground(); // everyThreeMinutes
Schedule::command('app:cron-youtube-fetch-profile')->daily()->timezone('Asia/Jakarta')->withoutOverlapping()->runInBackground(); // daily

/**
 * Twitch Block
**/

Schedule::command('app:cron-twitch-initial')->everyTenMinutes()->timezone('Asia/Jakarta')->withoutOverlapping()->runInBackground(); // everyTenMinutes
Schedule::command('app:cron-twitch-checker')->everyThreeMinutes()->timezone('Asia/Jakarta')->withoutOverlapping()->runInBackground(); // everyThreeMinutes
Schedule::command('app:cron-twitch-fetch-profile')->daily()->timezone('Asia/Jakarta')->withoutOverlapping()->runInBackground(); // daily
Schedule::command('app:cron-twitch-fetch-misc')->everySixHours($minutes = 0)->timezone('Asia/Jakarta')->withoutOverlapping()->runInBackground(); // everySixHours, because once daily isn't enough
