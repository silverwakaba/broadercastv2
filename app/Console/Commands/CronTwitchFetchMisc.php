<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\TwitchCron;

use Illuminate\Console\Command;

class CronTwitchFetchMisc extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-twitch-fetch-misc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handling Twitch cron for managing MISC stuff.';

    /**
     * Execute the console command.
     */
    public function handle(TwitchCron $cron){
        $cron->misc();
    }
}
