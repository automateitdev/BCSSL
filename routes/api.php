<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SpgPaymentController;
use App\Http\Controllers\PayflexController;

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
Route::post('/pay-flex/verify', [PayflexController::class, 'handlePayFlexVerification'])->name('payFlex.verification');
// Route::post('/pay-flex/notify', [PayflexController::class, 'handlePayFlexNotification'])->name('payFlex.notification');

// Route::post('/member-portal-register', [MemberAuthController::class, 'memberRegister']);
