<?php

declare(strict_types=1);

namespace FluentKit\Http\Controllers\Auth;

use FluentKit\Http\Controllers\Controller;
use FluentKit\Http\Requests\Auth\ForgotRequest;
use FluentKit\Http\Requests\Auth\ResetRequest;
use FluentKit\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

final class PasswordController extends Controller
{
    public function sendReset(ForgotRequest $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();

        if ($user->last_reset_request && $user->last_reset_request->greaterThan(now()->subMinutes(30))) {
            $retryIn = ($user->last_reset_request->timestamp + (60 * 30)) - now()->timestamp;
            throw new TooManyRequestsHttpException($retryIn, trans('auth.forgot.throttle', ['minutes' => ceil($retryIn / 60)]));
        }

        $user->reset_token = $this->getToken();
        $user->last_reset_request = now();
        $user->save();
        $user->sendPasswordResetNotification($user->reset_token);

        return [
            'message' => trans('auth.forgot.success')
        ];
    }

    public function resetPassword(ResetRequest $request)
    {
        $email = $request->email;
        $token = $request->token;
        $user = User::where('email', $email)->where('reset_token', $token)->firstOrFail();

        if (!$user->last_reset_request || $user->last_reset_request->lessThan(now()->subMinutes(30))) {
            throw ValidationException::withMessages([
                'password' => [trans('auth.reset.expired')]
            ]);
        }

        $user->password = $request->password;
        $user->last_reset_request = null;
        $user->reset_token = null;
        $user->save();

        Auth::guard()->login($user);
        $request->session()->regenerate();

        return [
            'message' => trans('auth.reset.success'),
            'data' => [
                'redirect' => route('home')
            ],
        ];
    }

    private function getToken(): string
    {
        $key = config('app.key');

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        return hash_hmac('sha256', Str::random(40), $key);
    }
}
