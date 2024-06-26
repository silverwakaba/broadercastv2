<?php

namespace App\Console\Commands;

use App\Models\UserLinkTracker;
use App\Repositories\Service\YoutubeRepositories;

use Illuminate\Console\Command;

class CronYoutubeFetchArchive extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-youtube-fetch-archive';
    // protected $signature = 'cronYTfArchive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handling YouTube Cron for Fetching Archive';

    /**
     * Execute the console command.
     */
    public function handle(){
        // 
    }
}
