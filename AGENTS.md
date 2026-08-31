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

- **Dual auth system**: `web` guard → `User` model (admin), `frontend` guard → `FrontendUser` model (public users). Never mix them.
- **Routes**: `routes/web.php` (public + frontend auth + dashboard), `routes/admin.php` (admin panel, loaded via `AppServiceProvider::register()`).
- **Admin panel**: `/admin` prefix, `AdminMiddleware`, controllers in `app/Http/Controllers/admin/`.
- **Frontend dashboard**: `/dashboard` prefix, `auth:frontend` middleware, `DashboardController`.
- **Models**: `User` (admin, role-based), `FrontendUser` (public, has writer request fields), `Category` (nested set with `parent_id`, auto-slug), `Post` (status/is_featured/published_at, auto-slug, deletes image on delete), `Role` (comma-separated permissions string), `RouteList`.
- **Layouts**: `resources/views/admin/layouts/app.blade.php` (admin), `resources/views/layouts/site.blade.php` (public, self-contained with header/footer), `resources/views/frontend/dashboard/layout.blade.php` (extends `site`, adds tab nav).
- **Global helpers**: `app/Helpers/helper.php` (autoloaded) — `upload_file()` (WebP via spatie/image), `GetSetting()`, `has_permission()`, `show_image()`, `delete_files()`.
- **spatie/image**: Used for image processing. `upload_file()` converts uploads to WebP at quality 80.
- **TipTap**: Rich text editor (`@tiptap/*` packages, init in `resources/js/tiptap.js`, styles in `resources/css/app.css`).

## Conventions

- **Language**: All user-facing UI is Bengali (Bangla). Always use Bengali strings for UI text.
- **Tailwind v4**: No `tailwind.config.js`. Theme in `resources/css/app.css` `@theme {}` block. Custom utilities: `@utility shell`, `@utility reveal`.
- **Fonts**: Noto Sans Bengali + Noto Serif Bengali (loaded from Google Fonts in layouts). Vite uses `bunny()` for `Instrument Sans` (admin only).
- **PHP style**: Curly braces for all control structures. PHP 8 constructor property promotion. Explicit return types.
- **Testing**: Pest v4. `RefreshDatabase` is commented out in `tests/Pest.php` — tests use in-memory SQLite (`phpunit.xml` sets `DB_DATABASE=:memory:`).
- **`view()` usage**: Controllers return `response()->view(...)` not bare `view(...)`.

## Gotchas

- **Vite manifest error** → run `npm run build` or `npm run dev`
- **Pint must run after every PHP edit**: `vendor/bin/pint --dirty --format agent`
- **`translate()` helper** calls `TranslationService` which doesn't exist yet — will throw if invoked. Avoid using it.
- **`GetSetting()` / `GetSettingGroup()`** depend on `SettingService` which does exist (`app/Services/SettingService.php`). Safe to use.
- **`CLAUDE.md`** is the Laravel Boost install prompt only, not project instructions.
- **Site layout is self-contained**: `site.blade.php` does NOT extend another layout — it IS the layout. Public views use `@extends('layouts.site')` and `@section('content')`.
- **Dashboard layout** extends `site.blade.php` and adds tab navigation via `@section('tab-content')`.
- **jQuery 4.0** loaded from CDN in layouts for interactions (dropdowns, mobile menu, scroll reveal). No Alpine.js or Livewire.
