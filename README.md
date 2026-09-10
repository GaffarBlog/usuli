# উসুলি (Usuli)

> নুসুস-ফাহমুস-সালাফ — A Bengali literary journal for publishing and reading Bengali literature including stories, poetry, essays, and other literary works.

![Laravel 13](https://img.shields.io/badge/Laravel-13-red)
![PHP 8.3](https://img.shields.io/badge/PHP-8.3-purple)
![Tailwind CSS 4](https://img.shields.io/badge/Tailwind_CSS-4-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## Features

- **Public-Facing Site** — Home, blog, about, contact pages with Bengali UI
- **Admin Panel** — Full content management at `/admin`
- **Dual Authentication** — Separate admin and public user systems
- **Rich Text Editor** — TipTap-powered editor for Bengali content
- **Role-Based Access Control** — Granular permission management
- **Threaded Comments** — Nested comment system on posts
- **Writer Requests** — Public users can request writer status
- **Image Processing** — WebP conversion via spatie/image
- **Settings Management** — Dynamic site configuration from database

## Tech Stack

| Component | Technology |
|---|---|
| Backend | Laravel 13 |
| PHP | 8.3+ |
| CSS | Tailwind CSS 4 |
| Build Tool | Vite 8 |
| Rich Text Editor | TipTap 3 |
| JavaScript | jQuery 4.0 |
| Testing | Pest 4 |
| Image Processing | spatie/image |
| Database | SQLite (default) |
| Fonts | Noto Sans Bengali + Noto Serif Bengali |

## Requirements

- PHP 8.3 or higher
- Composer
- Node.js and npm
- SQLite (default; no external database server needed)

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/usuli.git
cd usuli
```

### 2. Run the Setup Command

This single command handles everything:

```bash
composer setup
```

This automatically:
1. Installs PHP dependencies (`composer install`)
2. Copies `.env.example` to `.env`
3. Generates the application encryption key
4. Runs all database migrations (auto-creates SQLite database)
5. Installs Node.js dependencies
6. Builds frontend assets with Vite

### 3. Start Development Server

```bash
composer dev
```

This starts three concurrent processes:
- PHP development server (`artisan serve`)
- Queue listener (`artisan queue:listen`)
- Vite dev server

Visit [http://localhost:8000](http://localhost:8000)

## Default Credentials

### Admin Panel

- **URL**: `/admin`
- **Email**: `admin@gmail.com`
- **Password**: `123456`

> A default Super Admin user is automatically created on first visit to the login page if no users exist.

## Project Structure

```
usuli/
├── app/
│   ├── Helpers/helper.php          # Global helper functions
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── admin/              # Admin controllers (11)
│   │   │   ├── Auth/               # Authentication controllers
│   │   │   └── ...                 # Public controllers
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── FrontendDashboardMiddleware.php
│   ├── Models/                     # Eloquent models (9)
│   └── Services/SettingService.php
├── config/                         # Laravel configuration
├── database/
│   ├── migrations/                 # Database migrations (14)
│   └── seeders/                    # Database seeders
├── resources/
│   ├── css/app.css                 # Tailwind v4 theme
│   ├── js/                         # JavaScript (TipTap)
│   └── views/
│       ├── layouts/main.blade.php  # Public site layout
│       ├── admin/                  # Admin panel views
│       └── frontend/               # User dashboard views
├── routes/
│   ├── web.php                     # Public + frontend auth routes
│   └── admin.php                   # Admin panel routes
└── tests/                          # Pest tests
```

## Architecture

### Dual Authentication System

The application uses two completely separate Laravel guards:

| Guard | Model | Purpose | Middleware |
|---|---|---|---|
| `web` | `User` | Admin panel | `AdminMiddleware` |
| `frontend` | `FrontendUser` | Public site users | `auth:frontend` |

> **Important**: Never mix the two authentication systems. They use separate database tables and models.

### Models & Relationships

| Model | Key Relationships |
|---|---|
| **User** | `hasOne` Role |
| **Role** | `belongsTo` User |
| **Category** | `belongsTo` Category (parent), `hasMany` Category (children) — hierarchical/nested set |
| **Post** | `belongsTo` Category, `belongsTo` User (author), `hasMany` Comment |
| **Comment** | `belongsTo` Post, `belongsTo` FrontendUser, `belongsTo` User (admin), threaded replies |
| **FrontendUser** | Standalone public user with writer request fields |
| **Setting** | Key-value store for site configuration |
| **Contact** | Contact form submissions |
| **RouteList** | Permission routes for RBAC, hierarchical |

### Routes Overview

**Public Routes** (`routes/web.php`):
- `/` — Home page
- `/about` — About page
- `/blog` — Blog listing with category filters
- `/blog/{slug}` — Single post view
- `/contact` — Contact form
- `/login`, `/register` — Frontend authentication
- `/dashboard/*` — User dashboard (profile, password, writer request)

**Admin Routes** (`routes/admin.php`):
- `/admin/login` — Admin login
- `/admin` — Dashboard
- `/admin/users/*` — User management
- `/admin/roles/*` — Role management
- `/admin/permission/{role_id}` — Permission management
- `/admin/posts/*` — Post management
- `/admin/categories/*` — Category management
- `/admin/comments/*` — Comment management
- `/admin/contacts/*` — Contact management
- `/admin/settings/*` — Site settings

## Key Features

### Dynamic Settings

All site configuration is stored in the database and accessible via:

```php
GetSetting('site_name')      // Get a single setting
GetSettingsGroup('home_')     // Get settings by prefix
```

### Global Helpers

| Function | Purpose |
|---|---|
| `upload_file($file, $folder, $name)` | Upload files as WebP to `public/storage/uploads/` |
| `GetSetting($key)` | Get cached setting value (1-hour cache) |
| `has_permission($route)` | Check admin role permission |
| `show_image($images, $size, $type)` | Get image URL or placeholder |
| `delete_files($files, $exclude)` | Delete files from disk |
| `buildNavbarItems()` | Build public navbar from database settings |

### TipTap Editor

The admin panel uses TipTap for rich text editing with Bengali tooltips and full formatting support (bold, italic, headings, lists, quotes, links, images, alignment, undo/redo).

### Testing

Run the test suite:

```bash
php artisan test --compact
# or
vendor/bin/pest
# or
composer test
```

Tests run against an in-memory SQLite database (configured in `phpunit.xml`).

### Code Style

The project uses Laravel Pint for PHP code formatting. After making PHP changes, run:

```bash
vendor/bin/pint --dirty --format agent
```

## Gotchas

1. **`translate()` helper** — Calls `TranslationService` which does not exist yet. Avoid using it.
2. **Image uploads** — Stored in `public/storage/uploads/`, not Laravel's default `storage/app/public`.
3. **Role global scope** — The `Role` model hides "Super Admin" from default queries.
4. **Site layout is self-contained** — `main.blade.php` IS the layout (does not extend another).
5. **No Alpine.js or Livewire** — All client-side interactivity uses jQuery 4.0.
6. **Vite manifest error** — Run `npm run build` or `npm run dev` to resolve.

## License

MIT License

---

**Usuli (উসুলি)** — A platform for Bengali literary expression.
