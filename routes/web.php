<?php

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

Route::get('/', function () {
    return '@todo';
})->name('home');

Route::get('/login', function () {
    return 'login page';
})
    ->middleware('guest')
    ->name('login');

Route::post('/login', [\FluentKit\Http\Controllers\Auth\LoginController::class, 'login'])
    ->middleware('guest', 'throttle:3,1')
    ->name('login');

Route::get('/logout', [\FluentKit\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
