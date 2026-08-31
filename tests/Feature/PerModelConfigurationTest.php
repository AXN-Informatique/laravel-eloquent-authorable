<?php

declare(strict_types=1);

use Axn\EloquentAuthorable\Tests\Stubs\CustomColumnsArticle;
use Axn\EloquentAuthorable\Tests\Stubs\OptedOutDocument;

/*
|--------------------------------------------------------------------------
| Per-model configuration
|--------------------------------------------------------------------------
|
| Every setting can be overridden on the model through its $authorable array,
| falling back to the global config.
|
*/

it('honours the column names declared on the model', function () {
    $author = makeUser('Alice');

    $this->actingAs($author);

    $article = CustomColumnsArticle::create(['title' => 'Draft']);

    expect($article->author_id)->toBe($author->getKey())
        ->and($article->editor_id)->toBe($author->getKey());
});

it('does not touch the author columns when the model opts out', function () {
    $author = makeUser('Alice');

    $this->actingAs($author);

    $document = OptedOutDocument::create(['title' => 'Draft']);

    expect($document->created_by)->toBeNull()
        ->and($document->updated_by)->toBeNull();

    $document->update(['title' => 'Reviewed']);

    expect($document->fresh()->updated_by)->toBeNull();
});
