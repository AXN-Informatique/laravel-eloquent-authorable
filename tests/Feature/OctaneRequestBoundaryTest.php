<?php

declare(strict_types=1);

use Axn\EloquentAuthorable\Tests\Stubs\OctaneDocument;

/*
|--------------------------------------------------------------------------
| Octane request boundary
|--------------------------------------------------------------------------
|
| On a long-running server, the application boots once and serves many
| requests. Octane resets the authentication state between two of them, from
| Laravel\Octane\Listeners\FlushAuthenticationState:
|
|   if ($event->sandbox->resolved('auth')) {
|       with($event->sandbox->make('auth'), function ($auth) use ($event) {
|           $auth->setApplication($event->sandbox);
|           $auth->forgetGuards();
|       });
|   }
|
| That listener is part of Octane::prepareApplicationForNextRequest(), wired by
| default on the RequestReceived event. AuthManager::forgetGuards() only empties
| its own index ($this->guards = []): a guard held elsewhere keeps its resolved
| user, and SessionGuard::user() returns it without revalidating.
|
| forgetGuards() is called below instead of installing Octane: it is the whole
| of what the listener does to the auth manager.
|
*/

it('resolves the guard again after the authentication state has been flushed', function () {
    $first = makeUser('Alice');
    $second = makeUser('Bob');

    // Request N
    $this->actingAs($first);

    $document = OctaneDocument::create(['title' => 'Request N']);

    expect($document->created_by)->toBe($first->getKey());

    // Request boundary
    app('auth')->forgetGuards();

    // Request N+1, served by the same worker
    $this->actingAs($second);

    $document = OctaneDocument::create(['title' => 'Request N+1']);

    expect($document->created_by)->toBe($second->getKey());
});
