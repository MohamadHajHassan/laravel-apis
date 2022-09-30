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



    function humanToProgramer(Request $request){

        $string = $request->string;
        $str = $string; // to not alter the input value of the function
        $pattern = "/\d+/";
        $replace_array = [];

        // get all the numbers inside the string and put them in an array matches[0]
        preg_match_all($pattern, $str, $matches);

        // get the binary transformation for each value inside matches[0] and put them in the array reaplace_array
        foreach ($matches[0] as $value){
            array_push($replace_array, decbin($value));
        };

        // match every value from matches[0] and replace it with the corresponding value(the binary transformation) from replace_array
        for($i = 0; $i < sizeof($replace_array); $i++){
            $m = $matches[0][$i];
            $str = preg_replace('/'.$m.'/', $replace_array[$i], $str);
        }

        return response()->json([
            "status" => "Success",
            "message" => $str
        ]);

    }
}
