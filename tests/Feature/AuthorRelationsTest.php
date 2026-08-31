<?php

declare(strict_types=1);

use Axn\EloquentAuthorable\Tests\Stubs\RelatedDocument;
use Axn\EloquentAuthorable\Tests\Stubs\SoftAuthorDocument;
use Axn\EloquentAuthorable\Tests\Stubs\SoftDeletableUser;
use Axn\EloquentAuthorable\Tests\Stubs\User;

it('exposes the author through the createdBy and updatedBy relations', function () {
    $author = makeUser('Alice');

    $this->actingAs($author);

    $document = RelatedDocument::create(['title' => 'Draft'])->fresh();

    expect($document->createdBy)->toBeInstanceOf(User::class)
        ->and($document->createdBy->getKey())->toBe($author->getKey())
        ->and($document->updatedBy->getKey())->toBe($author->getKey());
});

it('still resolves an author whose user has been soft deleted', function () {
    $author = SoftDeletableUser::create([
        'name' => 'Alice',
        'email' => 'alice@example.test',
        'password' => 'secret',
    ]);

    $this->actingAs($author);

    $document = SoftAuthorDocument::create(['title' => 'Draft']);

    $author->delete();

    // The default scope of the users model now hides the author...
    expect(SoftDeletableUser::find($author->getKey()))->toBeNull();

    // ... but the relation adds withTrashed() and still finds it.
    expect($document->fresh()->createdBy)->not->toBeNull()
        ->and($document->fresh()->createdBy->getKey())->toBe($author->getKey());
});
