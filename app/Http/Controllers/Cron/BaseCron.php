<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;

use App\Repositories\Service\BaseRepositories;

use Illuminate\Http\Request;

class BaseCron extends Controller{
    // Fetch debug
    public function fetchDebug(){
        // use this blank function on router if there is no cron need to be tested, or use self::functionName() below
    }

    // MISC
    public function misc(){
        BaseRepositories::hostCheck();
    }

    // Clean up user request
    public function userRequestCleanup(){
        return BaseRepositories::userRequestCleanup();
    }
}
