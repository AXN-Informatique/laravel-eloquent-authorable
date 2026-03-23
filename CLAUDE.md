# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Package overview

Laravel Eloquent Authorable — automatically fills `created_by` and `updated_by` columns on Eloquent models, similar to how Laravel handles `created_at`/`updated_at`. Provides BelongsTo relationships (`createdBy()`, `updatedBy()`) and Blueprint macros for migrations.

- **Namespace:** `Axn\EloquentAuthorable`
- **Requires:** PHP 8.4+, Laravel 12+
- **Auto-discovered** via `ServiceProvider` (registered in `composer.json` extra.laravel.providers)

## Commands

```bash
# Install dependencies
composer install

# Code style (Laravel Pint, laravel preset)
vendor/bin/pint            # fix
vendor/bin/pint --test     # check only

# Rector (automated refactoring)
vendor/bin/rector           # apply
vendor/bin/rector --dry-run # preview changes
```

No test suite exists in this package.

## Architecture

Three source files in `src/`:

- **`AuthorableTrait`** — The trait models use. Hooks into Eloquent `creating`/`updating` events to set the author columns from the authenticated user. Provides `createdBy()`/`updatedBy()` BelongsTo relationships (auto-includes soft-deleted users via `withTrashed()`). Configuration is resolved per-model from `$model->authorable` array, falling back to the global config.

- **`MigrationsMacros`** — Static helper called by Blueprint macros (`addAuthorableColumns` / `dropAuthorableColumns`). Adds nullable foreign-key columns pointing to the users table.

- **`ServiceProvider`** — Merges config, publishes config file, registers the Blueprint macros (console only).

Config file: `config/eloquent-authorable.php` — defines `users_model`, `guard`, column names, and creating/updating toggles.

## Code style notes

- Pint config (`pint.json`): laravel preset with `native_function_invocation` (compiler_optimized, namespaced, strict) and custom `blank_line_before_statement` rules.
- Rector targets PHP 8.4 with deadCode, codeQuality, codingStyle, typeDeclarations, instanceOf, earlyReturn sets. `FirstClassCallableRector` is skipped.

## Laravel Boost Assets

The package provides Laravel Boost integration assets in `resources/boost/`:
- **Guidelines** (`guidelines/core.blade.php`): Package overview for AI assistants

**Important:** These files must be kept up to date when components, configuration keys, or usage patterns change. When adding, renaming, or removing components or config options, update the corresponding Boost assets accordingly.
