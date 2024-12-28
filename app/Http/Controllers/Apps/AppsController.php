<?php

namespace App\Http\Controllers\Apps;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AppsController extends Controller{
    // Apps Index
    public function index(){
        return view('pages/apps/index');
    }

    // Apps Master Data Index
    public function master(){
        return view('pages/apps/master');
    }

    // Apps Manager Index
    public function manager(){
        return view('pages/apps/manager');
    }
}
