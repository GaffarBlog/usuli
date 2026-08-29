<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/admin', DashboardController::class)->name('admin.dashboard');

    Route::resource('admin/categories', CategoryController::class)
        ->parameters(['admin/categories' => 'category'])
        ->names('admin.categories');

    Route::resource('admin/posts', PostController::class)
        ->parameters(['admin/posts' => 'post'])
        ->names('admin.posts');
});
