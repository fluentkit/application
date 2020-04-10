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

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function loadSettings()
    {
        $this->settings()
            ->get(['setting', 'value'])
            ->each(function (Setting $setting) {
                if (is_array($setting->value)) {
                    $default = config()->get($setting->setting, []);
                    config()->set($setting->setting, $this->array_merge_recursive_distinct($default, $setting->value));
                    return;
                }
                config()->set($setting->setting, $setting->value);
            });
    }

    private function array_merge_recursive_distinct(array $array1, array $array2)
    {
        $merged = $array1;

        foreach ($array2 as $key => $value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged [$key])) {
                $merged[$key] = array_merge_recursive_distinct($merged [$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }

    public function loadServices()
    {
        $services = $this->services()
            ->get(['name', 'credentials'])
            ->keyBy('name')
            ->map(fn(Service $service) => $service->credentials)
            ->toArray();

        if (empty($services)) return;

        $default = config()->get('services', []);
        config()->set('services', $this->array_merge_recursive_distinct($default, $services));
    }

    public static function setCurrent(App $app)
    {
        app()->instance(App::class, $app);

        $app->loadSettings();
        $app->loadServices();
    }

    public static function current(): ?self
    {
        return app(App::class);
    }
}
