<?php

use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;



Route::controller(GoogleController::class)->group(function() {
    Route::get('/auth/google/redirect', 'redirect');
    Route::get('/auth/google/callback', 'callback');
});
