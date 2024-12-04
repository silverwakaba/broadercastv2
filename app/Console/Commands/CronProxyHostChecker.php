<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\BaseCron;

use Illuminate\Console\Command;

class CronProxyHostChecker extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-proxy-host-checker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handling proxy host uptime check';

    /**
     * Execute the console command.
     */
    public function handle(BaseCron $cron){
        $cron->misc();
    }
}
