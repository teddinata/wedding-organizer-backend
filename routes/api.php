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
use App\Http\Controllers\Api\Web\MembershipController;
use App\Http\Controllers\Api\Web\MembershipBenefitController;
use App\Http\Controllers\Api\Web\ProductCategoryController;
use App\Http\Controllers\Api\Web\ProductAttributeController;
use App\Http\Controllers\Api\Web\ProductVariantController;
use App\Http\Controllers\Api\Web\ChecklistItemController;
use App\Http\Controllers\Api\Web\DepartmentController;
use App\Http\Controllers\Api\Web\PositionController;
use App\Http\Controllers\Api\Web\AllowanceController;
use App\Http\Controllers\Api\Web\EmployeeController;
use App\Http\Controllers\Api\Web\LevelController;
use App\Http\Controllers\Api\Web\AttendanceController;
use App\Http\Controllers\Api\Web\TeamController;
use App\Http\Controllers\Api\Web\TeamLoanController;
use App\Http\Controllers\Api\Web\OrderController;
use App\Http\Controllers\Api\Web\OrderProductController;
use App\Http\Controllers\Api\Web\DecorationAreaController;
use App\Http\Controllers\Api\Web\OrderTeamController;
use App\Http\Controllers\Api\Web\SalesController;

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

// Route::middleware(['auth:sanctum', 'role:Super Admin'])->group(function () {
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('v2/admin', [ProtectedController::class, 'admin']);

    // route resource for role
    // Route::resource('role', RoleController::class)->names('role');
    Route::prefix('/v2')->group(function () {
        Route::post('/edit-profile', [AuthController::class, 'editProfile'])->name('edit-profile');

        Route::resource('role', RoleController::class)->names('role');

        // user
        Route::resource('user', UserController::class)->names('user');

        // vendor limit
        Route::resource('vendor-limit', VendorLimitController::class)->names('vendor-limit');

        // vendor grade
        Route::resource('vendor-grade', VendorGradeController::class)->names('vendor-grade');

        // vendor
        Route::resource('vendor', VendorController::class)->names('vendor');

        // vendor membership
        Route::resource('membership', MembershipController::class)->names('membership');

        // membership benefit
        Route::resource('membership-benefit', MembershipBenefitController::class)->names('membership-benefit');

        // product category
        Route::resource('product-category', ProductCategoryController::class)->names('product-category');

        // product attribute
        Route::resource('product-attribute', ProductAttributeController::class)->names('product-attribute');

        // product variant
        Route::resource('product-variant', ProductVariantController::class)->names('product-variant');

        // checklist item
        Route::resource('checklist-item', ChecklistItemController::class)->names('checklist-item');

        // route department
        Route::resource('department', DepartmentController::class)->names('department');

        // route position
        Route::resource('position', PositionController::class)->names('position');

        // allowance
        Route::resource('allowance', AllowanceController::class)->names('allowance');

        // level
        Route::resource('level', LevelController::class)->names('level');

        // employee
        Route::resource('employee', EmployeeController::class)->names('employee');
        Route::post('/employee/{id}/generate-user-account', [EmployeeController::class, 'generateUserAccount'])->name('employee.generate-user-account');

        // attendance
        Route::resource('attendance', AttendanceController::class)->names('attendance');

        // route team
        Route::resource('team', TeamController::class)->names('team');

        // route team loan
        Route::resource('team-loan', TeamLoanController::class)->names('team-loan');

        // route order
        Route::resource('order', OrderController::class)->names('order');

        // route order product
        Route::resource('order-product', OrderProductController::class)->names('order-product');

        // route order team
        Route::resource('order-team', OrderTeamController::class)->names('order');

        // route decoration area
        Route::resource('decoration-area', DecorationAreaController::class)->names('decoration-area');

        // route sales
        //Route::resource('sales', SalesController::class)->names('sales');
        Route::apiResource('/sales', SalesController::class);
    });

    // route for permission
    Route::get('v2/permission', [PermissionController::class, 'index']);
});

Route::prefix('v2')->group(function () {
    // ...
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login-with-otp', [AuthController::class, 'loginWithOtp'])->name('login-with-otp');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('auth:sanctum');
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/reset-password-with-otp', [AuthController::class, 'resetPasswordWithOtp'])->name('reset-password-with-otp');
});
