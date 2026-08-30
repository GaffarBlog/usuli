<?php

use App\Services\SettingService;
use App\Services\TranslationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Image\Image;

// if (! function_exists('sidebarList')) {
//     function sidebarList()
//     {
//         return [
//             'Dashboard' => [
//                 'icon' => 'chart-pie',
//                 'route' => 'admin.dashboard.view',
//                 'permission' => has_permission('admin.dashboard.view'),
//             ],
//             'User Management' => [
//                 'icon' => 'users',
//                 'permission' => has_permissions(['admin.users.view', 'admin.users-roles.view']),
//                 'Users' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.users.view',
//                     'permission' => has_permission('admin.users.view'),
//                 ],
//                 'User Role' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.users-roles.view',
//                     'permission' => has_permission('admin.users-roles.view'),
//                 ],
//             ],
//             'Product Management' => [
//                 'icon' => 'shopping-bag',
//                 'permission' => has_permissions(['admin.products.view', 'admin.categories.view']),
//                 'Products' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.products.view',
//                     'permission' => has_permission('admin.products.view'),
//                 ],
//                 'Product Category' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.categories.view',
//                     'permission' => has_permission('admin.categories.view'),
//                 ],
//                 'Product Attributes' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.attributes.view',
//                     'permission' => has_permission('admin.attributes.view'),
//                 ],
//             ],
//             'Manage Translation' => [
//                 'icon' => 'languages',
//                 'permission' => has_permissions(['admin.products.view', 'admin.categories.view']),
//                 'Languages' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.languages.view',
//                     'permission' => has_permission('admin.languages.view'),
//                 ],
//                 'Translations' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.translations.view',
//                     'permission' => has_permission('admin.translations.view'),
//                 ],

//             ],
//             'Manage Translation' => [
//                 'icon' => 'languages',
//                 'permission' => has_permissions(['admin.products.view', 'admin.categories.view']),
//                 'Languages' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.languages.view',
//                     'permission' => has_permission('admin.languages.view'),
//                 ],
//                 'Translations' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.translations.view',
//                     'permission' => has_permission('admin.translations.view'),
//                 ],

//             ],
//             'Coupons' => [
//                 'icon' => 'ticket',
//                 'route' => 'admin.coupons.view',
//                 'permission' => has_permission('admin.coupons.view'),
//             ],
//             'Blog' => [
//                 'icon' => 'notebook-text',
//                 'permission' => has_permissions(['admin.blog.categories.view', 'admin.blog.posts.view']),
//                 'Posts' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.blog.posts.view',
//                     'permission' => has_permission('admin.blog.posts.view'),
//                 ],
//                 'Categories' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.blog.categories.view',
//                     'permission' => has_permission('admin.blog.categories.view'),
//                 ],

//             ],
//             'Settings' => [
//                 'icon' => 'settings',
//                 'permission' => has_permissions(['admin.settings.general', 'admin.settings.home', 'admin.settings.about', 'admin.settings.team', 'admin.settings.testimonials', 'admin.settings.privacy', 'admin.settings.terms', 'admin.settings.faq']),
//                 'General' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.settings.general',
//                     'permission' => has_permission('admin.settings.general'),
//                 ],
//                 'Home Page' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.settings.home',
//                     'permission' => has_permission('admin.settings.home'),
//                 ],
//                 'About Page' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.settings.about',
//                     'permission' => has_permission('admin.settings.about'),
//                 ],
//                 'Team' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.settings.team',
//                     'permission' => has_permission('admin.settings.team'),
//                 ],
//                 'Testimonials' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.settings.testimonials',
//                     'permission' => has_permission('admin.settings.testimonials'),
//                 ],
//                 'Privacy Policy' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.settings.privacy',
//                     'permission' => has_permission('admin.settings.privacy'),
//                 ],
//                 'Terms & Conditions' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.settings.terms',
//                     'permission' => has_permission('admin.settings.terms'),
//                 ],
//                 'FAQ' => [
//                     'icon' => 'circle',
//                     'route' => 'admin.settings.faq',
//                     'permission' => has_permission('admin.settings.faq'),
//                 ],
//             ],
//         ];
//     }
// }

