<?php

namespace Axn\EloquentAuthorable;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The boot method.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootEvents();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Perform actions on Eloquent's creating/updating event.
     *
     * @return void
     */
    public function bootEvents()
    {
        $this->app['events']->listen('eloquent.creating*', function ($eventName, array $data) {
            foreach ($data as $model) {
                if ($model instanceof Authorable) {
                    $model->setCreatedByColumn();
                    $model->setUpdatedByColumn();
                }
            }
        });

        $this->app['events']->listen('eloquent.updating*', function ($eventName, array $data) {
            foreach ($data as $model) {
                if ($model instanceof Authorable) {
                    $model->setUpdatedByColumn();
                }
            }
        });
    }

    private function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/eloquent-authorable.php', 'eloquent-authorable');

        $this->publishes([
            __DIR__.'/../config/eloquent-authorable.php' => config_path('eloquent-authorable.php'),
        ], 'config');
    }
}
