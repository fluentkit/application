<?php

namespace FluentKit;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'master'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'master' => 'bool',
    ];

    public function scopeMaster(Builder $query)
    {
        return $query->where('master', true);
    }

    public function domains()
    {
        return $this->hasMany(AppDomain::class);
    }

    public static function setCurrent(App $app)
    {
        app()->instance(App::class, $app);
    }

    public static function current(): ?self
    {
        return app(App::class);
    }
}
