<?php

use App\Http\Controllers\CartOrderController;
use App\Http\Controllers\PersonalAreaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//PRIVATE CHECKS POSTMAN
Route::get('/all-users', [UserController::class, 'index']);
Route::post('/add-user', [UserController::class, 'store']);
Route::put('/update-user/{id}',[UserController::class,'update']);
Route::delete('/delete-user/{id}',[UserController::class,'destroy']);

//LOGIN
Route::post('/login-user', [UserController::class, 'checkUserExists']);
//REGISTER
Route::post('/registration-user', [UserController::class, 'create']);
//PERSONAL AREA VIEW
Route::get('/view-info', [PersonalAreaController::class, 'view']);


Route::get('/products',[ProductController::class,'index']);
Route::post('/products',[ProductController::class,'store']);
Route::put('/products/{id}',[ProductController::class,'update']);
Route::delete('/products/{id}',[ProductController::class,'destroy']);
Route::get('/products/{id}',[ProductController::class,'show']);


//CART 
Route::get('/cartProducts/{id}', [CartController::class, 'index']);
Route::post('/addCartProduct', [CartController::class, 'store']);
Route::delete('/cartProducts/{id}', [CartController::class, 'destroy']);
Route::put('/cartProducts/{id}', [CartController::class, 'update']);


//ORDERS

Route::get('/ordersList/{id}', [OrdersController::class, 'index']);
Route::delete('/ordersList/{id}', [OrdersController::class, 'destroy']);
Route::post('/addCartToOrders', [OrdersController::class, 'store']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
