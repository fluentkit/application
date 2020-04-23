<?php

namespace FluentKit;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    protected $appends = [
        'url'
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

    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->path . $this->filename);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public static function upload(File $file, string $path = '', string $disk = 'public', $name = null): self
    {
        if (!$name) {
            $name = $file->getFilename();
        }

        $diskName = $disk;
        $disk = Storage::disk($disk);
        $app = App::current();
        $path = $app->id . '/' . trim($path, '/');
        $fileName = $file->getFilename();
        $increment = 0;

        while ($disk->exists($path . $fileName)) {
            $increment++;
            $fileName = basename($file->getFilename(), '.' . $file->getExtension()) . '-' . $increment . '.' . $file->getExtension();
        }

        $fullPath = $disk->putFileAs($path, $file, $fileName);

        return static::create([
            'app_id' => $app->id,
            'user_id' => Auth::user()->id,
            'disk' => $diskName,
            'name' => $name,
            'filename' => $fileName,
            'path' => trim($path),
            'extension' => $file->getExtension(),
            'mime_type' => $file->getMimeType(),
            'metadata' => [
                'size' => $file->getSize()
            ]
        ]);
    }
}
