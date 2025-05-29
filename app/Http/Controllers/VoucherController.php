<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ledger;
use App\Models\Voucher;
use App\Models\LedgerTrace;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\UpdateFeeLedgerTracesJob;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{

    public function index()
    {
        return view('pages.admin.vouchers.index');
    }

    public function getVouchers(Request $request)
    {
        // if ($request->ajax()) {
            $data = Voucher::with('ledger_from', 'ledger_to')->latest()->get();
            return DataTables::of($data)
                ->addColumn('checkbox', function ($row) {
                    if ($row->state != 'pending') {
                        return '<i class="fa fa-certificate"><i/>';
                    } else {
                        return '<input type="checkbox" class="payment_single_check" data-id="' . $row->id . '">'
                            . '<input type="hidden" name="voucher[' . $row->id . '][id]" value="' . $row->id . '" class="payment_value_one_' . $row->id . '" disabled>';
                    }
                })
                ->addColumn('state', function ($item) {
                    if ($item->state == 'approved') {
                        return '<span class="badge text-bg-success">Approved</span>';
                    } elseif ($item->state == 'declined') {
                        return '<span class="badge text-bg-danger">Declined</span>';
                    } else {
                        return '<select name="voucher[' . $item->id . '][status]" id="status_change_' . $item->id . '" class="form-control status_change payment_value_one_' . $item->id . '" disabled>'
                            . '<option value="pending" ' . ($item->state == 'pending' ? 'selected' : '') . '>Pending</option>'
                            . '<option value="approved" ' . ($item->state == 'approved' ? 'selected' : '') . '>Approve</option>'
                            . '<option value="declined" ' . ($item->state == 'declined' ? 'selected' : '') . '>Decline</option>'
                            . '</select>';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['checkbox', 'state'])
                ->make(true);
        // }
    }


    public function voucher_approval(Request $request)
    {
        $request->validate([
            "voucher" => "required|array",
            "voucher.*" => "required|array|distinct",
        ]);
        foreach ($request->voucher as $voucher) {
            $voucher_data = Voucher::with(['ledger_from', 'ledger_to'])->find($voucher['id']);
            $voucher_data->state = $voucher['status'];

            if ($voucher_data->save()) {
                if ($voucher_data->state == 'approved') {
                    if ($voucher_data->type == 'payment' || $voucher_data->type == 'receipt') {
                        $creditInput = new LedgerTrace();
                        $creditInput->ledger_id = $voucher_data->ledger_from_id;
                        $creditInput->type = $voucher_data->type;
                        $creditInput->reference = $voucher_data->reference;
                        $creditInput->description = $voucher_data->description;
                        $creditInput->credit = $voucher_data->amount;
                        $creditInput->voucher_id = $voucher_data->voucher_id;
                        $creditInput->invoice_no = substr($voucher_data->voucher_id, 2);
                        $creditInput->voucher_date = $voucher_data->date;
                        $creditInput->save();

                        $debitInput = new LedgerTrace();
                        $debitInput->ledger_id = $voucher_data->ledger_to_id;
                        $debitInput->type = $voucher_data->type;
                        $debitInput->reference = $voucher_data->reference;
                        $debitInput->description = $voucher_data->description;
                        $debitInput->debit = $voucher_data->amount;
                        $debitInput->voucher_id = $voucher_data->voucher_id;
                        $debitInput->invoice_no = substr($voucher_data->voucher_id, 2);
                        $debitInput->voucher_date = $voucher_data->date;
                        $debitInput->save();
                    } elseif ($voucher_data->type == 'journal') {
                        dd('j');
                    } elseif ($voucher_data->type == 'contra') {
                        dd('c');
                    }
                }
            }
        }
        record_created_flash('Voucher Status Changed Sucessfully');
        return redirect()->back();
    }


    public function payment_view()
    {
        // $getCashLedger = Ledger::withSum('ledger_traces', 'debit')->withSum('ledger_traces', 'credit')->whereHas('account_group', function ($query) {
        //     $query->where('nature', 'debit')->whereIn('id', [1, 2, 3]);
        // })->groupBy('id')->get();

        $getCashLedger = Ledger::select('ledgers.*')
        ->withSum('ledger_traces', 'debit')
        ->withSum('ledger_traces', 'credit')
        ->whereHas('account_group', function ($query) {
            $query->where('nature', 'debit')->whereIn('id', [1, 2, 3]);
        })->groupBy(
            'ledgers.id',
            'ledgers.acc_group_id',
            'ledgers.ledger_name',
            'ledgers.created_at',
            'ledgers.updated_at'
        )->get();

        $getCreditLedger = Ledger::whereHas('account_group', function ($query) {
            $query->whereNotIn('id', [1, 2, 3])->where('acc_category_id', '!=', 4);
        })->get();
        return view('pages.admin.vouchers.payment', compact('getCashLedger', 'getCreditLedger'));
    }


    public function payment_store(Request $request)
    {
        $this->validate($request, [
            'paymentDate' => 'required',
            'paymentBy' => 'required',
            'paymentFor' => 'required|array',
            'payment_amount' => 'required|array',
            'paymentRef' => 'nullable|string',
            'paymentDesc' => 'nullable|string',
        ]);


        // dd(array_sum($request->payment_amount));


        $ledgerDetail = Ledger::where('id', $request->paymentBy)->withSum('ledger_traces', 'debit')->withSum('ledger_traces', 'credit')->whereHas('account_group', function ($query) {
            $query->where('nature', 'debit')->whereIn('id', [1, 2, 3]);
        })->groupBy('id')->first();

        $validator = Validator::make(
            ['ledger_traces_sum_debit' => $ledgerDetail->ledger_traces_sum_debit],
            ['ledger_traces_sum_debit' => 'required|numeric|min:' . array_sum($request->payment_amount)]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $lastVoucher = Voucher::latest('created_at')->first();

        if (!empty($lastVoucher)) {
            $lastVoucherNo = substr($lastVoucher->voucher_id, 2);
            $newVoucherNo = $lastVoucherNo + 1;
            $voucher_no = "VP" . $newVoucherNo;
        } else {
            $voucher_no = "VP1000";
        }

        try {
            DB::beginTransaction();
            foreach ($request->paymentFor as $key => $paymentfor) {

                $voucher = new Voucher();
                $voucher->voucher_id = $voucher_no;
                $voucher->ledger_from_id = $request->paymentBy;
                $voucher->ledger_to_id = $request->paymentFor[$key];
                $voucher->amount = $request->payment_amount[$key];
                $voucher->type = 'payment';
                $voucher->date = Carbon::parse($request->paymentDate)->format('Y-m-d H:i:s');
                $voucher->reference = $request->paymentRef;
                $voucher->description = $request->paymentDesc;
                $voucher->state = 'pending';
                $voucher->save();
            }
            DB::commit();

            return redirect()->back()->with('message', 'Submitted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ]);
        }
    }


    public function receipt_view()
    {
        $getCashLedger = Ledger::withSum('ledger_traces', 'debit')->withSum('ledger_traces', 'credit')->whereHas('account_group', function ($query) {
            $query->where('nature', 'debit')->whereIn('id', [1, 2, 3]);
        })->groupBy(
            'ledgers.id',
            'ledgers.acc_group_id',
            'ledgers.ledger_name',
            'ledgers.created_at',
            'ledgers.updated_at'
        )->get();


        $getDebitLedger = Ledger::whereHas('account_group', function ($query) {
            $query->whereIn('acc_category_id', [4]);
        })->get();

        return view('pages.admin.vouchers.receipt', compact('getCashLedger', 'getDebitLedger'));
    }

    public function receipt_store(Request $request)
    {
        $this->validate($request, [
            'recieptDate' => 'required',
            'recieptBy' => 'required',
            'recieptFor' => 'required|array',
            'reciept_amount' => 'required|array',
            'recieptRef' => 'nullable|string',
            'recieptDesc' => 'nullable|string',
        ]);
        $ledgerDetail = Ledger::where('id', $request->recieptBy)->withSum('ledger_traces', 'debit')->withSum('ledger_traces', 'credit')->whereHas('account_group', function ($query) {
            $query->where('nature', 'debit')->whereIn('id', [1, 2, 3]);
        })->groupBy('id')->first();

        $validator = Validator::make(
            ['ledger_traces_sum_debit' => $ledgerDetail->ledger_traces_sum_debit],
            ['ledger_traces_sum_debit' => 'required|numeric|min:' . array_sum($request->reciept_amount)]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $lastVoucher = Voucher::latest('created_at')->first();

        if (!empty($lastVoucher)) {
            $lastVoucherNo = substr($lastVoucher->voucher_id, 2);
            $newVoucherNo = $lastVoucherNo + 1;
            $voucher_no = "VR" . $newVoucherNo;
        } else {
            $voucher_no = "VR1000";
        }

        try {
            DB::beginTransaction();
            foreach ($request->recieptFor as $key => $recieptFor) {

                $voucher = new Voucher();
                $voucher->voucher_id = $voucher_no;
                $voucher->ledger_from_id = $request->recieptBy;
                $voucher->ledger_to_id = $request->recieptFor[$key];
                $voucher->amount = $request->reciept_amount[$key];
                $voucher->type = 'receipt';
                $voucher->date = date('Y-m-d H:i:s', strtotime($request->recieptDate));
                $voucher->reference = $request->recieptRef;
                $voucher->description = $request->recieptDesc;
                $voucher->state = 'pending';
                $voucher->save();
            }
            DB::commit();

            return redirect()->back()->with('message', 'Submitted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function journal_view()
    {
        $getCashLedger = Ledger::withSum('ledger_traces', 'debit')->withSum('ledger_traces', 'credit')->whereHas('account_group', function ($query) {
            $query->where('nature', 'debit')->whereIn('id', [1, 2, 3]);
        })->groupBy('id')->get();


        $getCreditLedger = Ledger::whereHas('account_group', function ($query) {
            $query->whereNotIn('id', [1, 3])->where('acc_category_id', '!=', 4);
        })->get();
        return view('pages.admin.vouchers.journal', compact('getCashLedger', 'getCreditLedger'));
    }

    public function voucherwise_report()
    {
        return view('pages.admin.core-report.voucherwise');
    }

    public function voucher_list(Request $request)
    {
        $date_from = request('date_from', Carbon::yesterday()->toDateString());
        $date_to = request('date_to', Carbon::today()->toDateString());

        // if ($request->ajax()) {
            $query = LedgerTrace::select('id', 'voucher_date', 'voucher_id', 'type', 'reference', 'description', 'invoice_no')
            ->whereBetween('voucher_date', [$date_from, $date_to])
                ->selectRaw('(SELECT SUM(credit) FROM ledger_traces WHERE ledger_traces.voucher_id = lt.voucher_id) as total_credit')
                ->selectRaw('(SELECT SUM(debit) FROM ledger_traces WHERE ledger_traces.voucher_id = lt.voucher_id) as total_debit')
                ->from('ledger_traces as lt')
                ->distinct()
                ->get();


            return datatables()
                ->of($query)
                ->addColumn('view', function ($row) {
            return "<a href='/admin/core-report/voucher/view/$row->id' class='btn btn-sm btn-info'><i class='fa fa-eye'></i></a>";
                })
                ->addIndexColumn()
                ->rawColumns(['view'])
                ->make(true);
        // }
    }


    public function settleAccount()
    {
        // $paymentInfos = PaymentInfo::whereIn('payment_type', ['online', 'manual'])->where('status', 'completed')->get();
        $paymentInfos = PaymentInfo::whereIn('payment_type', ['online'])->where('status', 'completed')->get();

        try {
            foreach ($paymentInfos as $paymentInfo) {
                foreach ($paymentInfo->feeAssign as $feeAssign) {
                    dispatch(new UpdateFeeLedgerTracesJob($feeAssign, $paymentInfo));
                }
            }
            return "Completed..............";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
