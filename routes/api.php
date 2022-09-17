<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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


Route::prefix('customer')->controller(AuthController::class)->group(function(){
    //authentification routes
    Route::middleware('guestSanctum')->group(function () {
        Route::post('/register', 'registerUser');
        Route::post('/login', 'loginUser');
        Route::get('/forgetpassword', function(Request $request){
            $status = Password::sendResetLink(
                $request->only('email')
            );
         
            return $request->only('email');
            });
        });

   Route::post('/logout', 'logoutUser')->middleware("auth:sanctum");
});