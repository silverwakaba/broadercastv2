<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\BaseCron;

use Illuminate\Console\Command;

class CronUserRequestCleanup extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-user-request-cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up user request older than 1 hours. Check the function for more detail about set hour.';

    /**
     * Execute the console command.
     */
    public function handle(BaseCron $cron){
        $cron->userRequestCleanup();
    }
}
