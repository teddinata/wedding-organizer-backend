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
use App\Http\Controllers\Api\Web\BankAccountController;
use App\Http\Controllers\Api\Web\ConfigLoanInstallmentController;
use App\Http\Controllers\Api\Web\TeamController;
use App\Http\Controllers\Api\Web\TeamLoanController;
use App\Http\Controllers\Api\Web\OrderController;
use App\Http\Controllers\Api\Web\OrderProductController;
use App\Http\Controllers\Api\Web\DecorationAreaController;
use App\Http\Controllers\Api\Web\OrderTeamController;
use App\Http\Controllers\Api\Web\SalesController;
use App\Http\Controllers\Api\Web\VehicleController;
use App\Http\Controllers\Api\Web\ChecklistCategoryController;
use App\Http\Controllers\Api\Web\ActivityLogController;
use App\Http\Controllers\Api\Web\OrderAdditionalServiceController;
use App\Http\Controllers\Api\Web\TeamMemberController;
use App\Http\Controllers\Api\Web\AdditionalServiceController;
use App\Http\Controllers\Api\Web\CareerLevelController;
use App\Http\Controllers\Api\Web\LeadController;
use App\Http\Controllers\Api\Web\OrderDriverController;
use App\Http\Controllers\Api\Web\InvoiceController;
use App\Http\Controllers\Api\Web\OrderHistoryController;
use App\Http\Controllers\Api\Web\BenefitController;
use App\Http\Controllers\Api\Web\DepartmentAllowanceController;

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
        Route::get('/my-profile', [AuthController::class, 'profile'])->name('my-profile');
        Route::post('/change-email', [AuthController::class, 'changeEmail'])->name('change-email');
        Route::post('/verif-email', [AuthController::class, 'verifEmail'])->name('verif-email');
        Route::post('/confirm-verif-email', [AuthController::class, 'confirmVerifEmail'])->name('confirm-verif-email');

        Route::post('/edit-profile', [AuthController::class, 'editProfile'])->name('edit-profile');
        Route::post('/edit-password', [AuthController::class, 'editPassword'])->name('edit-password');

        Route::resource('role', RoleController::class)->names('role');

        // user
        Route::resource('user', UserController::class)->names('user');

        // activity log
        Route::resource('activity-log', ActivityLogController::class)->names('activity-log');

        // vendor limit
        Route::resource('vendor-limit', VendorLimitController::class)->names('vendor-limit');

        // vendor grade
        Route::apiResource('vendor-grade', VendorGradeController::class);

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
        Route::apiResource('checklist-category', ChecklistCategoryController::class);

        // checklist item
        Route::apiResource('checklist-item', ChecklistItemController::class);

        // route position
        Route::resource('position', PositionController::class)->names('position');

        // route additional service
        Route::resource('additional-service', AdditionalServiceController::class)->names('additional-service');

        // allowance
        Route::resource('allowance', AllowanceController::class)->names('allowance');

        // level
        Route::apiResource('level', LevelController::class);

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
        Route::resource('order', OrderController::class);

        // route order product
        Route::resource('order-product', OrderProductController::class)->names('order-product');

        // route order team
        Route::resource('order-team', OrderTeamController::class)->names('order-team');

        // route order driver
        Route::resource('order-driver', OrderDriverController::class)->names('order-driver');

        // order additional service
        Route::resource('order-add-on', OrderAdditionalServiceController::class)->names('order-additional-service');

        // order history route resource
        Route::resource('order-history', OrderHistoryController::class)->names('order-history');
        // route update status in order history by order id
        Route::post('order-history/update-status-order', [OrderHistoryController::class, 'changeStatus'])->name('order-history.change-status-order');

        // route sales
        Route::apiResource('sales', SalesController::class);

        // route bank account
        Route::apiResource('bank-account', BankAccountController::class);

        // route bank account
        Route::apiResource('decoration-area', DecorationAreaController::class);

        // route department
        Route::apiResource('/department', DepartmentController::class);

        // route product category
        Route::apiResource('/product-category', ProductCategoryController::class);

        // route team
        Route::apiResource('/team', TeamController::class);

        // team member
        Route::resource('team-member', TeamMemberController::class)->names('team-member');

        // route vehicle
        Route::apiResource('vehicle', VehicleController::class);

        // route department allowance
        Route::apiResource('department-allowance', DepartmentAllowanceController::class);

        // route config loan installment
        Route::apiResource('config-installment', ConfigLoanInstallmentController::class);

        // route career level
        Route::apiResource('career-level', CareerLevelController::class);

        // route benefit
        Route::apiResource('benefit', BenefitController::class);

        // route lead
        Route::resource('leads', LeadController::class)->names('lead');

        // invoice paid
        Route::get('invoice/paid', [InvoiceController::class, 'indexPaid'])->name('invoice.paid');
        // invoice overdue
        Route::get('invoice/overdue', [InvoiceController::class, 'indexOverdue'])->name('invoice.overdue');
        // invoice waiting payment
        Route::get('invoice/waiting-payment', [InvoiceController::class, 'indexWaitingForPayment'])->name('invoice.waiting-payment');
        // invoice route resource
        Route::resource('invoice', InvoiceController::class)->names('invoice');
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

// Route::resource('sample', App\Http\Controllers\Api\Web\SampleSalesController::class);
