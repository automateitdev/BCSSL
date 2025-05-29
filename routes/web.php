<?php
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\member\MemberInfoController;
use App\Http\Controllers\Admin\FeesManagement\PaymentController;
use App\Http\Controllers\Admin\FeesManagement\FeeSetupController;
use App\Http\Controllers\Admin\FeesManagement\FeeAssignController;
use App\Http\Controllers\Admin\FeesManagement\FeeCollectController;
use App\Http\Controllers\Admin\MemberManagement\ApprovalController;
use App\Http\Controllers\Admin\FeesManagement\PaymentApprovalController;
use App\Http\Controllers\Admin\MemberManagement\AssociatorInfoController;
use App\Http\Controllers\Admin\AccountManagement\account\LedgerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $user_gender = collect(User::USER_GENDER);
    return view('pages.member.member_login_register', [
        'user_gender' => $user_gender,
    ]);
});


//member
Route::middleware(['MemberGuestAuthCheck'])->group(function () {
    Route::controller(MemberAuthController::class)->group(function () {
        Route::get('/member-portal', 'index')->name('member.portal');
        Route::post('/member-portal/login', 'memberLogin')->name('member.login');
        // Route::post('/member-portal-register', 'memberRegister');
    });
});
Route::controller(MemberAuthController::class)->group(function () {
    Route::post('/member-portal-register', 'memberRegister');
});
//auth member profile update
Route::put('/member-profile-update', [MemberAuthController::class, 'memberProfileUpdate']);

Route::prefix('member')->as('member.')->middleware(['auth:web','MemberCheck'])->group(function () {

    Route::get('/dashboard', [MemberInfoController::class, 'memberInfo'])->name('memberInfo');
    Route::get('/payment/invoice/{id}', [MemberInfoController::class, 'paymentInvoice'])->name('payment.invoice');
    // Route::get('/payment', [MemberInfoController::class, 'memberPayment'])->name('memberPayment');
});
//member hhome page
Route::prefix('api')->group(function () {
    Route::get('fetch-all-disticts', [AjaxController::class, 'fetchAllDicticts']);
    Route::get('get-members', [AjaxController::class, 'getMembers'])->name('get.members');
});

Auth::routes();

