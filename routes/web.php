<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home.index');
        Route::get('/about', 'about')->name('about');
        Route::get('/blog', 'blog')->name('blog');
        Route::get('/blog/{post:slug}', 'show')->name('blog.show');
    });

    Route::controller(ContactController::class)->group(function () {
        Route::get('/contact', 'index')->name('contact');
        Route::post('/contact', 'store')->name('contact.store');
    });

    Route::post('/blog/{post:slug}/comment', [CommentController::class, 'store'])
        ->name('blog.comment.store')
        ->middleware('auth:frontend');

    Route::controller(AuthController::class)->middleware('guest:frontend')->group(function () {
        Route::get('/login', 'showLogin')->name('frontend.login');
        Route::post('/login', 'login')->name('frontend.login.post');
        Route::get('/register', 'showRegister')->name('frontend.register');
        Route::post('/register', 'register')->name('frontend.register.post');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('frontend.logout')->middleware('auth:frontend');

    Route::middleware(['auth:frontend'])->prefix('dashboard')->name('frontend.dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/profile', [DashboardController::class, 'editProfile'])->name('profile');
        Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::post('/password', [DashboardController::class, 'updatePassword'])->name('password.update');
        Route::get('/writer', [DashboardController::class, 'writerRequest'])->name('writer');
        Route::post('/writer', [DashboardController::class, 'submitWriterRequest'])->name('writer.submit');
    });
});
