<?php

namespace FluentKit;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use LinkedToApp;

    protected $fillable = [
        'name',
        'credentials',
        'app_id',
    ];

    protected $casts = [
        'credentials' => 'array',
    ];
}
