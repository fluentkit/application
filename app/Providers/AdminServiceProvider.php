<?php

namespace FluentKit\Providers;

use FluentKit\Admin\Apps\AppDomains;
use FluentKit\Admin\Apps\Apps;
use FluentKit\Admin\Area;
use FluentKit\Admin\Dashboard\Dashboards;
use FluentKit\Admin\Roles\Permissions;
use FluentKit\Admin\Settings\Settings;
use FluentKit\Admin\UI\UserLink;
use FluentKit\Admin\Roles\Roles;
use FluentKit\Admin\Users\Users;
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
        $admin->serving(function (Area $admin) {
            $admin->registerSection(new Dashboards());
            $admin->registerSection(new Apps());
            $admin->registerSection(new AppDomains());
            $admin->registerSection(new Users());
            $admin->registerSection(new Roles());
            $admin->registerSection(new Permissions());
            $admin->registerSection(new Settings());

            $admin->registerUserLink(
                (new UserLink('profile', 'My Profile', 'users.edit'))
                    ->setParams(['id' => request()->user()->id])
            );
            $admin->registerUserLink(UserLink::divider('logout-divider'));
            $admin->registerUserLink(new UserLink('logout', 'Logout', 'logout'));
        });

        if (!$this->app->routesAreCached()) {
            Route::prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        }
    }
}
