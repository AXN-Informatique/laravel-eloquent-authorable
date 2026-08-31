<?php

declare(strict_types=1);

namespace Axn\EloquentAuthorable\Tests\Stubs;

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Authorable model renaming both author columns.
 *
 * See Document for why every test file owns its own authorable class.
 */
class CustomColumnsArticle extends Model
{
    use AuthorableTrait;

    /**
     * @var array<string, mixed>
     */
    protected $authorable = [
        'created_by_column_name' => 'author_id',
        'updated_by_column_name' => 'editor_id',
    ];

    protected $table = 'articles';

    protected $guarded = [];

    public $timestamps = false;
}
