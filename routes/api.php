<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

use App\Http\Middleware\EnsureAdminRole; // Assuming you've created this middleware

// Public Routes (No Authentication Needed)
Route::group([], function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{product}', [ProductController::class, 'show']); // Allow viewing products without login
    Route::apiResource('categories', CategoryController::class)->only(['index', 'show']); // Only index & show for public
    Route::get('categories-with-products', [CategoryController::class, 'categoriesWithProducts']);
    Route::get('categories-with-products/{id}', [CategoryController::class, 'categoryWithProducts']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
});


// Protected Routes (Authentication Required)

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
    Route::get('/user', [UserController::class, 'user']);
    Route::apiResource('users', UserController::class)->only(['update']); // Allow updating user profile
    Route::apiResource('orders', OrderController::class);
    Route::get('orders-by-user', [OrderController::class, 'getOrdersByUserId']);
    Route::get('orders-with-products', [OrderController::class, 'withProducts']);
    Route::get('confirm-order/{id}', [OrderController::class, 'confirmOrder']);


    Route::middleware(['ensureAdminRole'])->group(function () { // Add the middleware here
        Route::apiResource('products', ProductController::class)->except(['index', 'show']); 
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']); 
        // ... other admin-only routes ...
    });
});
