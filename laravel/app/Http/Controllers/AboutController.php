<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about($id, $name){
        return '<a href="' . route('home', ['id' => $id, 'name' => $name]) . '">Go to home Page</a>';
    }
}
