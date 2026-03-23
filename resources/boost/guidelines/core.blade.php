# Eloquent Authorable

- Automatically fills `created_by` and `updated_by` columns on Eloquent models, similar to how Laravel handles `created_at`/`updated_at`.
- Add `Axn\EloquentAuthorable\AuthorableTrait` to any model to enable automatic author tracking.
- Per-model configuration is possible via a `public $authorable` array property (keys: `users_model`, `guard`, `created_by_column_name`, `updated_by_column_name`, `set_author_when_creating`, `set_author_when_updating`).
- Global defaults are in `config/eloquent-authorable.php` (publishable).
- Use `$table->addAuthorableColumns()` / `$table->dropAuthorableColumns()` Blueprint macros in migrations.
- Relationships `createdBy()` and `updatedBy()` are available and automatically include soft-deleted users via `withTrashed()`.
