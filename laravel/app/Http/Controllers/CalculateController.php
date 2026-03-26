<?php

namespace App\Http\Controllers;

use DivisionByZeroError;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class CalculateController extends Controller
{

    // Log Notes

    // Make a note here regarding using static 

    public function compute($num1, $num2){
        Log::info('================================ START COMPUTE ================================'); 
        
        // We have configurations where we trun on and off what we can see
        Log::debug('Yah Yah');

        $sum = $this->add($num1, $num2);
        Log::info('sum = ' . $sum);
        
        // dd stands for "die and dump". It is a helper function in Laravel that is used to output the contents of a variable and stop the execution of the script. 
        // It is often used for debugging purposes to quickly inspect the value of a variable at a certain point in the code. When you call dd('Stop'), it will output 'Stop' and then halt the execution of the script, allowing you to see the output without any further processing. 
        // In this case, it seems like it's being used to check if the code reaches that point before proceeding with the rest of the calculations.
        // dd('Stop');

        $difference = $this->difference($num1, $num2);
        Log::info('difference = ' . $difference);
        
        $util = new UtilController();
        try{    
            $product = $util->product($num1, $num2);
            Log::info('product = ' . $product);
        }catch(Exception $e){
            Log::error('ERROR: ' . $e->getMessage());
        }  

        try{
            $quotient = $util->quotient($num1, $num2);
            Log::info('quotient = ' . $quotient);
        }catch(Throwable $e){
            Log::error('Error: ' . $e->getMessage());
        }finally{ // Whether it succeeds or fail, this will run
            Log::info('Any Message!');
        }

        // return "<h1>Sum: " . $sum . " Difference: " . $difference . " Product: " . $product . "</h1>";
        Log::info('================================ END COMPUTE ================================');
        return view('calculate', compact('sum', 'difference', 'product'));
    }   
    
    private function add($param1, $param2){
        Log::info('Adding: ' . $param1 . ' + ' . $param2);
        return $param1 + $param2;
    }

    public function difference($param1, $param2){
        // throw new Exception("Something went wrong in the difference method.");
        Log::info('Subtracting: ' . $param1 . ' - ' . $param2);
        return $param1 - $param2;
    }
}
