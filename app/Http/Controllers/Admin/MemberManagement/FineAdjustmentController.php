<?php

namespace App\Http\Controllers\Admin\MemberManagement;

use App\Http\Controllers\Controller;
use App\Models\FeeAssign;
use App\Models\Member;
use App\Models\PaymentInfo;
use App\Models\PaymentInfoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FineAdjustmentController extends Controller
{
    public function index()
    {
        set_page_meta('Fine Adjustment');
        // $collection = [];
        // if (isset($request->assign_date) && !empty($request->assign_date)) {
        //     $collection = FeeAssign::where('assign_date', $request->assign_date)->with('user.associatorsInfo')->get();
        // }

        $collection = Member::with('associatorsInfo')
            ->leftJoinSub(
                DB::table('fee_assigns')
                    ->selectRaw('member_id, SUM(fine_amount) as total_fine')
                    ->groupBy('member_id'),
                'fee_totals',
                'members.id',
                'fee_totals.member_id'
            )
            ->select('members.*', 'fee_totals.total_fine')
            ->get();

        // $assignDates = FeeAssign::select('assign_date')->get();


        return view('pages.admin.fees_management.payment.fine_adjust', compact('collection'));
    }

    public function view(Member  $member)
    {
        return view('pages.admin.fees_management.payment.member_fines', compact('member'));
    }

    public function update(Request $request)
    {

        $validated = $request->validate([
            'fine_adjustment' => 'required',
            'payment' => 'required|array|min:1',
        ]);
        try {
            DB::beginTransaction();
            $payment_info_ids = [];
            foreach ($request->payment as $fee_key => $payments) {
                foreach ($payments as $feeAssignID) {
                    $feeAssign = FeeAssign::findOrFail($feeAssignID);
                    $paymentItems = PaymentInfoItem::where('fee_assign_id', $feeAssignID)->get();
                    if (empty($paymentItems)) {
                        continue;
                    }
                    foreach ($paymentItems as $item) {
                        if (!in_array($item->payment_info_id, $payment_info_ids)) {
                            $payment_info_ids[] = $item->payment_info_id;
                        }
                        $item->fine_amount = $request->fine_adjustment[$fee_key];
                        $item->save();
                    }
                    $feeAssign->fine_amount = $request->fine_adjustment[$fee_key];
                    $feeAssign->save();
                }
            }

            if (count($payment_info_ids) > 0) {
                foreach ($payment_info_ids as $payment_id) {
                    $payments = PaymentInfoItem::where('payment_info_id', $payment_id)->get();
                    $totalFineAmount = $payments->sum('fine_amount');
                    $paymentInfo = PaymentInfo::findOrFail($payment_id);

                    if ($paymentInfo->status == 'suspend') {
                        continue;
                    }

                    $paymentInfo->fine_amount = $totalFineAmount;
                    $paymentInfo->total_amount = $paymentInfo->payable_amount + $totalFineAmount;
                    $paymentInfo->save();
                }
            }
            DB::commit();
            record_created_flash('Fine adjustment updated successfully');
            return redirect()->back()->with('message', 'Fine adjustment updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to adjust fine due to: $e");
            return redirect()->back()->with('error', 'An unexpected error occured!');
        }
    }
}
