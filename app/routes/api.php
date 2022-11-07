<?php

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
Route::prefix('v1')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
    });

    Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'store']);
    Route::get('/activate-account', [\App\Http\Controllers\Auth\ActivationController::class, 'activateAccount'])->name('auth.activate_account');
    Route::post('/resend-activation-link', [\App\Http\Controllers\Auth\ActivationController::class, 'resendActivationEmail']);
});
