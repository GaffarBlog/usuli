<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home.index');
        Route::get('/blog', 'blog')->name('blog');
        Route::get('/blog/{post:slug}', 'show')->name('blog.show');
        Route::get('/contact', 'contact')->name('contact');
    });

    Route::controller(AuthController::class)->middleware('guest:frontend')->group(function () {
        Route::get('/login', 'showLogin')->name('frontend.login');
        Route::post('/login', 'login')->name('frontend.login.post');
        Route::get('/register', 'showRegister')->name('frontend.register');
        Route::post('/register', 'register')->name('frontend.register.post');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('frontend.logout')->middleware('auth:frontend');
});
