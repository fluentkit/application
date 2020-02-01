<?php

declare(strict_types=1);

namespace FluentKit\Http\Controllers\Auth;

use FluentKit\Http\Controllers\Controller;
use FluentKit\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $authenticated = Auth::guard()
            ->attempt(
                $request->only('email', 'password'),
                $request->filled('remember')
            );

        if (!$authenticated) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        if ($authenticated && !$request->user()->hasVerifiedEmail()) {
            Auth::guard()->logout();
            throw ValidationException::withMessages([
                'email' => [trans('auth.verify')],
            ]);
        }

        $request->session()->regenerate();

        $redirect = $request->session()->pull('url.intended', route('home'));

        return [
            'message' => trans('auth.success'),
            'data' => [
                'redirect' => $redirect
            ]
        ];
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if (!$request->wantsJson()) {
            return redirect()->route('home');
        }

        return [
            'message' => 'Success! Redirecting...',
            'data' => [
                'redirect' => route('home')
            ]
        ];
    }
}
