<?php

declare(strict_types=1);

namespace Axn\EloquentAuthorable\Tests\Stubs;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SoftDeletableUser extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'users';

    protected $guarded = [];

    public $timestamps = true;
}
