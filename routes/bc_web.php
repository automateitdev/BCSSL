<?php

use App\Http\Controllers\dashboard\account\LedgerController;
use App\Http\Controllers\dashboard\fees_management\FeeSetupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\dashboard\member\RegistrationController;
use App\Http\Controllers\member\MemberAuthController;

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


Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::post('/login', [HomeController::class, 'authenticate'])->name('login.dash');
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
Route::get('/loginfail', [HomeController::class, 'loginfail'])->name('loginFail');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('admin.dash');

    //member
    Route::get('/member-management', [RegistrationController::class, 'index'])->name('member.index');
    Route::post('/member-management/approved', [RegistrationController::class, 'store'])->name('member.approved');

    //fee management
    Route::get('/fees-management', [FeeSetupController::class, 'index'])->name('fees.index');

    //account management
    Route::get('/account-management', [LedgerController::class, 'index'])->name('ledger.index');
    Route::post('/account-management/ledger/store', [LedgerController::class, 'store'])->name('ledger.store');
    Route::get('/getAccountGroup', [LedgerController::class, 'getAccountGroup']);


});

//member login part
Route::get('/member-portal', [MemberAuthController::class, 'index'])->name('member.portal');
Route::post('/member-portal/registration', [MemberAuthController::class, 'store'])->name('member.store');
Route::post('/member-portal/login', [MemberAuthController::class, 'member_auth'])->name('member_auth');
Route::get('/member-portal/login', [MemberAuthController::class, 'mem_logout'])->name('member.logout');


// Route::middleware(['auth'])->group(function () {
    Route::get('/member-portal/dashboard', [MemberAuthController::class, 'member_dashboard'])->name('member_dashboard');
// });
