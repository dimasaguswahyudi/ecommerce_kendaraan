<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\frontstore\CheckoutController;
use App\Http\Controllers\frontstore\HomepageController;


Route::name('frontstore.')->group(function () {
   Route::controller(HomepageController::class)->group(function () {
        Route::get('/', 'index')->name('homepage');
        Route::get('/filter', 'filter')->name('filter');
        Route::get('/chart', 'chart')->name('chart');
        Route::post('/cart/show', 'cartShow')->name('cart.show');
   });
});


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('banner')->name('banner.')->controller(BannerController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::delete('{banner}', 'destroy')->name('destroy');
        Route::delete('destroy/all', 'destroyAll')->name('destroyAll');
    });

    Route::resources([
        'category' => CategoryController::class,
        'discount' => DiscountController::class,
        'product' => ProductController::class,
        'order' => OrderController::class
    ]);
});

require __DIR__.'/auth.php';
