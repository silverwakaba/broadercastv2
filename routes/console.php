<?php

use Illuminate\Support\Facades\Schedule;

/**
 * YouTube Block
 * Fetch profile > archive > activity
*/
Schedule::call('App\Http\Controllers\Cron\YoutubeCron@fetchProfile')->everyMinute(); // Sehari sekali
Schedule::call('App\Http\Controllers\Cron\YoutubeCron@fetchArchive')->everyMinute(); // Tiap menit
Schedule::call('App\Http\Controllers\Cron\YoutubeCron@fetchActivity')->everyMinute(); // Tiap menit