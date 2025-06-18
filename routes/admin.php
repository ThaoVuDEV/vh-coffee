<?php
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

    Route::name('admin.')->prefix('quan-ly')->group(function () {
        Route::get('/dashboard.html', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/category.html', [AdminController::class, 'categories'])->name('categories');
        Route::get('/product.html', [AdminController::class, 'product'])->name('product');
        Route::get('/tables', [AdminController::class,'table'])->name('tables');
        Route::get('/ingredient', [AdminController::class,'ingredients'])->name('ingredients');
        Route::get('/supplier', [AdminController::class,'suppliers'])->name('suppliers');
    });

