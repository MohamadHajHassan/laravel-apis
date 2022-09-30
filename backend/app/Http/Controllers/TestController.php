<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    
    function placeValue(Request $request){

        function countDigits($n){

            $count = 0;
            $m = $n; //to not alter the input value of the function
    
            while($m != 0){
                $m = floor($m/10);
                $count++;
            }

            return $count;

        }

    }
}
