<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\UmkmProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show.public');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Dashboard redirect based on role
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // UMKM Management
    Route::resource('umkm', UmkmController::class);

    // Category Management
    Route::resource('categories', CategoryController::class);

    // Product Management
    Route::resource('products', ProductController::class);
});

/*
|--------------------------------------------------------------------------
| UMKM Owner Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'umkm.owner'])->prefix('umkm-panel')->name('umkm-panel.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'umkm'])->name('dashboard');

    // Product Management
    Route::resource('products', UmkmProductController::class);
});

// Alias for umkm dashboard
Route::middleware(['auth', 'umkm.owner'])->get('/umkm/dashboard', [DashboardController::class, 'umkm'])->name('umkm.dashboard');
