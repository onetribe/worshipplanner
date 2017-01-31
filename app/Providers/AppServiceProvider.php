<?php

namespace App\Providers;

use App\Services\ActiveTeam;
use App\Services\DateHelper;
use App\Services\DateHelperInterface;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ActiveTeam::class, function ($app) {
            return new ActiveTeam($this->app->make(AuthManager::class));
        });

        $this->app->singleton(DateHelperInterface::class, function ($app) {
            return new DateHelper($this->app->make(AuthManager::class));
        });
        $this->app->alias(DateHelperInterface::class, "date_helper");
    }
}
