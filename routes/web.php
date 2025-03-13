<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PostController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/secret', function () {
        return 'ADMIN ONLY PAGE';
    });
});

Route::get('test', [TestController::class, 'test'])->name('test');

Route::get('post/create', [PostController::class, 'create'])->middleware('admin');

Route::post('post', [PostController::class, 'store'])->name('post.store');

Route::get('post', [PostController::class, 'index'])->middleware('admin');

require __DIR__.'/auth.php';