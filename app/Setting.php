<?php

namespace FluentKit;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use LinkedToApp;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'setting',
        'value',
        'app_id',
    ];

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = json_encode($value, JSON_THROW_ON_ERROR);
    }

    public function getValueAttribute()
    {
        if (!array_key_exists('value', $this->attributes)) return null;

        return json_decode($this->attributes['value'], true, 512, JSON_THROW_ON_ERROR);
    }
}
