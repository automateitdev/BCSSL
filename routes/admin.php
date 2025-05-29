<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\sms\SmsSendController;
use App\Http\Controllers\sms\TemplateController;
use App\Http\Controllers\sms\SmsSettingsController;
use App\Http\Controllers\member\MemberInfoController;
use App\Http\Controllers\Admin\CoreSetting\UserController;
use App\Http\Controllers\Admin\CoreSetting\SettingController;
use App\Http\Controllers\Admin\RolePermission\RoleController;
use App\Http\Controllers\Admin\FeesManagement\DueInfoController;
use App\Http\Controllers\Admin\FeesManagement\PaymentController;
use App\Http\Controllers\Admin\FeesManagement\FeeSetupController;
use App\Http\Controllers\Admin\FeesManagement\PaidInfoController;
use App\Http\Controllers\Admin\MemberManagement\MemberController;
use App\Http\Controllers\Admin\FeesManagement\FeeAssignController;
use App\Http\Controllers\Admin\FeesManagement\FeeCollectController;
use App\Http\Controllers\Admin\MemberManagement\ApprovalController;
use App\Http\Controllers\Admin\FeesManagement\PaymentApprovalController;
use App\Http\Controllers\Admin\MemberManagement\AssociatorInfoController;
use App\Http\Controllers\Admin\AccountManagement\account\LedgerController;
use App\Http\Controllers\Admin\AccountManagement\ProfileApprovalController;
use App\Http\Controllers\Admin\manualFix\FixController;
use App\Http\Controllers\Admin\MemberManagement\FineAdjustmentController;
use App\Http\Controllers\Admin\MemberManagement\Report\MemberListController;
use App\Http\Controllers\CoreReportController;
use App\Http\Controllers\Layout\LayoutController;
use App\Http\Controllers\LedgerTraceController;
use App\Http\Controllers\VoucherController;
use App\Models\CoreReport;

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
// Route::group(['middleware'=>['auth','activeMember']],function(){

Route::get('vouchers/list', [VoucherController::class, 'getVouchers'])->name('admin.vouchers.list');
Route::get('/account-management/voucherwise/report/list', [
    VoucherController::class, 'voucher_list'
])->name('admin.voucherwise.report.list');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/fixPaymentInfoFine', [FixController::class, 'paymentInfoFineAdjust']);
});

