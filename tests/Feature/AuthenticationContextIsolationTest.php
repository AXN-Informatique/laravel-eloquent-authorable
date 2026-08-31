<?php

declare(strict_types=1);

use Axn\EloquentAuthorable\Tests\Stubs\IsolatedDocument;

/*
|--------------------------------------------------------------------------
| Authentication context isolation
|--------------------------------------------------------------------------
|
| Regression test for the guard cached in a method static, removed in 7.2.0.
|
| The two tests below run in the same PHP process against two different
| applications: Testbench rebuilds the application (hence the auth manager, the
| guards and the in-memory database) between them, while a `static` variable
| declared in a trait method survives for the whole process.
|
| With the cache in place, the second test used to receive the guard of the
| first one -- still holding its authenticated user -- and wrote a created_by
| pointing at a users row that no longer existed:
|
|   SQLSTATE[23000]: Integrity constraint violation: 1452
|   Cannot add or update a child row: a foreign key constraint fails
|
| The order of the two tests matters: the first one must authenticate someone.
|
*/

it('records the user authenticated in the current test', function () {
    $author = makeUser('Alice');

    $this->actingAs($author);

    $document = IsolatedDocument::create(['title' => 'First test']);

    expect($document->created_by)->toBe($author->getKey());
});

it('does not reuse the authentication context of the previous test', function () {
    $document = IsolatedDocument::create(['title' => 'Second test']);

    expect($document->created_by)->toBeNull()
        ->and($document->updated_by)->toBeNull();
});
