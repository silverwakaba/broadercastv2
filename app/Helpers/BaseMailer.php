<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class BaseMailer{
    public static function recovery(){
        return "Ready Steady";
    }
}