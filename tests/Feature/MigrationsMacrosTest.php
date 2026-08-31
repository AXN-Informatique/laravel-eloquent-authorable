<?php

declare(strict_types=1);

use Axn\EloquentAuthorable\Tests\Stubs\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Blueprint macros
|--------------------------------------------------------------------------
|
| The macros are registered by the service provider under runningInConsole(),
| which holds while the test suite runs.
|
| The second argument of addAuthorableColumns() is a users *model* class name,
| never a table name: MigrationsMacros::addColumns() resolves it and reads the
| table and key from the resolved model.
|
*/

it('adds both author columns', function () {
    Schema::create('macro_posts', function (Blueprint $table): void {
        $table->id();
        $table->addAuthorableColumns();
    });

    expect(Schema::hasColumns('macro_posts', ['created_by', 'updated_by']))->toBeTrue();
});

it('accepts the small integer column type and an explicit users model', function () {
    Schema::create('macro_small_posts', function (Blueprint $table): void {
        $table->id();
        $table->addAuthorableColumns(false, User::class);
    });

    expect(Schema::hasColumns('macro_small_posts', ['created_by', 'updated_by']))->toBeTrue();
});

it('leaves already existing author columns alone', function () {
    // The documents table is created with both columns by the test migrations.
    Schema::table('documents', function (Blueprint $table): void {
        $table->addAuthorableColumns();
    });

    expect(Schema::hasColumns('documents', ['created_by', 'updated_by']))->toBeTrue();
});

it('drops both author columns', function () {
    Schema::table('documents', function (Blueprint $table): void {
        $table->dropAuthorableColumns();
    });

    expect(Schema::hasColumn('documents', 'created_by'))->toBeFalse()
        ->and(Schema::hasColumn('documents', 'updated_by'))->toBeFalse();
});
