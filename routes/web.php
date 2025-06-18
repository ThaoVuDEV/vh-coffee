<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

include 'admin.php';
Route::get('/login.html', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware([\App\Http\Middleware\RedirectIfNotAuthenticated::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
