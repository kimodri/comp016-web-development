<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilController extends Controller
{
    public function product($num1, $num2){
        return $num1 * $num2;
    }

    private function quotient($num1, $num2){
        return $num1 / $num2;
    }
}
