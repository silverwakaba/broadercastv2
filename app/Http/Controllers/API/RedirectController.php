<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RedirectController extends Controller{
    // Bsky
    public function bsky(){
        return redirect('https://bsky.app/profile/vtual.net');
    }

    // Ping
    public function ping(){
        return redirect('https://ping.pe/www.vtual.net');
    }

    // Status
    public function status(){
        return redirect('https://status.silverspoon.me');
    }
}
