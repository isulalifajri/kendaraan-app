<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class,'index'])->name('dashboard');

Route::prefix('masterData')->group(function () {
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->name('index');
        Route::get('/create', [UserController::class, 'create'])
            ->name('create');
        Route::post('/', [UserController::class, 'store'])
            ->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])
            ->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])
            ->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])
            ->name('destroy');
    });
    Route::prefix('kendaraan')->name('kendaraan.')->group(function () {
        Route::get('/', [KendaraanController::class, 'index'])
            ->name('index');
        Route::get('/create', [KendaraanController::class, 'create'])
            ->name('create');
        Route::post('/', [KendaraanController::class, 'store'])
            ->name('store');
        Route::get('/{user}/edit', [KendaraanController::class, 'edit'])
            ->name('edit');
        Route::put('/{user}', [KendaraanController::class, 'update'])
            ->name('update');
        Route::delete('/{user}', [KendaraanController::class, 'destroy'])
            ->name('destroy');
    });
});