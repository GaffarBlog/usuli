<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'AdminMiddleware'])->prefix('admin')->group(function () {

    // Mange login page
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'index')->name('admin.login.index');
        Route::post('/login', 'login')->name('admin.login.post');
    });

    // User management routes
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('admin.users.view');
        Route::get('/users/create', 'create')->name('admin.users.createPage');
        Route::post('/users/create', 'create_user')->name('admin.users.create');
        Route::get('/users-edit/{id}', 'edit')->name('admin.users.edit');
        Route::post('/users-update', 'update')->name('admin.users.update');
        Route::post('/users-delete', 'delete')->name('admin.users.delete');
        Route::post('/users-bulk-delete', 'bulkDelete')->name('admin.users.bulkDelete');
    });
    // User roles and permissions routes
    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles', 'index')->name('admin.roles.view');
        Route::get('/roles/create', 'create_page')->name('admin.roles.createPage');
        Route::post('/roles/create', 'create')->name('admin.roles.create');
        Route::post('/roles/status', 'change_status')->name('admin.roles.status');
        Route::get('/roles-edit/{id}', 'edit')->name('admin.roles.edit');
        Route::post('/roles-update', 'update')->name('admin.roles.update');
        Route::post('/roles-delete', 'delete')->name('admin.roles.delete');
    });

    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permission/{role_id}', 'index')->name('admin.permissions.view');
        Route::post('/permissions', 'update')->name('admin.permissions.update');
        Route::get('/permissions/routes', 'update_routes')->name('admin.permissions.update_routes');
    });

    // Dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('admin.dashboard.view');
        Route::get('/logout', 'logout')->name('admin.logout');
    });

    // Profile
    Route::controller(ProfileController::class)->prefix('profile')->name('admin.profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
        Route::put('/password', 'updatePassword')->name('password');
    });

    // Settings
    Route::controller(SettingController::class)->prefix('settings')->name('admin.settings.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/', 'update')->name('update');
    });

    // Route::get('/', [DashboardController::class, '__invoke'])->name('admin.dashboard');

    // Posts
    Route::controller(PostController::class)->prefix('posts')->name('admin.posts.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{post}/edit', 'edit')->name('edit');
        Route::put('/{post}', 'update')->name('update');
        Route::delete('/{post}', 'destroy')->name('destroy');
    });

    // Categories
    Route::controller(CategoryController::class)->prefix('categories')->name('admin.categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{category}/edit', 'edit')->name('edit');
        Route::put('/{category}', 'update')->name('update');
        Route::delete('/{category}', 'destroy')->name('destroy');
    });
});
