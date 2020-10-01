<?php

namespace Axn\EloquentAuthorable;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/eloquent-authorable.php', 'eloquent-authorable');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->configurePublishing();
            $this->registerMigrationsMacros();
        }
    }

    private function configurePublishing()
    {
        $this->publishes([
            __DIR__.'/../config/eloquent-authorable.php' => config_path('eloquent-authorable.php'),
        ], 'config');
    }

    private function registerMigrationsMacros()
    {
        Blueprint::macro('addAuthorableColumns', function () {
            MigrationsMacros::addColumns($this);
        });

        Blueprint::macro('dropAuthorableColumns', function () {
            MigrationsMacros::dropColumns($this);
        });
    }
}