if (! function_exists('get_route_lists')) {
    function get_route_lists()
    {
        $routes = Route::getRoutes()->getRoutes();
        $lists = [];
        foreach ($routes as $route) {
            $name = $route->getName();
            $action = $route->getAction();

            // Skip routes without a name or controller
            if (! $name || ! isset($action['controller']) || str_contains($action['controller'], 'LoginController')) {
                continue;
            }

            // Only process admin routes (optional filter)
            if (! str_starts_with($name, 'admin.')) {
                continue;
            }

            // Extract controller name: "App\Http\Controllers\UserController@index" → "User"
            $controllerClass = explode('@', $action['controller'])[0];
            $controllerShortName = class_basename($controllerClass);                  // "UserController"
            $controllerKey = str_replace('Controller', '', $controllerShortName);     // "User"

            // Extract last segment of route name: "admin.users.createPage" → "view"
            $routeKey = last(explode('.', $name));                                    // "view"

            $lists[$controllerKey][$routeKey] = $name;
        }

        return $lists;
    }
}
if (! function_exists('is_multidimensional_array')) {
    function is_multidimensional_array(array $array): bool
    {
        foreach ($array as $value) {
            if (is_array($value)) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('is_active_sidebar')) {
    function is_active_sidebar($menuItems)
    {
        $route_name = request()->route()?->getName();
        foreach ($menuItems as $key => $value) {
            if (isset($value['route']) && $route_name === $value['route']) {
                return 'block';
            }
        }

        return 'hidden';
    }
}
if (! function_exists('is_active_menu')) {
    function is_active_menu($routeName)
    {
        $currentRoute = request()->route()?->getName();

        return $currentRoute === $routeName ? 'bg-gray-100 dark:bg-gray-700' : '';
    }
}
// Is permission exist in role permissions
if (! function_exists('has_permission')) {
    function has_permission($permission)
    {
        $permissions = explode(',', Auth::user()->Role?->permissions ?? '');

        return in_array($permission, $permissions);
    }
}
if (! function_exists('has_permissions')) {
    function has_permissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (has_permission($permission)) {
                return true;
            }
        }

        return false;
    }
}
// upload image and return path
if (! function_exists('upload_file')) {

    function upload_file($file, $folder = 'images', $image_name = null)
    {

        // Base upload path
        $basePath = public_path("storage/uploads/{$folder}");

        // Ensure directory exists
        if (! File::exists($basePath)) {
            File::makeDirectory($basePath, 0755, true);
        }

        // Generate unique file name
        if ($image_name) {
            $image_name = Str::slug($image_name);
            $webpFileName = "{$image_name}.webp";
            $counter = 1;
            while (File::exists("{$basePath}/{$webpFileName}")) {
                $webpFileName = "{$image_name}-{$counter}.webp";
                $counter++;
            }
        } else {
            $webpFileName = Str::uuid().'.webp';
        }

        // Save as WebP directly
        Image::load($file->getPathname())
            ->format('webp')
            ->quality(80)
            ->save("{$basePath}/{$webpFileName}");

        $webpPath = "storage/uploads/{$folder}/{$webpFileName}";

        return asset($webpPath);
    }
}
if (! function_exists('translate')) {
    function translate(string $key): string
    {
        return app(TranslationService::class)->translate($key);
    }
}
if (! function_exists('delete_files')) {
    function delete_files(array $files, array $exclude = []): void
    {
        if (! empty($files) && is_array($files)) {
            foreach ($files as $key => $file) {
                if (is_string($file) && Str::startsWith($file, asset(''))) {
                    // Skip if this file is listed in the exclude array.
                    $relative = str_replace(asset(''), '', $file);
                    $basename = basename($file);
                    $shouldSkip = false;
                    foreach ($exclude as $ex) {
                        if (! is_string($ex)) {
                            continue;
                        }

                        if ($ex === $file || $ex === $relative || $ex === $basename) {
                            $shouldSkip = true;
                            break;
                        }
                    }

                    if ($shouldSkip) {
                        continue;
                    }

                    $filePath = str_replace(asset(''), public_path('/'), $file);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
            }
        }
    }
}
if (! function_exists('show_image')) {
    function show_image($images, $size = '400x400', string $type = 'webp'): string
    {
        if (is_array($images) && isset($images[$type])) {
            return $images[$type];
        }

        return asset("assets/placeholder/{$size}.png");
    }
}
if (! function_exists('GetSetting')) {
    function GetSetting($key)
    {
        return app(SettingService::class)->get($key);
    }
}
if (! function_exists('GetSettingsGroup')) {
    function GetSettingsGroup($key)
    {
        return app(SettingService::class)->getGroup($key);
    }
}
if (! function_exists('rename_uploaded_image')) {
    function rename_uploaded_image(array $images, string $newName): array
    {
        if (empty($images) || ! is_array($images)) {
            return $images;
        }

        $updated = $images;
        $slug = Str::slug($newName);

        foreach (['original', 'webp'] as $type) {
            if (! isset($images[$type]) || ! is_string($images[$type]) || ! Str::startsWith($images[$type], asset(''))) {
                continue;
            }

            $relative = str_replace(asset(''), '', $images[$type]);
            $absolute = public_path($relative);

            if (! File::exists($absolute)) {
                continue;
            }

            $dir = pathinfo($absolute, PATHINFO_DIRNAME);
            $ext = pathinfo($absolute, PATHINFO_EXTENSION);

            $newBase = "{$slug}.{$ext}";
            $counter = 1;

            while (File::exists($dir.DIRECTORY_SEPARATOR.$newBase)) {
                $newBase = "{$slug}-{$counter}.{$ext}";
                $counter++;
            }

            $newAbsolute = $dir.DIRECTORY_SEPARATOR.$newBase;
            File::move($absolute, $newAbsolute);

            $publicPath = str_replace('\\', '/', public_path());
            $newRelative = str_replace('\\', '/', $newAbsolute);
            $newRelative = str_replace($publicPath, '', $newRelative); // strip public path first
            $newRelative = preg_replace('/\/+/', '/', $newRelative);   // then clean up slashes
            $newRelative = asset(ltrim($newRelative, '/'));             // ensure no leading slash
            $updated[$type] = $newRelative;
        }
        // dd($updated);

        return $updated;
    }
}
