<?php

namespace FluentKit;

use Illuminate\Database\Eloquent\Model;

class AppDomain extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain',
        'app_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'domain' => 'string',
    ];

    public function app()
    {
        return $this->belongsTo(App::class);
    }
}
