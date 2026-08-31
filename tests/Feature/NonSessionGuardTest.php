<?php

declare(strict_types=1);

use Axn\EloquentAuthorable\Tests\Stubs\RequestGuardedDocument;
use Illuminate\Auth\RequestGuard;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Guards other than the session guard
|--------------------------------------------------------------------------
|
| Factory::guard() returns Guard|StatefulGuard: the "token" driver builds a
| TokenGuard, Sanctum and any Auth::viaRequest() driver build a RequestGuard.
| Until 7.2.0 getAuthInstance() was typed ?SessionGuard, which turned any such
| configuration into a TypeError on the first model creation.
|
*/

it('supports a guard that is not a session guard', function () {
    $author = makeUser('Alice');

    config()->set('auth.guards.api', ['driver' => 'request-token']);

    Auth::viaRequest('request-token', fn () => $author);

    expect(Auth::guard('api'))->toBeInstanceOf(RequestGuard::class);

    $document = RequestGuardedDocument::create(['title' => 'Draft']);

    expect($document->created_by)->toBe($author->getKey())
        ->and($document->updated_by)->toBe($author->getKey());
});
