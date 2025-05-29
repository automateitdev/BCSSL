<?php

namespace App\Http\Controllers\Admin\FeesManagement;

use Carbon\Carbon;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Services\Common\InvoiceService;
use Yajra\DataTables\Facades\DataTables;

class PaidInfoController extends Controller
{
    public $invoiceService;
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
        $this->middleware(['permission:Paid Info Report View'])->only(['index']);
        $this->middleware(['permission:Paid Info Report Invoice View'])->only(['painInvoiceView']);
    }
    public function index()
    {
        set_page_meta('Paid infos');
        return view('pages.admin.fees_management.reports.details.paid-info');
    }


    public function paidInfoSearch(Request $request)
    {
        $invoices = PaymentInfo::query()->with(['member.associatorsInfo', 'paymentsInfoItems.feeAssign']);
        $invoices->where('status', PaymentInfo::STATUS_COMPLETE);

        $invoices->when(isset($request->from) && isset($request->to), function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->from)->whereDate('created_at', '<=', $request->to);
        });

        $invoices = $invoices->get();

        // Calculate total payment from joining date till today
        $invoices->each(function ($invoice) {
            $joiningDate = $invoice->member ? $invoice->member->joining_date : null;
            if ($joiningDate) {
                $totalPayable = PaymentInfo::where('member_id', $invoice->member_id)
                    ->where('status', PaymentInfo::STATUS_COMPLETE)
                    ->whereDate('created_at', '>=', $joiningDate)
                    ->sum('payable_amount');
                // Assign total payment to each invoice
                $invoice->total_payment_since_joining = $totalPayable;
            } else {
                $invoice->total_payment_since_joining = $invoice->payable_amount;
            }
        });

        // Calculate total fine from joining date till today
        $invoices->each(function ($invoice) {
            $joiningDate = $invoice->member ? $invoice->member->joining_date : null;
            if ($joiningDate) {
                $totalFineAmount = PaymentInfo::where('member_id', $invoice->member_id)
                    ->where('status', PaymentInfo::STATUS_COMPLETE)
                    ->whereDate('created_at', '>=', $joiningDate)
                    ->sum('fine_amount');
                // Assign total payment to each invoice
                $invoice->total_fine_since_joining = $totalFineAmount;
            } else {
                $invoice->total_fine_since_joining = $invoice->fine_amount;
            }
        });

        return DataTables::of($invoices)->setRowAttr([
            'align' => 'left',
        ])->addColumn('membership_no', function (PaymentInfo $data) {
            return $data->member->associatorsInfo->membershp_number ?? '';
        })->addColumn('member_name', function (PaymentInfo $data) {
            return $data->member->name ?? '';
        })->addColumn('year', function (PaymentInfo $data) {
            return Carbon::parse($data->created_at)->format('Y');
        })->addColumn('month', function (PaymentInfo $data) {
            return Carbon::parse($data->created_at)->format('F');
        })->addColumn('details', function (PaymentInfo $data) {
            $details = '';
            foreach ($data->paymentsInfoItems as $item) {
                if ($item->feeAssign) {
                    $details .= 'Fee:' . number_format($item->amount) . '/- of ' . Carbon::parse($item->feeAssign->assign_date)->format('F Y') . ', Fine:' . number_format($item->fine_amount) . '/-' . ",<br>";
                }
            }
            return nl2br(rtrim($details, ", "));
        })->addColumn('action', function (PaymentInfo $data) {
            $btn = "<a href='" . route('admin.report.paid.info.invoice.view', $data->id) . "' class='edit btn btn-primary btn-sm'>View</a>";
            return $btn;
        })->rawColumns(['details', 'action'])
            ->make(true);
    }


    public function memberwisePaidIndex()
    {
        set_page_meta('memberwise Paid infos');
        return view('pages.admin.fees_management.reports.details.memberwise-paid');
    }

    public function memberwisePaidInfoSearch(Request $request)
    {
        $members = Member::with('associatorsInfo', 'paymentInfos.paymentsInfoItems.feeAssign')
            ->whereHas('paymentInfos', function ($query) use ($request) {
                $query->where('status', 'completed');
                if (isset($request->from) && isset($request->to)) {
                    $query->whereDate('created_at', '>=', $request->from)
                        ->whereDate('created_at', '<=', $request->to);
                }
            })
            ->withSum(['paymentInfos' => function ($query) use ($request) {
                $query->where('status', 'completed');
                if (isset($request->from) && isset($request->to)) {
                    $query->whereDate('created_at', '>=', $request->from)
                        ->whereDate('created_at', '<=', $request->to);
                }
        }], 'payable_amount')
            ->get();

        $members->each(function ($member) {
            $joiningDate = $member->joining_date;
            if ($joiningDate) {
                $totalPayable = PaymentInfo::where('member_id', $member->id)
                    ->where('status', PaymentInfo::STATUS_COMPLETE)
                    ->whereDate('created_at', '>=', $joiningDate)
                    ->sum('payable_amount');
                // Assign total payment to each member
                $member->total_payment_since_joining = $totalPayable;
            } else {
                $member->total_payment_since_joining = PaymentInfo::where('member_id', $member->id)
                    ->where('status', PaymentInfo::STATUS_COMPLETE)
                    ->sum('payable_amount');
            }
        });

        return DataTables::of($members)->setRowAttr([
            'align' => 'left',
        ])->addColumn('membership_no', function ($member) {
            return $member->associatorsInfo->membershp_number ?? '';
        })->addColumn('member_name', function ($member) {
            return $member->name ?? '';
        })->addColumn('Batch_cadre', function ($member) {
            return $member->bcs_batch ?? '';
        })->addColumn('Paid_Total', function ($member) {
            return $member->payment_infos_sum_payable_amount ?? '';
        })->addColumn('Member_Since', function ($member) {
            return $member->joining_date ?? '';
        })->addColumn('Paid_Cummulative', function ($member) {
            return $member->total_payment_since_joining ?? '';
        })->addColumn('action', function ($member) use ($request) {
            $url = route('admin.report.paid.info.memberwise.invoice.view', $member->id);
            $url .= '?from=' . urlencode($request->from) . '&to=' . urlencode($request->to);
            $btn = "<a href='{$url}' class='edit btn btn-primary btn-sm'>View</a>";
            return $btn;
        })->rawColumns(['action'])
            ->make(true);
    }


    public function painInvoiceView($id)
    {
        set_page_meta('Paid infos Invoice');
        $invoiceData = $this->invoiceService->invoiceView($id);
        return view(
            'pages.admin.fees_management.reports.invoices.single-invoice',
            [
                'text' => $invoiceData['text'],
                'paymentInfo' => $invoiceData['paymentInfo'],
                'total_amount_num_to_sensts' => $invoiceData['total_amount_num_to_sensts'],
                'qrcode' => $invoiceData['qrcode']
            ]
        );
    }

    public function memberwisePaidInvoiceView(Request $request, $id)
    {
        set_page_meta('Memberwise Paid infos');

        $member = Member::where('id', $id)
            ->with([
                'associatorsInfo',
                'paymentInfos' => function ($query) use ($request) {
                    if (isset($request->from) && isset($request->to)) {
                        // Convert dates to the database format if needed
                        $fromDate = \Carbon\Carbon::parse($request->from)->format('Y-m-d');
                        $toDate = \Carbon\Carbon::parse($request->to)->format('Y-m-d');
                        $query->whereDate('created_at', '>=', $fromDate)
                            ->whereDate('created_at', '<=', $toDate)
                            ->where('status', PaymentInfo::STATUS_COMPLETE);
                    }
                },
            ])->first();

        // Calculate the total amount paid since joining date
        if ($member) {
            $joiningDate = $member->associatorsInfo ? $member->associatorsInfo->joining_date : null;
            if ($joiningDate) {
                $totalAmountPaid = PaymentInfo::where('member_id', $member->id)
                    ->where('status', PaymentInfo::STATUS_COMPLETE)
                    ->whereDate('created_at', '>=', $joiningDate)
                    ->sum('total_amount');

                // Assign the total amount paid to the member
                $member->total_amount_paid_since_joining = $totalAmountPaid;
            } else {
                $totalAmountPaid = PaymentInfo::where('member_id', $member->id)
                    ->where('status', PaymentInfo::STATUS_COMPLETE)
                    ->sum('total_amount');
                $member->total_amount_paid_since_joining = $totalAmountPaid;
            }
        }
        // Create Carbon instances from the input dates
        $carbonFromDate = Carbon::createFromFormat('Y-m-d', $request->from);
        $carbonToDate = Carbon::createFromFormat('Y-m-d', $request->to);

        // Format dates as dd-M-Y
        $from = $carbonFromDate->format('d-M-Y');
        $to = $carbonToDate->format('d-M-Y');
        return view('pages.admin.fees_management.reports.invoices.memberwise-invoices', compact('member', 'from', 'to'));
    }
}
