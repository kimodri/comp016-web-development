<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function contact(){
        Log::info('Showing contact page.');
        // return '<a href="' . route('about') . '">Go to About Page</a>';
        return "You are in contact page";
    }
}
