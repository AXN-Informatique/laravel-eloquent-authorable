Laravel Eloquent Authorable
===========================

As Laravel Eloquent is able to automatically fill in the `created_at` and` updated_at` fields,
this package provides automatic support for the `created_by` and` updated_by` fields in your Eloquent models.

This package will avoid you to always indicate when creating and/or updating a model who is the user who performed this action.
This package does it for you and it simplifies the recovery of this information.

So you can easily store and display this kind of information:

> Added by **AXN** on *2016-03-24* and updated by **forxer** on *2020-10-01*

Installation
------------

With Composer :

```sh
composer require axn/laravel-eloquent-authorable
```

Usage
-----

To add functionality to a model, it is necessary that:

1. The related table has the concerned fields (by default `created_at` and `updated_at`)
2. The model use the trait `Axn\EloquentAuthorable\Authorable`


### Database columns

You must create the columns in the database on the table of the model concerned.
These columns are used to create the relationship between the related table and the "users" table.

For example :

```php
Schema::table('posts', function (Blueprint $table) {
    $table->unsignedInteger('created_by')->nullable();
    $table->unsignedInteger('updated_by')->nullable();

    $table->foreign('created_by')
        ->references('id')
        ->on('users');

    $table->foreign('updated_by')
        ->references('id')
        ->on('users');
});
```

#### Migrations helpers

Convenient utilities are available for adding or removing these columns in your migrations:

```php
Schema::create('posts', function (Blueprint $table) {
    //...
    $table->addAuthorableColumns();
});
```

```php
Schema::table('posts', function (Blueprint $table) {
    //...
    $table->dropAuthorableColumns();
});
```

By default the `addAuthorableColumns()` method will generate integer columns type, if you need bigInteger instead you can pass the first parameter to `true`.

```php
Schema::create('posts', function (Blueprint $table) {
    //...
    $table->addAuthorableColumns(true);
});
```

Also you can pass a users model class name as third parameter if needed.

```php
Schema::create('posts', function (Blueprint $table) {
    //...
    $table->addAuthorableColumns(true, App\Models\User::class);
});
```

**Warning !**
*These utilities use the columns names specified in the package configuration file **at the time the migrations are run**. If you modify this configuration, before or after having migrated, or if you overload it with the configuration by model, **you should not use these utilities** but add the columns by yourself. So these utilities are perfects for new application, but for old ones or for existing models, it is also recommended to create the columns yourself.*

**Important note**
*You can customize both the column names and the users table through settings; and this globally or by model (see below)*

### Eloquent Model

```php

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model

class Post extends Model
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

####  Using Eloquent eager-loading

```php
$post = Post::with('createdBy', 'updatedBy')->first();
```

###  Using in Blade view

```blade
Created by {{ $post->createdBy->name }} ({{ $post->createdBy->email }})
and updated by {{ $post->updatedBy->name }} ({{ $post->updatedBy->email }})
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

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model

class Post extends Model
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

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model

class Post extends Model
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

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model

class Post extends Model
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

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model

class Post extends Model
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

