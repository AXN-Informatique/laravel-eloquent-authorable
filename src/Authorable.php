<?php

namespace Axn\EloquentAuthorable;

interface Authorable
{
    public function setCreatedByColumn();

    public function setUpdatedByColumn();
}
