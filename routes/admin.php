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

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.layouts.default')
        ->name('login');

    Route::view('/forgot-password', 'auth.layouts.default')
        ->name('forgot-password');

    Route::view('/reset-password/{token}', 'auth.layouts.default')
        ->name('password.reset');
});

Route::middleware('admin', 'can:admin.view')->group(function () {

    Route::get('/{section}/{screen}/fields', [\FluentKit\Admin\Http\Controllers\Screen\ScreenDataController::class, 'getFields']);
    Route::get('/{section}/{screen}/attributes', [\FluentKit\Admin\Http\Controllers\Screen\ScreenDataController::class, 'getAttributes']);
    Route::get('/{section}/{screen}/actions', [\FluentKit\Admin\Http\Controllers\Screen\ScreenDataController::class, 'getActions']);
    Route::get('/{section}/{screen}/template', [\FluentKit\Admin\Http\Controllers\Screen\ScreenDataController::class, 'getTemplate']);

    Route::post('/{section}/{screen}/{action}', [\FluentKit\Admin\Http\Controllers\Screen\ScreenActionsController::class, 'postAction']);

    Route::get('/{path?}', [\FluentKit\Admin\Http\Controllers\HomeController::class, 'index'])
        ->where('path', '(.*?)')
        ->name('home');
});
