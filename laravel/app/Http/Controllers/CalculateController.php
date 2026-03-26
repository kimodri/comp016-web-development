<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculateController extends Controller
{

    // Make a note here regarding using static 

    public function compute($num1, $num2){
        $sum = $this->add($num1, $num2);
        $difference = $this->difference($num1, $num2);
        
        $util = new UtilController();
        $product = $util->product($num1, $num2);

        // return "<h1>Sum: " . $sum . " Difference: " . $difference . " Product: " . $product . "</h1>";
        return view('calculate', compact('sum', 'difference', 'product'));
    }   
    
    private function add($param1, $param2){
        return $param1 + $param2;
    }

    public function difference($param1, $param2){
        return $param1 - $param2;
    }
}
