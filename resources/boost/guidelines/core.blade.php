# Eloquent Authorable

- Automatically fills `created_by`/`updated_by` on Eloquent models (like Laravel timestamps): add `Axn\EloquentAuthorable\AuthorableTrait`, configure per-model via the `$authorable` property, use the `addAuthorableColumns()` Blueprint macro in migrations.
- See the package's `docs/` directory for configuration and the `createdBy()`/`updatedBy()` relationships.
