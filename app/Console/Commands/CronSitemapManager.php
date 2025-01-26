<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\BaseCron;

use Illuminate\Console\Command;

class CronSitemapManager extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-sitemap-manager';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage sitemap. Simple.';

    /**
     * Execute the console command.
     */
    public function handle(BaseCron $cron){
        $cron->sitemap();
    }
}
