<?php

declare(strict_types=1);

use Axn\EloquentAuthorable\Tests\Stubs\User;
use Axn\EloquentAuthorable\Tests\TestCase;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Test case
|--------------------------------------------------------------------------
|
| Every test needs the Testbench application: the trait reads the container
| ("auth" manager, config) and writes to the database.
|
*/

pest()->extend(TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Shared helpers
|--------------------------------------------------------------------------
*/

/**
 * Create a persisted user.
 */
function makeUser(string $name = 'Alice'): User
{
    return User::create([
        'name' => $name,
        'email' => Str::slug($name).'@example.test',
        'password' => 'secret',
    ]);
}
