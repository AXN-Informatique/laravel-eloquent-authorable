<?php

declare(strict_types=1);

namespace Axn\EloquentAuthorable\Tests\Stubs;

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Authorable model of the Octane request boundary test file.
 *
 * See Document for why every test file owns its own authorable class.
 */
class OctaneDocument extends Model
{
    use AuthorableTrait;

    protected $table = 'documents';

    protected $guarded = [];

    public $timestamps = false;
}
