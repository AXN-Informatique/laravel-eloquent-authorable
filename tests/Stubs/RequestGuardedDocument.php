<?php

declare(strict_types=1);

namespace Axn\EloquentAuthorable\Tests\Stubs;

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Authorable model bound to a guard that is not a session guard.
 *
 * See Document for why every test file owns its own authorable class.
 */
class RequestGuardedDocument extends Model
{
    use AuthorableTrait;

    /**
     * @var array<string, mixed>
     */
    protected $authorable = [
        'guard' => 'api',
    ];

    protected $table = 'documents';

    protected $guarded = [];

    public $timestamps = false;
}
