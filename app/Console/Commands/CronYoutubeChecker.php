<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\YoutubeCron;

use Illuminate\Console\Command;

class CronYoutubeChecker extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-youtube-checker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handling YouTube cron for checking, organize and processing existing archive';

    /**
     * Execute the console command.
     */
    public function handle(YoutubeCron $cron){
        $cron->checker();
    }
}
