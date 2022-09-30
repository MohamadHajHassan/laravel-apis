<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    function sayHi(){
        $message = "Hi";

        return response()->json([
            "status" => "Success",
            "message" => $message
        ]);
    }
}
