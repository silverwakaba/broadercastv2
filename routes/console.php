<?php

use Illuminate\Support\Facades\Schedule;

/**
 * YouTube Block
*/
Schedule::command('app:cron-youtube-initial')->everyMinute()->runInBackground();
Schedule::command('app:cron-youtube-checker')->everyMinute()->runInBackground();