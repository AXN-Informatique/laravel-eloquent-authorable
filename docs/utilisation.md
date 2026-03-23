---
title: Utilisation
order: 2
---

Utilisation
===========

Ajouter le trait au modèle
--------------------------

```php
use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use AuthorableTrait;
}
```

À chaque création ou mise à jour, les colonnes `created_by` et `updated_by` sont automatiquement remplies avec l'identifiant de l'utilisateur authentifié.

Relations disponibles
---------------------

Le trait fournit deux relations `BelongsTo` :

| Relation | Colonne | Description |
|----------|---------|-------------|
| `createdBy()` | `created_by` | Utilisateur ayant créé l'enregistrement |
| `updatedBy()` | `updated_by` | Utilisateur ayant mis à jour l'enregistrement |

Ces relations incluent automatiquement les utilisateurs soft-deleted (`withTrashed()`).

### Eager loading

```php
$post = Post::with('createdBy', 'updatedBy')->first();
```

### Affichage en Blade

```blade
Créé par {{ $post->createdBy->name }}
et mis à jour par {{ $post->updatedBy->name }}
```
