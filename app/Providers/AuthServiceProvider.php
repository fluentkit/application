<?php

namespace FluentKit\Providers;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'FluentKit\Model' => 'FluentKit\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::after(function (Authorizable $model, string $ability) {
            if (method_exists($model, 'hasPermissionTo')) {
                return $model->hasPermissionTo($ability) ?: null;
            }
        });
    }
}
