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

- **Routes**: `routes/web.php` (public), `routes/admin.php` (admin). Admin routes loaded via `AppServiceProvider`, not a RouteServiceProvider.
- **Admin panel**: `/admin` prefix, `AdminMiddleware`, controllers in `app/Http/Controllers/admin/`.
- **Views**: `resources/views/admin/` for admin, `resources/views/` for public.
- **Models**: `User`, `Category` (nested set with `parent_id`, auto-slug), `Post` (with status/is_featured/published_at, auto-slug, deletes image on delete), `Role` (comma-separated permissions string), `RouteList`.
- **Layouts**: `resources/views/admin/layouts/app.blade.php` (admin), `resources/views/layouts/site.blade.php` (public).
- **Global helpers**: `app/Helpers/helper.php` (autoloaded) — `upload_file()` (WebP via spatie/image), `translate()`, `GetSetting()`, `has_permission()`, `show_image()`, `delete_files()`. Services (`SettingService`, `TranslationService`) referenced but not yet created.
- **TipTap**: Rich text editor on frontend (`@tiptap/*` packages, styles in `resources/css/app.css`).
- **spatie/image**: Used for image processing. `upload_file()` converts uploads to WebP at quality 80.

## Conventions

- **Language**: All user-facing UI is Bengali (Bangla). Always use Bengali strings for UI text.
- **Tailwind v4**: No `tailwind.config.js`. Theme in `resources/css/app.css` `@theme {}` block. Custom utilities: `@utility shell`, `@utility reveal`.
- **Fonts**: Noto Sans Bengali + Noto Serif Bengali. Vite uses `bunny()` font helper (currently only `Instrument Sans` for admin).
- **PHP style**: Curly braces for all control structures. PHP 8 constructor property promotion. Explicit return types. No empty `__construct()`.
- **Testing**: Pest v4. `RefreshDatabase` commented out in `tests/Pest.php` — tests use in-memory SQLite (`phpunit.xml` sets `DB_DATABASE=:memory:`).

## Gotchas

- Vite manifest error → run `npm run build` or `npm run dev`
- Pint must be run after any PHP file edit: `vendor/bin/pint --dirty --format agent`
- Helper references `SettingService` and `TranslationService` that don't exist yet — will error if those helpers are called
- `CLAUDE.md` is the Laravel Boost install prompt only, not project-specific instructions
