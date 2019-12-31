Laravel Eloquent Authorable
===========================

As Laravel Eloquent is able to automatically fill in the `created_at` and` updated_at` fields,
this package provides automatic support for the `created_by` and` updated_by` fields in your Eloquent models.

This package will avoid you to always indicate when creating and/or updating a model who is the user who performed this action.
This package does it for you and it simplifies the recovery of this information.


Installation
------------

With Composer :

```sh
composer require axn/laravel-eloquent-authorable
```

Usage
-----

To add functionality to a model, it is necessary that:

1. the model implements the interface `Axn\EloquentAuthorable\Authorable`
2. the model use the trait `Axn\EloquentAuthorable\Authorable`
3. The related table has the concerned fields (by default `created_at` and `updated_at`)


### Simple example

#### Eloquent Model

```php

use Axn\EloquentAuthorable\Authorable;
use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model

class Post extends Model implements Authorable
{
    use AuthorableTrait;

    //...
}
```

From now on, each creation/update of an entry in the `Posts` table
the `created_by` and `updated_by` columns will automatically be filled
with the id of the currently authenticated user.

In addition two 1-n inverse relationships (belongs to) with the users table are available:

- createdBy()
- updatedBy()

####  Using in Blade view

```blade
Created by {{ $post->createdBy->name }} ({{ $post->createdBy->email }})
and updated by {{ $post->updatedBy->name }} ({{ $post->updatedBy->email }})
```

####  Using Eloquent eager-loading

```php
$post = Post::with('createdBy', 'updatedBy')->first();
```

Settings
--------

There are two ways to set this feature:

- globally for your application thanks to the configuration file
- or for each model that uses it

### Global configuration

First initialise the config file in your application by running this command:

```sh
php artisan vendor:publish --provider="Axn\EloquentAuthorable\ServiceProvider" --tag="config"
```

Then, when published, the `config/eloquent-authorable.php` config file will contain the default values that you can then customize.

Default values in this file are:

- `users_model`: `App\User::class`
- `guard`: `web`
- `set_author_when_creating`: `true`
- `set_author_when_updating`: `true`
- `created_by_column_name`: `'created_by'`
- `updated_by_column_name`: `'updated_by'`


### Settings by model

#### Model and guard

By default, the user model `App\User::class` and `web` guard are used.

You can specify different ones like this:

```php

use Axn\EloquentAuthorable\Authorable;
use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model

class Post extends Model implements Authorable
{
    use AuthorableTrait;

    public $authorable = [
        'model' => \App\Admin::class,
        'guard' => 'admin',
    ];

    //...
}
```

#### Column names

By default, the `created_by` and` updated_by` columns are used.

You can specify different column names for a model like this:

```php

use Axn\EloquentAuthorable\Authorable;
use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model

class Post extends Model implements Authorable
{
    use AuthorableTrait;

    public $authorable = [
        'created_by_column_name' => 'custom_created_by',
        'updated_by_column_name' => 'custom_updated_by',
    ];

    //...
}
```

#### Enabling/Disabling

You can disable the feature like this:

```php

use Axn\EloquentAuthorable\Authorable;
use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model

class Post extends Model implements Authorable
{
    use AuthorableTrait;

    public $authorable = [
        'set_author_when_creating' => false,
        'set_author_when_updating' => false,
    ];

    //...
}
```


#### Full example of custom implementation

```php

use Axn\EloquentAuthorable\Authorable;
use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model

class Post extends Model implements Authorable
{
    use AuthorableTrait;

    public $authorable = [
        'model' => \App\Admin::class,
        'guard' => 'admin',
        'created_by_column_name    => 'custom_created_by',
        'set_author_when_creating' => true,
        'updated_by_column_name'   => 'custom_updated_by',
        'set_author_when_updating' => false,
    ];

    //...
}
```

