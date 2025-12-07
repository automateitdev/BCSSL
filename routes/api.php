<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\Api\SpgPaymentController;
use App\Http\Controllers\sms\SmsSettingsController;
use App\Http\Controllers\Admin\FeesManagement\PaymentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//SPG
Route::post('/DataUpdate', [SpgPaymentController::class, 'dataUpdate']);

// payflex essential routes
Route::post('/pay-flex/verify', [PaymentController::class, 'handlePayFlexVerification']);
Route::post('/pay-flex/notify', [PaymentController::class, 'handlePayFlexNotification']);

// Route::post('/member-portal-register', [MemberAuthController::class, 'memberRegister']);
