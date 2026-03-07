<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home($id, $name){
        return '<marquee><h1>Hello World! Your id is: ' . $id . ' and your name is: ' . $name . '</h1></marquee>';
    }
}
