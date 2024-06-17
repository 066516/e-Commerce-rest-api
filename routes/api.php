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

Route::get('products', [ProductController::class, 'index']);
Route::post('products', [ProductController::class, 'store']);
Route::get('products/{product}', [ProductController::class, 'show']);
Route::put('products/{product}', [ProductController::class, 'update']);
Route::patch('products/{product}', [ProductController::class, 'update']);
Route::delete('products/{product}', [ProductController::class, 'destroy']);
Route::apiResource('categories', CategoryController::class);
Route::get('categories-with-products', [CategoryController::class, 'categoriesWithProducts']);
Route::get('categories-with-products/{id}', [CategoryController::class, 'categoryWithProducts']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
// Route::get('/user', [UserController::class, 'me']);
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'user']);
Route::apiResource('users', UserController::class);

Route::middleware('auth:sanctum')->apiResource('orders', OrderController::class);
Route::middleware('auth:sanctum')->get('orders-by-user', [OrderController::class,'getOrdersByUserId']);
Route::get('orders-with-products', [OrderController::class,'withProducts' ]);
route::get('confirem-order/{id}', [OrderController::class,'confiremOrderController' ]);
 