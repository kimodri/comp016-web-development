<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UtilController extends Controller
{
    public function product($num1, $num2){
        Log::info('Multiplying: ' . $num1 . ' * ' . $num2);
        return $num1 * $num2;
    }

    public function quotient($num1, $num2){
        Log::info('Dividing: ' . $num1 . '/' . $num2);
        // $result = 0;
        // try{
        //     $result = $num1 / $num2;
        // }catch(Exception $e){
        //     throw new Exception();
        // }
        // return $result;
        return $num1 /  $num2;


    }
}
