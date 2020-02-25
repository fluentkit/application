<?php

namespace FluentKit\Providers;

use FluentKit\App;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(App::class, function () {
            return App::with('domains')->master()->first();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('linkToApp', function () {
            $this->bigInteger('app_id')->unsigned()->nullable();
            $this->foreign('app_id')
                ->references('id')
                ->on('apps')
                ->onDelete('cascade');
        });
    }
}
