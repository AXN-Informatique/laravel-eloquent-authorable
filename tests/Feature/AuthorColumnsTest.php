<?php

declare(strict_types=1);

use Axn\EloquentAuthorable\Tests\Stubs\Document;

it('leaves the author columns null when nobody is authenticated', function () {
    $document = Document::create(['title' => 'Draft']);

    expect($document->created_by)->toBeNull()
        ->and($document->updated_by)->toBeNull();
});

it('fills the author columns with the authenticated user', function () {
    $author = makeUser('Alice');

    $this->actingAs($author);

    $document = Document::create(['title' => 'Draft']);

    expect($document->created_by)->toBe($author->getKey())
        ->and($document->updated_by)->toBe($author->getKey());
});

it('sets updated_by on update without touching created_by', function () {
    $author = makeUser('Alice');
    $editor = makeUser('Bob');

    $this->actingAs($author);

    $document = Document::create(['title' => 'Draft']);

    $this->actingAs($editor);

    $document->update(['title' => 'Reviewed']);

    expect($document->fresh()->created_by)->toBe($author->getKey())
        ->and($document->fresh()->updated_by)->toBe($editor->getKey());
});
