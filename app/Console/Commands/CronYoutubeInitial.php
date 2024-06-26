<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\YoutubeCron;

use Illuminate\Console\Command;

class CronYoutubeInitial extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-youtube-initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handling YouTube cron to fetch initial archive';

    /**
     * Execute the console command.
     */
    public function handle(YoutubeCron $cron){
        $cron->init();
    }
}
