<?php

use App\Http\Controllers\Api\v1\ApiBusinessesController;
use App\Http\Controllers\Api\v1\ApiMenuItemController;
use App\Http\Controllers\Api\v1\ApiOrdersController;
use App\Http\Controllers\Api\v1\ApiRestaurantsController;
use App\Http\Controllers\Api\v1\ApiUserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('user-create', [ApiUserController::class, 'createUser']);
Route::post('user-login', [ApiUserController::class, 'login']);

Route::group(['middleware' => ['dbTransaction', 'jwt.verify']], function () {
    Route::prefix('users')->group(function (){
        Route::get('', [ApiUserController::class, 'getUsers']);

        Route::prefix('{user}/businesses')->group(function (){
            Route::get('', [ApiBusinessesController::class, 'getBusiness']);
            Route::post('', [ApiBusinessesController::class, 'createBusiness']);
        });

        Route::prefix('{user}/orders')->group(function (){
            Route::get('', [ApiOrdersController::class, 'getOrdersByCustomer']);
        });
    });

    Route::prefix('businesses')->group(function (){
        Route::prefix('{business}/restaurants')->group(function (){
            Route::get('', [ApiRestaurantsController::class, 'getRestaurants']);
            Route::post('', [ApiRestaurantsController::class, 'createRestaurant']);
        });
    });

    Route::prefix('restaurants')->group(function (){
        Route::prefix('{restaurant}')->group(function (){
            Route::prefix('menu-items')->group(function (){
                Route::get('', [ApiMenuItemController::class, 'getMenuItems']);
                Route::post('', [ApiMenuItemController::class, 'createMenuItem']);
            });

            Route::prefix('orders')->group(function (){
                Route::get('', [ApiOrdersController::class, 'getOrders']);
                Route::post('', [ApiOrdersController::class, 'createOrder']);
            });
        });
    });
});

