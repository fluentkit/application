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

Route::view('/login', 'auth.layouts.default');
Route::view('/login/forgot-password', 'auth.layouts.default');

Route::get('/{path?}', function () {
    return view('admin.layouts.default', ['admin' => app(\FluentKit\Admin\Area::class)->toArray()]);
})->where('path', '(.*?)');

Route::post('/{section}/{screen}/{action}', [\FluentKit\Admin\Http\Controllers\Actions\ScreenActionsController::class, 'postAction']);
