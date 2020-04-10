<?php

namespace FluentKit;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use LinkedToApp;

    protected $fillable = [
        'disk',
        'name',
        'filename',
        'path',
        'extension',
        'mime_type',
        'metadata',
        'user_id',
        'app_id',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    protected static $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

    protected static $videoExtensions = ['mp4', 'avi', 'mov', 'mpg'];

    protected static $audioExtensions = ['mp3', 'wav', 'wma', 'm4a'];

    public static function getImageExtensions()
    {
        return static::$imageExtensions;
    }

    public static function getVideoExtensions()
    {
        return static::$videoExtensions;
    }

    public static function getAudioExtensions()
    {
        return static::$audioExtensions;
    }

    public static function setImageExtensions(array $extensions = [])
    {
        static::$imageExtensions = $extensions;
    }

    public static function setVideoExtensions(array $extensions = [])
    {
        static::$videoExtensions = $extensions;
    }

    public static function setAudioExtensions(array $extensions = [])
    {
        static::$audioExtensions = $extensions;
    }

    public static function addImageExtensions(array $extensions = [])
    {
        static::$imageExtensions = array_unique(array_merge(static::$imageExtensions, $extensions));
    }

    public static function addVideoExtensions(array $extensions = [])
    {
        static::$videoExtensions = array_unique(array_merge(static::$videoExtensions, $extensions));
    }

    public static function addAudioExtensions(array $extensions = [])
    {
        static::$audioExtensions = array_unique(array_merge(static::$audioExtensions, $extensions));
    }

    public function scopeImages(Builder $query)
    {
        return $query->whereIn('extension', static::getImageExtensions());
    }

    public function scopeVideos(Builder $query)
    {
        return $query->whereIn('extension', static::getImageExtensions());
    }

    public function scopeAudio(Builder $query)
    {
        return $query->whereIn('extension', static::getImageExtensions());
    }
}
