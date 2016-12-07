<?php

namespace Axn\EloquentAuthorable;

use Illuminate\Support\Facades\Auth;

trait AuthorableTrait
{
    /**
     * Set the "created_by" column.
     *
     * @return void
     */
    public function setCreatedByColumn()
    {
        if ($this->shouldSetAuthorWhenCreating()) {
            $this->setAuthorColumn($this->determineCreatedByColumnName());
        }
    }

    /**
     * Set the "updated_by" column.
     *
     * @return void
     */
    public function setUpdatedByColumn()
    {
        if ($this->shouldSetAuthorWhenUpdating()) {
            $this->setAuthorColumn($this->determineUpdatedByColumnName());
        }
    }

    /**
     * Inverse 1-n relationship to the authoring user when creating.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo($this->getUsersModel(), $this->determineCreatedByColumnName());
    }

    /**
     * Inverse 1-n relationship to the authoring user when updating.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo($this->getUsersModel(), $this->determineUpdatedByColumnName());
    }

    /**
     * Determines the users model name to use.
     *
     * @return string
     */
    protected function getUsersModel()
    {
        if (!isset($this->authorable['users_model'])) {
            return config('eloquent-authorable.users_model');
        }

        return $this->authorable['users_model'];
    }

    /**
     * Indicates whether the author must be setted when creating (column "created_by").
     *
     * @return bool
     */
    protected function shouldSetAuthorWhenCreating()
    {
        if (!isset($this->authorable['set_author_when_creating'])) {
            return config('eloquent-authorable.set_author_when_creating');
        }

        return $this->authorable['set_author_when_creating'];
    }

    /**
     * Indicates whether the author must be setted when updating (column "updated_by").
     *
     * @return bool
     */
    protected function shouldSetAuthorWhenUpdating()
    {
        if (!isset($this->authorable['set_author_when_updating'])) {
            return config('eloquent-authorable.set_author_when_updating');
        }

        return $this->authorable['set_author_when_updating'];
    }

    /**
     * Determines the name of the "created_by" column.
     *
     * @return string
     */
    protected function determineCreatedByColumnName()
    {
        if (!empty($this->authorable['created_by_column_name'])) {
            return $this->authorable['created_by_column_name'];
        }

        return config('eloquent-authorable.created_by_column_name');
    }

    /**
     * Determines the name of the "updated_by" column.
     *
     * @return string
     */
    protected function determineUpdatedByColumnName()
    {
        if (!empty($this->authorable['updated_by_column_name'])) {
            return $this->authorable['updated_by_column_name'];
        }

        return config('eloquent-authorable.updated_by_column_name');
    }

    /**
     * Set an author column according to the column name ("created_by", "updated_by").
     *
     * @param  string $column
     * @return void
     */
    protected function setAuthorColumn($column)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $this->$column = $user->{$user->getKeyName()};
        }
    }
}
