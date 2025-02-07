<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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

    Route::prefix('banner')->name('banner')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('.index'); 
    });

});

require __DIR__.'/auth.php';
