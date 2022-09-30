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

        $num = $request->num;
        $m = $num; // to not alter the input value of the function
        
        $is_neg = false;

        if($num < 0){
            $is_neg = true;
            $m = -$m;  
        };
        
        $nb_digits = countDigits($m);
        
        $array = [];

        for ($i = 0; $i < $nb_digits; $i++){

            $o = floor($m / 10 ** ($nb_digits - $i - 1)) * 10 **($nb_digits - $i - 1);
            $m = $m - $o;

            if ($is_neg)
                array_push($array, -$o);
            else 
                array_push($array, $o);

        }

        return response()->json([
            "status" => "Success",
            "message" => $array
        ]);

    }
}
