<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Eloquent Users Model
    |--------------------------------------------------------------------------
    |
    | The Eloquent class representing the users.
    |
    */

    'users_model' => App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Guard
    |--------------------------------------------------------------------------
    |
    | The Guard responsible of the authentication to be used.
    |
    */

    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Set author when creating
    |--------------------------------------------------------------------------
    |
    | Does the package have to register the user ID when there is a creating?
    |
    */

    'set_author_when_creating' => true,

    /*
    |--------------------------------------------------------------------------
    | Set author when updating
    |--------------------------------------------------------------------------
    |
    | Does the package have to register the user ID when there is an updating?
    |
    */

    'set_author_when_updating' => true,

    /*
    |--------------------------------------------------------------------------
    | Default "created_by" column name
    |--------------------------------------------------------------------------
    |
    | The default name for the "created_by" database column.
    |
    */

    'created_by_column_name' => 'created_by',

    /*
    |--------------------------------------------------------------------------
    | Default "updated_by" column name
    |--------------------------------------------------------------------------
    |
    | The default name for the "updated_by" database column.
    |
    */

    'updated_by_column_name' => 'updated_by',

];
