<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('package', [App\Http\Controllers\apiController::class, 'package']);
Route::post('package1', [App\Http\Controllers\demoController::class, 'package']);
Route::post('packageAuth', [App\Http\Controllers\authController::class, 'package']);
Route::post('januPackage', [App\Http\Controllers\januController::class, 'package']);
