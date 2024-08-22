<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\TwitchCron;

use Illuminate\Console\Command;

class CronTwitchInitial extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-twitch-initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handling Twitch cron to fetch initial channel information';

    /**
     * Execute the console command.
     */
    public function handle(TwitchCron $cron){
        $cron->init();
    }
}
