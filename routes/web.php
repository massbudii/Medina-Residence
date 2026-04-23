<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KawasanController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'check_role:admin,mandor']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    //user
    Route::prefix('user')->group(function () {

        Route::get('/data-user', [UserController::class, 'index'])->name('user.index');
        Route::post('/data-user', [UserController::class, 'store'])->name('user.store');

        Route::put('/user/{id}/update', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}/delete', [UserController::class, 'destroy'])->name('user.destroy');

        Route::post('/user/{id}/aktif', [UserController::class, 'aktif'])->name('user.aktif');
        Route::post('/user/{id}/nonaktif', [UserController::class, 'nonaktif'])->name('user.nonaktif');
    });

    // type
    Route::prefix('type')->group(function () {

        Route::get('/data-type', [TypeController::class, 'index'])->name('type.index');
        Route::get('/data-type/create', [TypeController::class, 'create'])->name('type.create');
        Route::post('/data-type/store', [TypeController::class, 'store'])->name('type.store');
        Route::put('/data-type/{id}/update', [TypeController::class, 'update'])->name('type.update');
        Route::delete('/data-type/{id}/delete', [TypeController::class, 'destroy'])->name('type.delete');
    });

    // kawasan
    Route::prefix('kawasan')->group(function () {

        Route::get('/kawasan', [KawasanController::class, 'index'])->name('kawasan.index');
        Route::post('/kawasan', [KawasanController::class, 'store'])->name('kawasan.store');
        Route::put('/kawasan/{id}/update', [KawasanController::class, 'update'])->name('kawasan.update');
        Route::delete('/kawasan/{id}/delete', [KawasanController::class, 'destroy'])->name('kawasan.delete');
        Route::post('/{id}/aktif', [KawasanController::class, 'aktif'])->name('kawasan.aktif');
        Route::post('/{id}/selesai', [KawasanController::class, 'selesai'])->name('kawasan.selesai');
    });


    Route::prefix('supplier')->group(function () {
        Route::get('/data-supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::put('/suplier/{id}/update', [SupplierController::class, 'update'])->name('supplier.update');

        Route::post('/supplier/{id}nonaktif', [SupplierController::class, 'nonaktif'])->name('supplier.nonaktif');
        Route::post('/supplier/{id}/aktif', [SupplierController::class, 'aktif'])->name('supplier.aktif');

        Route::delete('/supplier/{id}/delete', [SupplierController::class, 'destroy'])->name('supplier.delete');
    });

    Route::prefix('supplier')->group(function () {
       Route::get('/data-supplier', [MaterialController::class, 'index'])->name('material.index');
    });


});
