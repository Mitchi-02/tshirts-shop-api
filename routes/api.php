<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
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


Route::prefix('customer')->group(function(){
    //authentification end points
    Route::controller(AuthController::class)->group(function(){
        Route::middleware('guestSanctum')->group(function () {
            Route::post('/register', 'registerUser');
            Route::post('/login', 'loginUser');
        });
        Route::post('/logout', 'logoutUser')->middleware("auth:sanctum");
    });

    Route::controller(UserController::class)->middleware('auth:sanctum')->group(function(){
        Route::post('/update/password', 'updatePassword');
    });

    
    Route::controller(VerificationController::class)->group(function(){

        //reset password end points
        Route::prefix('forgetpassword')->middleware('guestSanctum')->group(function(){
            Route::post('/', 'sendPasswordCode');
            Route::post('/resend', 'sendPasswordCode');
            Route::post('/verify', 'verifyPasswordCode');
            Route::post('/reset', 'resetUserPassword');
        });

        //reset password end points
        Route::prefix('verifyemail')->middleware('auth:sanctum')->group(function(){
            Route::post('/resend', 'resendEmailVerification');
            Route::post('/verify', 'verifyEmailVerifCode');
        });
            
    });

    Route::controller(ProductController::class)->middleware('auth:sanctum')->group(function(){
        Route::get('/home', 'getAllProducts');
    });

    Route::controller(OrderController::class)->middleware('auth:sanctum')->group(function(){
        Route::post('/order', 'createOrder');
        Route::get('/myorders', 'getAuthOrders');
    });
});