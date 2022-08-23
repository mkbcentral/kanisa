<?php

use App\Http\Controllers\User\Usercontroller;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(Usercontroller::class)->group(function(){
    Route::post('/login','login');
    Route::post('/register','register');
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user/{id}',[Usercontroller::class,'show']);
    Route::post('/user-update/{id}',[Usercontroller::class,'update']);
});
