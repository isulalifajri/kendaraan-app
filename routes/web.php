<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PersetujuanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    // login
    Route::get('login',[LoginController::class,'index'])->name('login');
    Route::post('login/authenticate',[LoginController::class,'authenticate'])->name('login.authenticate');
   
});

// logout
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

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

    Route::prefix('driver')->name('driver.')->group(function () {
        Route::get('/', [DriverController::class, 'index'])
            ->name('index');
        Route::get('/create', [DriverController::class, 'create'])
            ->name('create');
        Route::post('/', [DriverController::class, 'store'])
            ->name('store');
        Route::get('/{user}/edit', [DriverController::class, 'edit'])
            ->name('edit');
        Route::put('/{user}', [DriverController::class, 'update'])
            ->name('update');
        Route::delete('/{user}', [DriverController::class, 'destroy'])
            ->name('destroy');
    });
});

// pemesanan
Route::prefix('pemesanan')->name('pemesanan.')->group(function () {
    Route::get('/', [PemesananController::class, 'index'])
        ->name('index');

    Route::get('/create', [PemesananController::class, 'create'])
        ->name('create');

    Route::post('/', [PemesananController::class, 'store'])
        ->name('store');

    Route::get('/{pemesanan}/edit', [PemesananController::class, 'edit'])
        ->name('edit');

    Route::put('/{pemesanan}', [PemesananController::class, 'update'])
        ->name('update');

    Route::delete('/{pemesanan}', [PemesananController::class, 'destroy'])
        ->name('destroy');
});

// persetujuan
Route::prefix('approval')->name('approval.')->group(function () {

    Route::get('/', [PersetujuanController::class, 'index'])->name('index');

    Route::put('/{id}/approve-l1', [PersetujuanController::class, 'approveL1'])->name('approveL1');
    Route::put('/{id}/approve-l2', [PersetujuanController::class, 'approveL2'])->name('approveL2');
    Route::put('/{id}/reject', [PersetujuanController::class, 'reject'])->name('reject');

});