<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Web\AuthController;
use App\Http\Controllers\Api\Web\ProtectedController;
use App\Http\Controllers\Api\Web\RoleController;
use App\Http\Controllers\Api\Web\PermissionController;
use App\Http\Controllers\Api\Web\UserController;

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

Route::middleware('auth:sanctum')->get('v2/me', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('v2/admin', [ProtectedController::class, 'admin']);

    // route resource for role
    // Route::resource('role', RoleController::class)->names('role');
    Route::prefix('/v2')->group(function () {
        Route::resource('role', RoleController::class)->names('role');

        // user
        Route::resource('user', UserController::class)->names('user');
    });

    // route for permission
    Route::get('v2/permission', [PermissionController::class, 'index']);
});

Route::prefix('v2')->group(function () {
    // ...
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});


