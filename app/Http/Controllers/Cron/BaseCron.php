<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;

use App\Repositories\Service\BaseRepositories;

use Illuminate\Http\Request;

class BaseCron extends Controller{
    public function misc(){
        BaseRepositories::hostCheck();
    }
}
