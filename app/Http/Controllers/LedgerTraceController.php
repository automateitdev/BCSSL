<?php

namespace App\Http\Controllers;

use App\Models\LedgerTrace;
use App\Services\Common\VoucherService;
use Illuminate\Http\Request;

class LedgerTraceController extends Controller
{
    public $voucherService;
    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
        $this->middleware(['permission:Payment Approval View'])->only(['paymentList']);
    }
    public function view_ledger_traces(LedgerTrace $trace)
    {
        set_page_meta('Voucher Traces');
        if ($trace) {
            $voucherData = $this->voucherService->voucherView($trace->voucher_id);
            return view('pages.admin.fees_management.reports.vouchers.single-voucher',
                [
                    // 'text' => $invoiceData['text'],
                    'traces' => $voucherData['traces'],
                    // 'total_amount_num_to_sensts' => $invoiceData['total_amount_num_to_sensts'],
                    // 'qrcode' => $invoiceData['qrcode']
                ]
            );
        } else {
            return redirect()->back()->withErrors(['Ledger' => 'No Ledger Trace Found !!'])->withInput();
        }
    }
}
