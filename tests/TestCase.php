<?php

declare(strict_types=1);

namespace Axn\EloquentAuthorable\Tests;

use Axn\EloquentAuthorable\ServiceProvider;
use Axn\EloquentAuthorable\Tests\Stubs\User;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));

        // Foreign keys are off by default on SQLite unless the option is set
        // explicitly. They are kept on here because the author columns point at
        // the users table in real applications: a stale author id must fail the
        // same way it does on MySQL.
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);

        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('eloquent-authorable.users_model', User::class);
    }
}
