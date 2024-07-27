<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('employees', EmployeeController::class);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
