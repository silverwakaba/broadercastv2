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

    // Twitter
    public function twitter(){
        return redirect('https://x.com/waka377');
    }

    // Feedback
    public function feedback(){
        return redirect('https://forms.gle/kyv9Jtb8z62wBvyNA');
    }

    // Revision
    public function revision(){
        return redirect('https://forms.gle/FjS4wM3oqgbhC7jE6');
    }
}
