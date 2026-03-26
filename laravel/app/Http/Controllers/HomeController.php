<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function home($id, $name){
        Log::info('Showing home page.');
        return '<marquee><h1>Hello World! Your id is: ' . $id . ' and your name is: ' . $name . '</h1></marquee>';
    }
}
