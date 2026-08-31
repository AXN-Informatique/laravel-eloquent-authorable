<?php

declare(strict_types=1);

namespace Axn\EloquentAuthorable\Tests\Stubs;

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Authorable model of the nominal test file.
 *
 * Each test file owns its own authorable class, and none of them extend a
 * common parent: a `static` variable declared in a trait method is shared by
 * every instance of the class using the trait AND by its subclasses. Sharing a
 * stub would let the authentication context of one file leak into another and
 * make the failures depend on the execution order.
 */
class Document extends Model
{
    use AuthorableTrait;

    protected $table = 'documents';

    protected $guarded = [];

    public $timestamps = false;
}
