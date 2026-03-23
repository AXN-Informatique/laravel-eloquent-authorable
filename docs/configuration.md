---
title: Configuration
order: 3
---

Configuration
=============

Configuration globale
---------------------

Le fichier `config/eloquent-authorable.php` définit les valeurs par défaut :

| Clé | Défaut | Description |
|-----|--------|-------------|
| `users_model` | `App\Models\User::class` | Modèle Eloquent des utilisateurs |
| `guard` | `web` | Guard d'authentification utilisé |
| `set_author_when_creating` | `true` | Remplir `created_by` à la création |
| `set_author_when_updating` | `true` | Remplir `updated_by` à la mise à jour |
| `created_by_column_name` | `created_by` | Nom de la colonne « créé par » |
| `updated_by_column_name` | `updated_by` | Nom de la colonne « mis à jour par » |

Configuration par modèle
-------------------------

Chaque modèle peut surcharger la configuration globale via la propriété `$authorable` :

```php
use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use AuthorableTrait;

    public $authorable = [
        'users_model'              => \App\Models\Admin::class,
        'guard'                    => 'admin',
        'created_by_column_name'   => 'custom_created_by',
        'updated_by_column_name'   => 'custom_updated_by',
        'set_author_when_creating' => true,
        'set_author_when_updating' => false,
    ];
}
```

Toutes les clés sont optionnelles : seules celles définies surchargent la configuration globale.
