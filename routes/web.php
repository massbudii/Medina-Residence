<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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
    Route::prefix('type')->group(function(){

     Route::get('/data-type', [TypeController::class, 'index'])->name('type.index');
     
    });


});
