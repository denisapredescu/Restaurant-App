<?php

use App\Http\Controllers\DishController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDishController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('dishes', DishController::class);

Route::apiResource('orders', OrderController::class);
Route::prefix('orders/{order}')->group(function(){
    Route::apiResource('dishes', OrderDishController::class);
//    Route::get("dishes", [OrderDishController::class, 'index']);
//    Route::post("dishes", [OrderDishController::class, 'store']);
//    Route::get("dishes/{dish}", [OrderDishController::class, 'show']);
//    Route::put("dishes/{dish}", [OrderDishController::class, 'update']);
//    Route::delete("dishes/{dish}", [OrderDishController::class, 'destroy']);
});

//    Route::post("orders/{order}", [OrderDishController::class, 'storeUsingId']);
Route::post("orders/{order}/pay", [OrderController::class, 'pay']);
