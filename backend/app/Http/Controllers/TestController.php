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


    function evaluatePrefix(Request $request){
        $string = $request->string;
        $delimiter = ' ';

        // split the string by spaces onto an array
        $arr = explode($delimiter, $string);
        
        //  helper function that takes an array(prefix notation splitted) and return 
        //  a smaller one (simplified expression of the same prefix notation splitted)
        function simplifyExpression($arr){
            $stack = [];
            $i = 0;

            while($i<sizeof($arr)){

                if($i == sizeof($arr) - 1){
                    array_push($stack, $arr[$i]);
                    break;
                }

                else if ($arr[$i] != "*" && $arr[$i] != "+" && $arr[$i] != "-" 
                    && $arr[$i + 1] != "*" && $arr[$i + 1] != "+" && $arr[$i + 1] != "-"){

                    $operator = array_pop($stack);
                    $operand1 = $arr[$i];
                    $operand2 = $arr[++$i];

                    if($operator == "*"){
                        array_push($stack, $operand1 * $operand2);
                        $arr[$i] = $operand1 * $operand2;
                    }
                    else if ($operator == "+"){
                        array_push($stack, $operand1 + $operand2);
                        $arr[$i] = $operand1 + $operand2;
                    }
                    else if ($operator == "-"){
                        array_push($stack, $operand1 - $operand2);
                        $arr[$i] = $operand1 - $operand2;
                    }
                }
                else{
                    array_push($stack, $arr[$i]);
                }
                $i++;
            }
            return $stack;
        };


        while (sizeof($arr) > 1){
            $arr = simplifyExpression($arr);
        }

        return response()->json([
            "status" => "Success",
            "evaluation" => $arr[0]
        ]);

    }


    function sortString(Request $request){
    
        $string = $request->string;
        $res = [];
        $str = $string; // to not alter the input value of the function

        $pattern_capital_letters = "/[A-Z]/";
        $pattern_small_letters = "/[a-z]/";
        $pattern_numbers = "/\d/";
        preg_match_all($pattern_capital_letters, $str, $matches_capital_letters);
        preg_match_all($pattern_small_letters, $str, $matches_small_letters);
        preg_match_all($pattern_numbers, $str, $matches_numbers);

        sort($matches_capital_letters[0]);
        sort($matches_small_letters[0]);
        sort($matches_numbers[0]);

        $i = $j = $k = 0;
        while($i <= sizeof($matches_capital_letters) && $j <= sizeof($matches_small_letters)){

            if(ord($matches_small_letters[0][$j]) -32 <= ord($matches_capital_letters[0][$i])){
                array_push($res, $matches_small_letters[0][$j]);
                $j++;
            }else{
                array_push($res, $matches_capital_letters[0][$i]);
                $i++;
            }
        }

        while($i <= sizeof($matches_capital_letters)){
            array_push($res, $matches_capital_letters[0][$i]);
            $i++;
        }

        while($j <= sizeof($matches_small_letters)){
            array_push($res, $matches_small_letters[0][$j]);
                $j++;
        }

        while($k <= sizeof($matches_numbers)){
            array_push($res, $matches_numbers[0][$k]);
            $k++;
        }

        $str_res = join("", $res);

        return response()->json([
            "status" => "Success",
            "message" => $str_res
        ]);
    }

}
