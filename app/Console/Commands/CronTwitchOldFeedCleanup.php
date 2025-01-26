<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\TwitchCron;

use Illuminate\Console\Command;

class CronTwitchOldFeedCleanup extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-twitch-old-feed-cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handling Twitch cron for cleaning up older feed. Check the function for more detail about set days.';

    /**
     * Execute the console command.
     */
    public function handle(TwitchCron $cron){
        $cron->cleanUp();
    }
}
