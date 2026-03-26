<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AboutController extends Controller
{
    public function about($id, $name){
        Log::info('Showing about page.');
        return '<a href="' . route('home', ['id' => $id, 'name' => $name]) . '">Go to home Page</a>';
    }
}
