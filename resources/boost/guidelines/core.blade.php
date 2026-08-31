# Eloquent Authorable

- Automatically fills `created_by`/`updated_by` on Eloquent models (like Laravel timestamps): add `Axn\EloquentAuthorable\AuthorableTrait`, configure per-model via the `$authorable` property, use the `addAuthorableColumns()` Blueprint macro in migrations.
- IMPORTANT: never memoize the guard returned by `getAuthInstance()` (method static, property, singleton): `AuthManager` already does it, and a long-running server (Octane) resets it between two requests — a guard held elsewhere keeps the previous request's user and writes it to `created_by`/`updated_by`.
- See the package's `docs/` directory for configuration and the `createdBy()`/`updatedBy()` relationships.
