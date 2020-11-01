<?php

namespace Axn\EloquentAuthorable;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrationsMacros
{
    public static function addColumns(Blueprint $table, $useBigInteger = false, $usersModel = null)
    {
        $config = config('eloquent-authorable');

        $userModel = resolve($usersModel ?? $config['users_model']);

        $usersTableKey = $userModel->getKeyName();
        $usersTableName = $userModel->getTable();


        $createdByColumn = $config['created_by_column_name'];

        if (!Schema::hasColumn($table->getTable(), $createdByColumn)) {
            if ($useBigInteger) {
                $table->unsignedBigInteger($createdByColumn)->nullable();
            } else {
                $table->unsignedInteger($createdByColumn)->nullable();
            }

            $table->foreign($createdByColumn)
                ->references($usersTableKey)
                ->on($usersTableName);
        }

        $updatedByColumn = $config['updated_by_column_name'];

        if (!Schema::hasColumn($table->getTable(), $updatedByColumn)) {
            if ($useBigInteger) {
                $table->unsignedBigInteger($updatedByColumn)->nullable();
            } else {
                $table->unsignedInteger($updatedByColumn)->nullable();
            }

            $table->foreign($updatedByColumn)
                ->references($usersTableKey)
                ->on($usersTableName);
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
