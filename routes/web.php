<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [\FluentKit\Http\Controllers\Auth\LoginController::class, 'loginView'])
        ->name('login');

    Route::post('/login', [\FluentKit\Http\Controllers\Auth\LoginController::class, 'login'])
        ->middleware('throttle:10,1')
        ->name('login.post');

    Route::post('/forgot-password', [\FluentKit\Http\Controllers\Auth\PasswordController::class, 'sendReset'])
        ->middleware('throttle:10,1')
        ->name('password.forgot.post');

    Route::get('/reset-password/{token}', [\FluentKit\Http\Controllers\Auth\PasswordController::class, 'redirect'])
        ->name('password.reset');

    Route::post('/reset-password', [\FluentKit\Http\Controllers\Auth\PasswordController::class, 'resetPassword'])
        ->middleware('throttle:10,1')
        ->name('password.reset.post');
});

Route::get('/logout', [\FluentKit\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
