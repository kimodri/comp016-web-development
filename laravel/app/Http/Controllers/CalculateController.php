<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculateController extends Controller
{
    public function index(){
        return "<h1>Result: " . (2 + 3) . "</h1>";
    }
}
