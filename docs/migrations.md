---
title: Migrations
order: 4
---

Migrations
==========

Colonnes requises
-----------------

La table du modèle doit contenir les colonnes `created_by` et `updated_by` (ou les noms personnalisés définis en configuration), avec des clés étrangères vers la table des utilisateurs.

Macros Blueprint
----------------

Le package fournit deux macros sur `Blueprint` pour simplifier les migrations :

### Ajout des colonnes

```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    // ...
    $table->addAuthorableColumns();
    $table->timestamps();
});
```

Par défaut, les colonnes sont de type `unsignedBigInteger`. Pour utiliser `unsignedInteger` à la place :

```php
$table->addAuthorableColumns(false);
```

Pour spécifier un modèle utilisateur différent :

```php
$table->addAuthorableColumns(true, App\Models\Admin::class);
```

### Suppression des colonnes

```php
Schema::table('posts', function (Blueprint $table) {
    $table->dropAuthorableColumns();
});
```

Migration manuelle
------------------

Si la configuration des noms de colonnes a changé depuis la migration initiale, ou en cas de surcharge par modèle, il est préférable de créer les colonnes manuellement :

```php
Schema::table('posts', function (Blueprint $table) {
    $table->unsignedBigInteger('created_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();

    $table->foreign('created_by')
        ->references('id')
        ->on('users');

    $table->foreign('updated_by')
        ->references('id')
        ->on('users');
});
```
