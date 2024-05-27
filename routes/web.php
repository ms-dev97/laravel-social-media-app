<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Update user cover
    Route::post('/profile/update-cover', [ProfileController::class, 'updateCover'])->name('profile.updateCover');
    // Update user avatar
    Route::post('/profile/update-avatar', [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');

    // create post
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    // update post
    Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update');
});

Route::get('/u/{user:username}', [ProfileController::class, 'index'])->name('profile.index');

require __DIR__.'/auth.php';
