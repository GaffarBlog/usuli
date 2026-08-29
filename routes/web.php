<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home.index');
        Route::get('/blog', 'blog')->name('blog');
    });

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
});
