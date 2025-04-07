<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController as ApiCategoryController;
use App\Http\Controllers\API\ProductController as ApiProductController;
use App\Http\Controllers\API\OrderController as ApiOrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//user
Route::post('/registration', [AuthController::class, 'registration']);
Route::post('/auth', [AuthController::class, 'auth']);

//categories
Route::get('/categories', [ApiCategoryController::class, 'index']);

//products
Route::get('/categories/{category}/products', [ApiProductController::class, 'index']);
Route::get('/products/{product}', [ApiProductController::class, 'show']);

//webhook - orders
Route::post('/payment-webhook', [ApiOrderController::class, 'update']);

//orders
Route::middleware(\App\Http\Middleware\ChecToken::class)->group(function () {
    Route::post('/products/{product}/buy', [ApiOrderController::class, 'store']);
    Route::get('/orders', [ApiOrderController::class, 'index']);
});


