<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'check_role:admin,mandor']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/data-user', [UserController::class, 'index'])->name('user.index');
    Route::post('/data-user', [UserController::class, 'store'])->name('user.store');

    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');

    Route::post('/user/{id}/nonaktif', [UserController::class, 'nonaktif'])->name('user.nonaktif');
});
