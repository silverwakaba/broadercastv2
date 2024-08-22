<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\TwitchCron;

use Illuminate\Console\Command;

class CronTwitchFetchProfile extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-twitch-fetch-profile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handling Twitch cron for checking, organize and processing channel metadata.';

    /**
     * Execute the console command.
     */
    public function handle(){
        $cron->profiler();
    }
}
