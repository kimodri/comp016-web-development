<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact(){
        // return '<a href="' . route('about') . '">Go to About Page</a>';
        return "You are in contact page";
    }
}
