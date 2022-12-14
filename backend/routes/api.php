<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::post("/place_value", [TestController::class, 'placeValue']);
Route::post("/to_programer", [TestController::class, 'humanToProgramer']);
Route::post("/evaluate_prefix", [TestController::class, 'evaluatePrefix']);
Route::post("/sort_string", [TestController::class, 'sortString']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
