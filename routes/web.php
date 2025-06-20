<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Models\Category;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    $products = Product::with('category')->latest()->get();
    $categories = Category::all();
    return view('dashboard', compact('products', 'categories'));
})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Tampilkan daftar produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Form tambah produk
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Simpan produk baru
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::middleware(['auth'])->group(function () {

    // Form edit produk
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::delete('/product-images/{image}', [ProductController::class, 'deleteImage'])->name('product-images.destroy');


    // Update produk
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    // Hapus produk
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

});




require __DIR__.'/auth.php';
