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
use App\Http\Controllers\API\Web\BankAccountController;
use App\Http\Controllers\API\Web\ConfigLoanInstallmentController;
use App\Http\Controllers\Api\Web\TeamController;
use App\Http\Controllers\Api\Web\TeamLoanController;
use App\Http\Controllers\Api\Web\OrderController;
use App\Http\Controllers\Api\Web\OrderProductController;
use App\Http\Controllers\Api\Web\DecorationAreaController;
use App\Http\Controllers\Api\Web\OrderTeamController;
use App\Http\Controllers\Api\Web\SalesController;
use App\Http\Controllers\API\Web\VehicleController;
use App\Http\Controllers\Api\Web\ChecklistCategoryController;
use App\Http\Controllers\Api\Web\ActivityLogController;
use App\Http\Controllers\Api\Web\OrderAdditionalServiceController;

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

        // activity log
        Route::resource('activity-log', ActivityLogController::class)->names('activity-log');

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

        // product attribute
        Route::resource('product-attribute', ProductAttributeController::class)->names('product-attribute');

        // product variant
        Route::resource('product-variant', ProductVariantController::class)->names('product-variant');

        // checklist category
        Route::resource('checklist-category', ChecklistCategoryController::class)->names('checklist-category');

        // checklist item
        Route::resource('checklist-item', ChecklistItemController::class)->names('checklist-item');

        // route position
        Route::resource('position', PositionController::class)->names('position');

        // allowance
        Route::resource('allowance', AllowanceController::class)->names('allowance');

        // level
        Route::resource('level', LevelController::class)->names('level');

        // employee
        Route::resource('employee', EmployeeController::class)->names('employee');
        Route::post('/employee/{id}/generate-user-account', [EmployeeController::class, 'generateUserAccount'])->name('employee.generate-user-account');
        // generate password for employee
        Route::post('/employee/{id}/generate-password', [EmployeeController::class, 'generatePasswordEmployee'])->name('employee.generate-password');

        // attendance
        Route::resource('attendance', AttendanceController::class)->names('attendance');

        // route team loan
        Route::resource('team-loan', TeamLoanController::class)->names('team-loan');

        // route order
        Route::resource('order', OrderController::class)->names('order');

        // route order product
        Route::resource('order-product', OrderProductController::class)->names('order-product');

        // route order team
        Route::resource('order-team', OrderTeamController::class)->names('order');

        // order additional service
        Route::resource('order-add-on', OrderAdditionalServiceController::class)->names('order-additional-service');

        // route sales
        Route::apiResource('/sales', SalesController::class);

        // route bank account
        Route::apiResource('/bank-account', BankAccountController::class);

        // route bank account
        Route::apiResource('/decoration-area', DecorationAreaController::class);

        // route department
        Route::apiResource('/department', DepartmentController::class);

        // route product category
        Route::apiResource('/product-category', ProductCategoryController::class);

        // route team
        Route::apiResource('/team', TeamController::class);

        // route vehicle
        Route::apiResource('/vehicle', VehicleController::class);

        // route config loan installment
        Route::apiResource('/config-installment', ConfigLoanInstallmentController::class);
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
