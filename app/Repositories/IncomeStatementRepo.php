<?php

namespace App\Repositories;

use App\Models\Ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class IncomeStatementRepo
{
    public function incomeStatementSearch(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date',
        ]);

        $from = $request->from . ' 00:00:00';
        $to = $request->to . ' 23:59:59';

        $incomeledgerinfo = Ledger::whereHas('account_group', function ($query) {
            $query->whereIn('acc_category_id', [4]);
        })
            ->whereHas('ledger_traces', function ($query) use ($from, $to) {
                $query->whereBetween('voucher_date', [$from, $to]);
            })
            ->with(['ledger_traces' => function ($query) use ($from, $to) {
                $query->whereBetween('voucher_date', [$from, $to]);
            }])
            ->withSum(['ledger_traces' => function ($query) use ($from, $to) {
                $query->whereBetween('voucher_date', [$from, $to]);
            }], 'credit')
            ->withSum(['ledger_traces' => function ($query) use ($from, $to) {
                $query->whereBetween('voucher_date', [$from, $to]);
            }], 'debit')
            ->get();


        $expenseledgerinfo = Ledger::whereHas('account_group', function ($query) {
            // $query->whereNotIn('id', [1, 3])->where('acc_category_id', '!=', 4);
            $query->where('acc_category_id', 5);
        })
            ->whereHas('ledger_traces', function ($query) use ($from, $to) {
                $query->whereBetween('voucher_date', [$from, $to]);
            })
            ->with(['ledger_traces' => function ($query) use ($from, $to) {
                $query->whereBetween('voucher_date', [$from, $to]);
            }])
            ->withSum(['ledger_traces' => function ($query) use ($from, $to) {
                $query->whereBetween('voucher_date', [$from, $to]);
            }], 'credit')
            ->withSum(['ledger_traces' => function ($query) use ($from, $to) {
                $query->whereBetween('voucher_date', [$from, $to]);
            }], 'debit')
            ->get();

        // return response()->json([$incomeledgerinfo, $expenseledgerinfo]);

        // $userData = new \stdClass();
        $statementData = new stdClass();
        $statementData->incomeledgerinfo = $incomeledgerinfo;
        $statementData->expenseledgerinfo = $expenseledgerinfo;
        return $statementData;
    }
}
