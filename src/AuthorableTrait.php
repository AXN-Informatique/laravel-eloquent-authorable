<?php

namespace Axn\EloquentAuthorable;

use Illuminate\Auth\SessionGuard;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait AuthorableTrait
{
    /**
     * Boot trait, register "creating" and "updating" events.
     *
     * @return void
     */
    protected static function bootAuthorableTrait()
    {
        static::creating(function ($model): void {
            $model->setCreatedByColumn();
            $model->setUpdatedByColumn();
        });

        static::updating(function ($model): void {
            $model->setUpdatedByColumn();
        });
    }

    /**
     * Set the "created_by" column.
     */
    public function setCreatedByColumn(): void
    {
        if ($this->shouldSetAuthorWhenCreating()) {
            $this->setAuthorColumn($this->determineCreatedByColumnName());
        }
    }

    /**
     * Set the "updated_by" column.
     */
    public function setUpdatedByColumn(): void
    {
        if ($this->shouldSetAuthorWhenUpdating()) {
            $this->setAuthorColumn($this->determineUpdatedByColumnName());
        }
    }

    /**
     * Inverse 1-n relationship to the authoring user when creating.
     */
    public function createdBy(): BelongsTo
    {
        $relation = $this->belongsTo($this->getUsersModel(), $this->determineCreatedByColumnName());

        if (method_exists($relation->getRelated(), 'getDeletedAtColumn')) {
            return $relation->withTrashed();
        }

        return $relation;
    }

    /**
     * Inverse 1-n relationship to the authoring user when updating.
     */
    public function updatedBy(): BelongsTo
    {
        $relation = $this->belongsTo($this->getUsersModel(), $this->determineUpdatedByColumnName());

        if (method_exists($relation->getRelated(), 'getDeletedAtColumn')) {
            return $relation->withTrashed();
        }

        return $relation;
    }

    protected function getAuthInstance(): ?SessionGuard
    {
        static $auth = null;

        if ($auth === null) {
            $auth = app('auth')->guard($this->getGuardName());
        }

        return $auth;
    }

    /**
     * Determines the users model name to use.
     */
    protected function getUsersModel(): string
    {
        if (! isset($this->authorable['users_model'])) {
            return config('eloquent-authorable.users_model');
        }

        return $this->authorable['users_model'];
    }

    /**
     * Determines the Guard name to use.
     */
    protected function getGuardName(): string
    {
        if (! isset($this->authorable['guard'])) {
            return config('eloquent-authorable.guard');
        }

        return $this->authorable['guard'];
    }

    /**
     * Indicates whether the author must be setted when creating (column "created_by").
     */
    protected function shouldSetAuthorWhenCreating(): bool
    {
        if (! isset($this->authorable['set_author_when_creating'])) {
            return config('eloquent-authorable.set_author_when_creating');
        }

        return $this->authorable['set_author_when_creating'];
    }

    /**
     * Indicates whether the author must be setted when updating (column "updated_by").
     */
    protected function shouldSetAuthorWhenUpdating(): bool
    {
        if (! isset($this->authorable['set_author_when_updating'])) {
            return config('eloquent-authorable.set_author_when_updating');
        }

        return $this->authorable['set_author_when_updating'];
    }

    /**
     * Determines the name of the "created_by" column.
     */
    protected function determineCreatedByColumnName(): string
    {
        if (! empty($this->authorable['created_by_column_name'])) {
            return $this->authorable['created_by_column_name'];
        }

        return config('eloquent-authorable.created_by_column_name');
    }

    /**
     * Determines the name of the "updated_by" column.
     */
    protected function determineUpdatedByColumnName(): string
    {
        if (! empty($this->authorable['updated_by_column_name'])) {
            return $this->authorable['updated_by_column_name'];
        }

        return config('eloquent-authorable.updated_by_column_name');
    }

    /**
     * Set an author column according to the column name ("created_by", "updated_by").
     */
    protected function setAuthorColumn(string $column): void
    {
        $auth = $this->getAuthInstance();

        if ($auth->check()) {
            $user = $auth->user();

            $this->$column = $user->{$user->getKeyName()};
        }
    }
}
