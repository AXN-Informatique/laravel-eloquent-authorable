<?php

namespace Axn\EloquentAuthorable;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Override;

class ServiceProvider extends BaseServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/eloquent-authorable.php', 'eloquent-authorable');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->configurePublishing();
            $this->registerMigrationsMacros();
        }
    }

    private function configurePublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/eloquent-authorable.php' => config_path('eloquent-authorable.php'),
        ], 'config');
    }

    private function registerMigrationsMacros(): void
    {
        Blueprint::macro('addAuthorableColumns', function ($useBigInteger = true, $usersTableName = null): void {
            MigrationsMacros::addColumns($this, $useBigInteger, $usersTableName);
        });

        Blueprint::macro('dropAuthorableColumns', function (): void {
            MigrationsMacros::dropColumns($this);
        });
    }
}
