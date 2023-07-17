<?php

use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'store']);

Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'logIn')->name('login');
    Route::post('/logout', 'logOut')->name('logout')->middleware('auth:sanctum');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'sendResetLink')->name('password.email');
    Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});

Route::controller(EmailVerificationController::class)->group(function () {
    Route::get('/email/verify', 'notice')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'verify')->middleware('verify')->name('verification.verify');
    Route::post('/profile/email/change', 'changeEmail')->name('profile.email.change');
});

Route::controller(GoogleController::class)->group(function () {
    Route::get('/auth/google/redirect', 'redirect');
    Route::post('/auth/google/login', 'login');
});

Route::controller(UserController::class)->group(function () {
    Route::put('/users/name', 'updateName');
    Route::put('/users/password', 'changePassword');
    Route::post('/users/avatar', 'uploadAvatar');
});

Route::controller(MovieController::class)->group(function () {
    Route::get('user/movies', 'index');
    Route::get('user/movies/{id}', 'show');
    Route::post('user/movies', 'store');
    Route::delete('user/movies/{id}', 'destroy');
    Route::put('user/movies/{id}', 'update');
});
