<?php

declare(strict_types=1);

namespace Axn\EloquentAuthorable\Tests\Stubs;

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Authorable model opting out of both author columns.
 *
 * See Document for why every test file owns its own authorable class.
 */
class OptedOutDocument extends Model
{
    use AuthorableTrait;

    /**
     * @var array<string, mixed>
     */
    protected $authorable = [
        'set_author_when_creating' => false,
        'set_author_when_updating' => false,
    ];

    protected $table = 'documents';

    protected $guarded = [];

    public $timestamps = false;
}
