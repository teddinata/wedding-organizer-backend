<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProtectedController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserController;

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

Route::post('v2/login', [AuthController::class, 'login']);
Route::post('v2//logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
