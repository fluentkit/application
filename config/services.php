<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => null,
        'secret' => null,
        'endpoint' => 'api.mailgun.net',
    ],

    'postmark' => [
        'token' => null,
    ],

    'ses' => [
        'key' => null,
        'secret' => null,
        'region' => 'us-east-1',
    ],

];
