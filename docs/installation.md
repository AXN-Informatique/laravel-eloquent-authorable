---
title: Installation
order: 1
---

Installation
============

Prérequis
---------

- PHP 8.4+
- Laravel 12+

Installation via Composer
-------------------------

```bash
composer require axn/laravel-eloquent-authorable
```

Le `ServiceProvider` est auto-découvert grâce à la configuration `extra.laravel.providers` du `composer.json`.

Publication de la configuration
-------------------------------

```bash
php artisan vendor:publish --provider="Axn\EloquentAuthorable\ServiceProvider" --tag="config"
```

Cela crée le fichier `config/eloquent-authorable.php` avec les valeurs par défaut.
