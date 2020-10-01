<?php

namespace Axn\EloquentAuthorable;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrationsMacros
{
    public static function addColumns(Blueprint $table)
    {
        $createdBy = config('eloquent-authorable.created_by_column_name');

        if (!Schema::hasColumn($table->getTable(), $createdBy)) {
            $table->unsignedBigInteger($createdBy)->nullable();

            $table->foreign($createdBy)
                ->references('id')
                ->on('users');
        }

        $updatedBy = config('eloquent-authorable.updated_by_column_name');

        if (!Schema::hasColumn($table->getTable(), $updatedBy)) {
            $table->unsignedBigInteger($updatedBy)->nullable();

            $table->foreign($updatedBy)
                ->references('id')
                ->on('users');
        }
    }

    public static function dropColumns(Blueprint $table)
    {
        $createdBy = config('eloquent-authorable.created_by_column_name');

        if (Schema::hasColumn($table->getTable(), $createdBy)) {
            $table->dropForeign([$createdBy]);
            $table->dropColumn($createdBy);
        }

        $updatedBy = config('eloquent-authorable.updated_by_column_name');

        if (Schema::hasColumn($table->getTable(), $updatedBy)) {
            $table->dropForeign([$updatedBy]);
            $table->dropColumn($updatedBy);
        }
    }
}
