<?php

use Illuminate\Support\Facades\Schedule;

// YouTube Block
Schedule::call('App\Http\Controllers\Cron\YoutubeCron@fetchArchive')->everyMinute();