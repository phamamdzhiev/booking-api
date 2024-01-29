<?php

use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::group(
    [
        'prefix' => 'v1',
        'namespace' => '\App\Http\Controllers\Api\V1',
        'middleware' => 'auth:sanctum'
    ],
    function () {
        Route::apiResource('rooms', RoomController::class);
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('bookings', BookingController::class);
        Route::apiResource('payments', PaymentController::class, ['only' => ['show', 'index', 'store']]);
    }
);

Route::post('login', function () {

    $credentials = [
        'email' => 'admin@admin.com',
        'password' => 'admin'
    ];

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        $token = $user->createToken('token', ['create', 'update']);
        return response()->json($token->plainTextToken);
    }

    return response()->json('Provided credentials do not match our records', 401);
});
