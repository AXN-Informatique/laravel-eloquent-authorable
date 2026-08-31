<?php

declare(strict_types=1);

namespace Axn\EloquentAuthorable\Tests\Stubs;

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Authorable model whose users model is soft deletable.
 *
 * See Document for why every test file owns its own authorable class.
 */
class SoftAuthorDocument extends Model
{
    use AuthorableTrait;

    /**
     * @var array<string, mixed>
     */
    protected $authorable = [
        'users_model' => SoftDeletableUser::class,
    ];

    protected $table = 'documents';

    protected $guarded = [];

    public $timestamps = false;
}
