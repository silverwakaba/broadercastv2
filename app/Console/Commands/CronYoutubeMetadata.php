<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\YoutubeCron;

use Illuminate\Console\Command;

class CronYoutubeMetadata extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-youtube-metadata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handling YouTube cron for checking, organize and processing metadata for existing archive.';

    /**
     * Execute the console command.
     */
    public function handle(YoutubeCron $cron){
        $cron->metadata();
    }
}
