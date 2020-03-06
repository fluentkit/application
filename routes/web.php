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
    //dd(\FluentKit\Setting::all()->toArray());
    //sdd(DB::table('permissions')->where('name', 'not like', 'app%')->pluck('id'));
    //dd(\FluentKit\User::first()->roles()->first()->users);
    return view('welcome', ['foo' => 'bar']);
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
            return 'login page';
        })
        ->name('login');

    Route::post('/login', [\FluentKit\Http\Controllers\Auth\LoginController::class, 'login'])
        ->middleware('throttle:10,1')
        ->name('login.post');

    Route::post('/forgot-password', [\FluentKit\Http\Controllers\Auth\PasswordController::class, 'sendReset'])
        ->middleware('throttle:10,1')
        ->name('password.forgot.post');

    Route::get('/reset-password/{token}', function (\Illuminate\Http\Request $request, $token) {
            return redirect()->route('admin.password.reset', ['token' => $token] + $request->query());
        })
        ->name('password.reset');

    Route::post('/reset-password', [\FluentKit\Http\Controllers\Auth\PasswordController::class, 'resetPassword'])
        ->middleware('throttle:10,1')
        ->name('password.reset.post');
});

Route::get('/logout', [\FluentKit\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
