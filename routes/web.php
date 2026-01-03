<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StorageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('storage/images/products/{filename}', [StorageController::class, 'getProductImage'])->name('product.images');

    Route::middleware('verified')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'view'])->name('view');
            Route::post('/add-item', [CartController::class, 'addItem'])->name('add-item');
            Route::post('/update-item', [CartController::class, 'updateItem'])->name('update-item');
            Route::post('/remove-item', [CartController::class, 'removeItem'])->name('remove-item');
        });

        Route::get('/settings', [SettingsController::class, 'edit'])->middleware('role:admin')->name('settings.edit');
        Route::patch('/settings', [SettingsController::class, 'update'])->middleware('role:admin')->name('settings.update');
    });
});

require __DIR__.'/auth.php';
