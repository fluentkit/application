<?php

declare(strict_types=1);

namespace FluentKit\Http\Controllers\Auth;

use FluentKit\Http\Controllers\Controller;
use FluentKit\Http\Requests\LoginRequest;

final class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        return [
            'message' => 'Success!',
            'data' => []
        ];
    }
}
