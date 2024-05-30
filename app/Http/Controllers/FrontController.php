<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller{
    // Index
    public function index(){
        return view('pages/index');
    }
}