Route::get('/fineDateFix', [FeeAssignController::class, 'updateFineDates']);
Route::get('/settlement', [VoucherController::class, 'settleAccount']);
Route::get('/certificate', [Layoutcontroller::class, 'certificate']);
Route::prefix('admin')->as('admin.')->middleware(['auth:admin', 'ActiveAdminCheck', 'web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/member-management/approval', [ApprovalController::class, 'index'])->name('approval.list');
    Route::get('/member-management/fine-adjust', [FineAdjustmentController::class, 'index'])->name('fine.adjust');
    Route::get('/member-management/fine-adjust/view/{member}', [FineAdjustmentController::class, 'view'])->name('fine.adjust.view');
    Route::post('/member-management/fine-adjust/update', [FineAdjustmentController::class, 'update'])->name('fine.adjustment.update');
    // admin.payment.fine.adjustment.update

    Route::post('/member-management/approval/update', [ApprovalController::class, 'approvalUpdate'])->name('approval.update');
    Route::post('/member-management/approval-all/update', [ApprovalController::class, 'approvalAlUpdate'])->name('approval.all.update');

    Route::prefix('member-management')->group(function () {
        //associators-info
        Route::resource('associators-info', AssociatorInfoController::class);
        Route::post('/associators-info/update/{id}', [AssociatorInfoController::class, 'infoUpdate'])->name('associators.update');
        Route::get('/registration', [MemberController::class, 'registration'])->name('member.registration');
        //report

        Route::prefix('layout')->as('layout.')->group(function () {
            Route::get('/member-list/fetch', [LayoutController::class, 'layouts_memberlist'])->name('member.list.fetch');
            Route::post('/member-list/process-info', [LayoutController::class, 'process_data'])->name('member.list.process-info');
            Route::get('/signatures', [LayoutController::class, 'add_signature'])->name('signature');
            Route::post('/upload-signature', [LayoutController::class, 'upload_signature'])->name('upload.signature');
        });

        Route::prefix('report')->as('report.')->group(function () {
            Route::get('/suspended-list', [MemberListController::class, 'suspended_list'])->name('suspended.list');
            Route::get('/member-list', [MemberListController::class, 'memberList'])->name('member.list');
            Route::get('/member-list/fetch', [MemberListController::class, 'memberListFetch'])->name('member.list.fetch');

            Route::get('/member-pdf/{id}', [MemberListController::class, 'memberPdf'])->name('member.pdf');
            Route::get('/member-edit/{id}', [MemberListController::class, 'memberEdit'])->name('member.edit');
            Route::put('/member-profile-update/{id}', [MemberAuthController::class, 'memberUpdate'])->name('member.profile.update');
        });
    });
    Route::prefix('core-setting')->group(function () {
        //role permission
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('settings', SettingController::class);
    });
    //account management
    Route::get('/account-management', [LedgerController::class, 'index'])->name('ledger.index');
    Route::post('/account-management/ledger/store', [LedgerController::class, 'store'])->name('ledger.store');
    Route::get('/getAccountGroup', [LedgerController::class, 'getAccountGroup']);
    Route::get('/getAccountGroupnote', [LedgerController::class, 'getAccountGroupnote']);

    Route::get('/account-management/income-statement', [
        CoreReportController::class,
        'income_statement'
    ])->name('core-report.income-statement');

    Route::post('income_statement_pdf', [CoreReportController::class, 'income_statement_pdf']);

    Route::post('/account-management/income-statement/search', [CoreReportController::class, 'income_statement_search'])->name('core-report.income-statement.search');

    //voucher entry start
    Route::get('/account-management/vouchers', [
        VoucherController::class,
        'index'
    ])->name('voucher.index');


    Route::post('vouchers/approval/update', [VoucherController::class, 'voucher_approval'])->name('approval.voucher.update');

    Route::get('/account-management/voucher/entry/payment', [
        VoucherController::class,
        'payment_view'
    ])->name('voucher.entry.payment');

    Route::post('/account-management/voucher/payment/store', [
        VoucherController::class,
        'payment_store'
    ])->name('voucher.payment.store');

    Route::get('/account-management/voucher/entry/receipt', [
        VoucherController::class,
        'receipt_view'
    ])->name('voucher.entry.receipt');

    Route::post('/account-management/voucher/receipt/store', [
        VoucherController::class,
        'receipt_store'
    ])->name('voucher.receipt.store');


    Route::get('/account-management/voucher/entry/journal', [
        VoucherController::class,
        'journal_view'
    ])->name('voucher.entry.journal');

    Route::post('/account-management/voucher/journal/store', [
        VoucherController::class,
        'journal_store'
    ])->name('voucher.journal.store');

    // general account report start
    Route::get('/account-management/voucherwise/report', [
        VoucherController::class, 'voucherwise_report'
    ])->name('voucherwise.report');

    Route::get('/core-report/voucher/view/{trace}', [LedgerTraceController::class, 'view_ledger_traces'])->name('ledger.traces.view');

    //fee management
    Route::get('/fees-management', [FeeSetupController::class, 'index'])->name('fees.index');
    Route::post('/fees-management/fee-setup/store', [FeeSetupController::class, 'store'])->name('fees.store');

    //fee assing
    Route::get('/fees-assign', [FeeAssignController::class, 'index'])->name('fees.assign');
    Route::get('/get-fee-setup/{id}', [FeeAssignController::class, 'getFeeSetup']);
    Route::post('/fees-assign', [FeeAssignController::class, 'feeAssignStore'])->name('fees.assign.submit');
    //note: auto fine date setup
    Route::get('/fine-date-auto-setup', [FeeAssignController::class, 'fineDateSetup']);

    //fee collect
    Route::get('/fees-collections', [FeeCollectController::class, 'index'])->name('fees.collections');
    Route::get('/fees-quick-collection/member/{id}', [FeeCollectController::class, 'quickCollection'])->name('fees.quick.collection');

    //payment crete
    // Route::post('/payment/create', [PaymentController::class, 'paymentCreate'])->name('fees.payment.create');
    Route::get('/payment/invoice/{id}', [PaymentController::class, 'paymentInvoice'])->name('payment.invoice');

    //payment approval
    Route::get('/payment-list', [PaymentApprovalController::class, 'paymentList'])->name('payment.list');

    Route::get('/payment-list/complete', [PaymentApprovalController::class, 'paymentComplete'])->name('payment.complete.list');

    Route::get('/payment/completed', [PaymentApprovalController::class, 'paymentCompleteList'])->name('completed.payment.list');

    Route::get('/payment-list/suspend', [PaymentApprovalController::class, 'paymentSuspend'])->name('payment.suspend.list');

    Route::get('/payment/suspended', [PaymentApprovalController::class, 'paymentSuspendList'])->name('suspended.payment.list');

    Route::post('/payment-status-update', [PaymentApprovalController::class, 'paymentStatusUpdate'])->name('payment.status.update');
    Route::get('/payment-invoice-view/{id}', [PaymentApprovalController::class, 'paymentInvoiceView'])->name('payment.invoice.view');


    //user profile update approval
    Route::get('/update-profiles-list', [ProfileApprovalController::class, 'updatedProfilesList'])->name('updated.profiles.list');
    Route::get('/update-profiles/{id}/view', [ProfileApprovalController::class, 'updatedProfilesView'])->name('updated.profiles.view');
    Route::post('/update-profiles/submit', [ProfileApprovalController::class, 'updatedProfilesSubmit'])->name('updated.profiles.submit');

    //reports
    Route::prefix('report')->as('report.')->group(function () {
        Route::get('paid-info', [PaidInfoController::class, 'index'])->name('paid.info');
        Route::get('memberwise/paid-info', [PaidInfoController::class, 'memberwisePaidIndex'])->name('memberwise.paid.info');
        Route::get('paid-info/search', [PaidInfoController::class, 'paidInfoSearch'])->name('paid.info.search');
        Route::get('memberwise/paid-info/search', [PaidInfoController::class, 'memberwisePaidInfoSearch'])->name('memberwise.paid.info.search');

        Route::get('paid-info/invoice-view/{id}', [PaidInfoController::class, 'painInvoiceView'])->name('paid.info.invoice.view');
        Route::get('memberwise/paid-info/invoice-view/{id}', [PaidInfoController::class, 'memberwisePaidInvoiceView'])->name('paid.info.memberwise.invoice.view');
        //due report
        Route::get('due-info', [DueInfoController::class, 'index'])->name('due.info');
        Route::get('due-info/fetch', [DueInfoController::class, 'dueInfoFetch'])->name('due.info.fetch');

        Route::get('suspended-due-info', [DueInfoController::class, 'suspended_due_info'])->name('suspended.due.info');
        Route::get('suspended-due-info/fetch', [DueInfoController::class, 'SuspendedDueInfoFetch'])->name('suspended.due.info.fetch');
    });

    //sms
    Route::controller(SmsSettingsController::class)->group(function () {
        Route::get('sms-settings', 'index')->name('sms.purchase.index');
        Route::post('sms-recharge', 'smsrecharge')->name('sms.purchase.recharge');
        Route::get('sms-recharge/confirm', 'confirm');
        Route::post('sms-recharge/cancel', 'smsrecharge_cancel')->name('sms.purchase.cancel');
    });

    Route::controller(TemplateController::class)->group(function () {
        Route::get('/sms-template', 'index')->name('sms.temp.index');
        Route::post('/sms-template/store', 'store')->name('sms.temp.store');
        Route::get('/sms-template/edit/{id}', 'edit')->name('sms.temp.edit');
        Route::post('/sms-template/update/{id}', 'update')->name('sms.temp.update');
        Route::delete('/sms-template/delete/{id}', 'destroy')->name('sms.temp.delete');
    });

    Route::controller(SmsSendController::class)->group(function () {
        Route::get('/sms-send', 'index')->name('member.sms.index');
        Route::get('/notification-sms-send', 'notificationSms')->name('notificationSms');
        Route::post('sms-send/member', 'smsSendToMember')->name('member.sms.send');
        Route::post('notification-sms-send', 'dueSmsSend')->name('dueSmsSend');
        Route::get('/getsmsbody', 'getsmsbody')->name('getsmsbody');
        Route::get('/sms-report', 'smsReport')->name('smsReport');
        Route::get('/sms-report/fetch', 'smsReportFetch')->name('smsReport.fetch');
    });
});

Route::prefix('admin')->as('admin.')->group(function () {
    Route::post('/payment/create', [PaymentController::class, 'paymentCreate'])->name('fees.payment.create');
    Route::get('/payment/return-url', [PaymentController::class, 'paymentReturnUrl'])->name('fees.payment.returnUrl');
});


//admin
Route::middleware(['AdminGuestAuthCheck'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/login', 'index');
        Route::post('/login-submit', 'authenticate')->name('login.submit');
        Route::get('/loginfail', 'loginfail')->name('loginfail');
    });
});

// Route::middleware(['auth:admin'])->group(function () {
Route::controller(HomeController::class)->group(function () {
    Route::post('/logout', 'logout')->name('logout');
});
// });


Route::controller(HomeController::class)->group(function () {
    Route::post('/logout', 'logout')->name('logout');
});
