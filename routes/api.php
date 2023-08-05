<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Web\AuthController;
use App\Http\Controllers\Api\Web\ProtectedController;
use App\Http\Controllers\Api\Web\RoleController;
use App\Http\Controllers\Api\Web\PermissionController;
use App\Http\Controllers\Api\Web\UserController;
use App\Http\Controllers\Api\Web\VendorLimitController;
use App\Http\Controllers\Api\Web\VendorGradeController;
use App\Http\Controllers\Api\Web\VendorController;
use App\Http\Controllers\Api\Web\ProductCategoryController;
use App\Http\Controllers\Api\Web\ProductAttributeController;
use App\Http\Controllers\Api\Web\ProductVariantController;
use App\Http\Controllers\Api\Web\ChecklistItemController;

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

Route::middleware(['auth:sanctum', 'role:Super Admin'])->group(function () {
    Route::get('v2/admin', [ProtectedController::class, 'admin']);

    // route resource for role
    // Route::resource('role', RoleController::class)->names('role');
    Route::prefix('/v2')->group(function () {
        Route::resource('role', RoleController::class)->names('role');

        // user
        Route::resource('user', UserController::class)->names('user');

        // vendor limit
        Route::resource('vendor-limit', VendorLimitController::class)->names('vendor-limit');

        // vendor grade
        Route::resource('vendor-grade', VendorGradeController::class)->names('vendor-grade');

        // vendor
        Route::resource('vendor', VendorController::class)->names('vendor');

        // product category
        Route::resource('product-category', ProductCategoryController::class)->names('product-category');

        // product attribute
        Route::resource('product-attribute', ProductAttributeController::class)->names('product-attribute');

        // product variant
        Route::resource('product-variant', ProductVariantController::class)->names('product-variant');

        // checklist item
        Route::resource('checklist-item', ChecklistItemController::class)->names('checklist-item');
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


