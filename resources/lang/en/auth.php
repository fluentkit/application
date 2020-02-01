<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'verify' => 'You must verify your email address before logging in.',
    'success' => 'Success! Redirecting...',

    'forgot' => [
        'success' => 'Please check your email for a reset link.',
        'throttle' => 'Too many reset attempts. Please try again in :minutes minutes.',
    ],

    'reset' => [
        'expired' => 'Your reset request has expired, please request a new validation email.',
        'success' => 'Success! Redirecting...',
    ]
];
