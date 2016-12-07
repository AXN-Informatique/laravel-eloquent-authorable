<?php

namespace Axn\EloquentAuthorable;

trait AuthorableTrait
{
    /**
     * Indique si l'auteur de la création (champ "created_by") doit être renseigné.
     *
     * @return bool
     */
    public function shouldSetAuthorWhenCreating()
    {
        if (!isset($this->authorable)) {
            return true;
        }

        if (!isset($this->authorable['set_author_when_creating'])) {
            return true;
        }

        return $this->authorable['set_author_when_creating'];
    }

    /**
     * Indique si l'auteur de la modification (champ "updated_by") doit être renseigné.
     *
     * @return bool
     */
    public function shouldSetAuthorWhenUpdating()
    {
        if (!isset($this->authorable)) {
            return true;
        }

        if (!isset($this->authorable['set_author_when_updating'])) {
            return true;
        }

        return $this->authorable['set_author_when_updating'];
    }

    /**
     * Renseigne le champ "created_by".
     *
     * @return void
     */
    public function setCreatedByColumn()
    {
        $this->setAuthorColumn($this->determineCreatedByColumnName());
    }

    /**
     * Renseigne le champ "updated_by".
     *
     * @return void
     */
    public function setUpdatedByColumn()
    {
        $this->setAuthorColumn($this->determineUpdatedByColumnName());
    }

    /**
     * Relation 1-n inverse vers l'utilisateur auteur de la création.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(config('auth.model'), $this->determineCreatedByColumnName());
    }

    /**
     * Relation 1-n inverse vers l'utilisateur auteur de la modification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo(config('auth.model'), $this->determineUpdatedByColumnName());
    }

    /**
     * Détermine le nom du champ "created_by".
     *
     * @return string
     */
    protected function determineCreatedByColumnName()
    {
        if (!empty($this->authorable['created_by_column_name'])) {
            return $this->authorable['created_by_column_name'];
        }

        return 'created_by';
    }

    /**
     * Détermine le nom du champ "updated_by".
     *
     * @return string
     */
    protected function determineUpdatedByColumnName()
    {
        if (!empty($this->authorable['updated_by_column_name'])) {
            return $this->authorable['updated_by_column_name'];
        }

        return 'updated_by';
    }

    /**
     * Renseigne un champ auteur selon le nom de la champ ("created_by", "updated_by").
     *
     * @param  string $column
     * @return void
     */
    protected function setAuthorColumn($column)
    {
        if (app('auth')->check()) {
            $user = app('auth')->user();

            $this->$column = $user->{$user->getKeyName()};
        }
    }
}
