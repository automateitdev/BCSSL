<?php

namespace App\Http\Controllers\Admin\FeesManagement;

use Carbon\Carbon;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FeeAssign;
use App\Models\Member;
use App\Services\Common\InvoiceService;
use Yajra\DataTables\Facades\DataTables;

class DueInfoController extends Controller
{
    public $invoiceService;
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
        $this->middleware(['permission:Due Info Report View'])->only(['index']);
    }
    public function index()
    {
        set_page_meta('Active Due infos');
        return view('pages.admin.fees_management.reports.details.due.due-info');
    }

    public function dueInfoFetch(Request $request)
    {
        // dd($request->all() , $request->search['value']);
        $now_date = Carbon::now()->format('Y-m-d');
        $invoice_serach_check = null;

        $members = Member::query()
            ->where('status', 'active')
            ->whereHas(
                'feeAssigns',
                function ($query) use ($now_date) {
                    $query->where('status', FeeAssign::STATUS_DUE)
                        ->whereDate('assign_date', '<=', $now_date);
                }
            )
            ->with(['feeAssigns' => function ($query) use ($now_date) {
                $query->where('status', FeeAssign::STATUS_DUE)
                    ->whereDate('assign_date', '<=', $now_date);
            }, 'associatorsInfo'])
            ->get();



        return DataTables::of($members)
            ->setRowAttr([
                'align' => 'left',
            ])
            ->addColumn('checkbox', function ($member) {
                // Assuming $member->id is the unique identifier for each row
                return '<input type="checkbox" class="smscheckformul" name="invoice_checkbox[]" value="' . $member->id . '">';
            })
            ->addColumn('membershp_number', function ($member) {
                return $member->associatorsInfo->membershp_number ?? '';
            })
            ->addColumn('member_name', function ($member) {
                return $member->name ?? '';
            })
            ->addColumn('year', function ($member) {
                return $member->feeAssigns->first() ? Carbon::parse($member->feeAssigns->first()->created_at)->format('Y') : '';
            })
            ->addColumn('month', function ($member) {
                return $member->feeAssigns->first() ? Carbon::parse($member->feeAssigns->first()->created_at)->format('F') : '';
            })
            ->addColumn('total_amount', function ($member) {
            return $member->feeAssigns->sum('amount') + $member->feeAssigns->sum('fine_amount');
            })
            ->addColumn('details', function ($member) {
                $details = '';
            foreach ($member->feeAssigns as $feeAssign) {
                $details .= 'Fee: ' . number_format($feeAssign->amount) . '/- of ' . Carbon::parse($feeAssign->assign_date)->format('F Y') . ', Fine: ' . number_format($feeAssign->fine_amount) . '/-' . ",<br>";
            }
            return nl2br(rtrim($details, ", "));
            })
            ->rawColumns(['details'])
            ->make(true);
    }

    public function suspended_due_info()
    {
        set_page_meta('Suspended Due infos');
        return view('pages.admin.fees_management.reports.details.due.suspended-due-info');
    }

    public function SuspendedDueInfoFetch(Request $request)
    {
        // dd($request->all() , $request->search['value']);
        $now_date = Carbon::now()->format('Y-m-d');
        $invoice_serach_check = null;

        $members = Member::query()
            ->where('status', 'suspended')
            ->whereHas(
                'feeAssigns',
                function ($query) use ($now_date) {
                    $query->where('status', FeeAssign::STATUS_DUE)
                        ->whereDate('assign_date', '<=', $now_date);
                }
            )
            ->with(['feeAssigns' => function ($query) use ($now_date) {
                $query->where('status', FeeAssign::STATUS_DUE)
                    ->whereDate('assign_date', '<=', $now_date);
            }, 'associatorsInfo'])
            ->get();

        return DataTables::of($members)
            ->setRowAttr([
                'align' => 'left',
            ])
            ->addColumn('checkbox', function ($member) {
                // Assuming $member->id is the unique identifier for each row
                return '<input type="checkbox" class="smscheckformul" name="invoice_checkbox[]" value="' . $member->id . '">';
            })
            ->addColumn('membershp_number', function ($member) {
                return $member->associatorsInfo->membershp_number ?? '';
            })
            ->addColumn('member_name', function ($member) {
                return $member->name ?? '';
            })
            ->addColumn('year', function ($member) {
                return $member->feeAssigns->first() ? Carbon::parse($member->feeAssigns->first()->created_at)->format('Y') : '';
            })
            ->addColumn('month', function ($member) {
                return $member->feeAssigns->first() ? Carbon::parse($member->feeAssigns->first()->created_at)->format('F') : '';
            })
            ->addColumn('total_amount', function ($member) {
            return $member->feeAssigns->sum('amount') + $member->feeAssigns->sum('fine_amount');
            })
            ->addColumn('details', function ($member) {
                $details = '';
            foreach ($member->feeAssigns as $feeAssign) {
                $details .= 'Fee: ' . number_format($feeAssign->amount) . '/- of ' . Carbon::parse($feeAssign->assign_date)->format('F Y') . ', Fine: ' . number_format($feeAssign->fine_amount) . '/-' . ",<br>";
            }
            return nl2br(rtrim($details, ", "));
            })
            ->rawColumns(['details'])
            ->make(true);
    }
}
