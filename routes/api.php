<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'store']);

Route::controller(LoginController::class)->group(function() {
    Route::post('/login', 'logIn')->name('login');
    Route::post('/logout', 'logOut')->name('logout')->middleware('auth:sanctum');
});
