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
        //
    }

    /**
     * Perform actions on Eloquent's creating/updating event.
     *
     * @return void
     */
    public function bootEvents()
    {
        $this->app['events']->listen('eloquent.creating*', function ($model) {

            if ($model instanceof Authorable) {
                if ($model->shouldSetAuthorWhenCreating()) {
                    $model->setCreatedByColumn();
                }

                if ($model->shouldSetAuthorWhenUpdating()) {
                    $model->setUpdatedByColumn();
                }
            }
        });

        $this->app['events']->listen('eloquent.updating*', function ($model) {

            if ($model instanceof Authorable && $model->shouldSetAuthorWhenUpdating()) {
                $model->setUpdatedByColumn();
            }
        });
    }
}
