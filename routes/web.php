<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;

// ==================
// ROUTE UMUM (Public)
// ==================

Route::get('/', fn() => redirect()->route('products.public.index'));

// PUBLIC
Route::get('/products-public', [ProductController::class, 'showAll'])->name('products.public.index');
Route::get('/products-public/{product}', [ProductController::class, 'show'])->name('products.public.show');

//feedbacks
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/admin/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
Route::patch('/admin/feedback/{feedback}', [FeedbackController::class, 'updateStatus'])->name('feedback.updateStatus');

// ======================
// ROUTE YANG BUTUH LOGIN
// ======================

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    // DASHBOARD pribadi (jika memang perlu)

    // PROFILE user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PRODUK (admin/user login saja)

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/product-images/{image}', [ProductController::class, 'deleteImage'])->name('product-images.destroy');
    Route::get('/my-products', [ProductController::class, 'myProducts'])->name('products.my');

    //favorites
    Route::get('/wishlist', [FavoriteController::class, 'index'])
        ->name('favorites.index')
        ->middleware('auth');
    Route::post('/favorites/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    Route::middleware(['auth', 'admin'])->group(function () {
        // KATEGORI (admin/user login saja)
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        //users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });
});

require __DIR__ . '/auth.php';
