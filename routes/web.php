<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout']);
});

Route::middleware(\App\Http\Middleware\ChecAdmin::class)->group(function () {
    Route::prefix('admin')->group(function () {
//        Категории
        Route::get('/categories', [AdminCategoryController::class, 'index']);
        Route::get('/categories/{category}/update', [AdminCategoryController::class, 'showUpdateForm']);
        Route::post('/categories', [AdminCategoryController::class, 'store']);
        Route::patch('/categories/{category}', [AdminCategoryController::class, 'update']);
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy']);

//        Товары
        Route::get('/products', [AdminProductController::class, 'index']);
        Route::get('/products/{product}/update', [AdminProductController::class, 'showUpdateForm']);
        Route::post('/products', [AdminProductController::class, 'store']);
        Route::patch('/products/{product}', [AdminProductController::class, 'update']);
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy']);

        Route::get('/categories/{category}/products', [AdminProductController::class, 'getCategoryProducts']);

//        Заказы
        Route::get('/orders', [AdminOrderController::class, 'index']);
    });
});

