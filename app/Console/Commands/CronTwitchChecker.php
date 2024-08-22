<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\TwitchCron;

use Illuminate\Console\Command;

class CronTwitchChecker extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-twitch-checker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handling Twitch cron for checking, organize and processing streaming.';

    /**
     * Execute the console command.
     */
    public function handle(TwitchCron $cron){
        $cron->checker();
    }
}
