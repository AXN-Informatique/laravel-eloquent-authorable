<?php

namespace Axn\EloquentAuthorable;

interface Authorable
{
    public function shouldSetAuthorWhenCreating();

    public function shouldSetAuthorWhenUpdating();

    public function setCreatedByColumn();

    public function setUpdatedByColumn();
}