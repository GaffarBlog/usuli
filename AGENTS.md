# Usuli (উসুলি)

Bengali literary journal — Laravel 13, PHP 8.3, Tailwind CSS 4, Pest 4.

## Setup & Dev

```sh
composer setup          # install + key:generate + migrate + npm install + npm run build
composer dev            # artisan serve + queue:listen + vite (concurrently)
```

Database is SQLite (`database/database.sqlite`, auto-created). Migrations run on setup.

## Key Commands

```sh
php artisan test --compact                          # all tests
vendor/bin/pest tests/Feature/CategoryTest.php      # single file
vendor/bin/pest --filter=testName                   # filtered
vendor/bin/pint --dirty --format agent              # format PHP after changes
php artisan make:test --pest SomeTest               # create test
php artisan make:model Category -mcr                # model + migration + controller
```

## Architecture

- **Routes**: `routes/web.php` — all routes in one file (no API routes)
- **Admin panel**: `/admin` prefix, controllers in `app/Http/Controllers/admin/`
- **Views**: `resources/views/admin/` for admin, `resources/views/` for public
- **Models**: `app/Models/` — currently `User`, `Category` (nested set with `parent_id`)
- **Layouts**: `resources/views/admin/layouts/app.blade.php` (admin), `resources/views/layouts/site.blade.php` (public)

## Conventions

- **Language**: All user-facing UI is Bengali (Bangla). Always use Bengali strings for UI text.
- **Tailwind v4**: No `tailwind.config.js`. Theme defined in `resources/css/app.css` using `@theme {}` block with custom colors (`--color-brand`, `--color-ink`, etc.).
- **Custom utilities**: `@utility shell` (centered page container), `@utility reveal` (scroll-reveal animation) defined in `resources/css/app.css`.
- **Fonts**: Noto Sans Bengali + Noto Serif Bengali loaded via Google Fonts. Vite config uses `bunny()` font helper.
- **PHP style**: Use curly braces for all control structures. PHP 8 constructor property promotion. Explicit return types. No empty `__construct()` methods.
- **Testing**: Pest v4. `RefreshDatabase` is commented out in `tests/Pest.php` — tests use in-memory SQLite (`phpunit.xml` sets `DB_DATABASE=:memory:`).

## Gotchas

- Vite manifest error → run `npm run build` or `npm run dev`
- Pint must be run after any PHP file edit: `vendor/bin/pint --dirty --format agent`
- `.ai/rules` directory does not exist — Boost guidelines come from `AGENTS.md` directly
- `CLAUDE.md` is the Laravel Boost install prompt only, not project-specific instructions
