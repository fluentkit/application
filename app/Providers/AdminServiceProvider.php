<?php

namespace FluentKit\Providers;

use FluentKit\Admin\Area;
use FluentKit\Admin\Dashboard\Dashboards;
use FluentKit\Admin\Settings\Settings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Area::class, fn () => new Area());
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Area $admin)
    {
        $admin->registerSection(new Dashboards());
        $admin->registerSection(new Settings());

        if (!$this->app->routesAreCached()) {
            Route::prefix('admin')
                ->middleware('web')
                ->group(base_path('routes/admin.php'));
        }
    }
}
