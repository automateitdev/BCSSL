<?php

namespace App\Http\Controllers\Admin\manualFix;

use App\Http\Controllers\Controller;
use App\Models\FeeAssign;
use App\Models\PaymentInfo;
use App\Models\PaymentInfoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FixController extends Controller
{
    // Adjust the payment_infos fine from payment_info_items entry
    public function paymentInfoFineAdjust()
    {
        $paymentInfos = PaymentInfo::where('status', '!=', 'suspend')->get();

        try {
            DB::beginTransaction();
            foreach ($paymentInfos as $info) {
                // Eager load paymentInfoItems relationship
                // $payInfoItems = $info->load('paymentsInfoItems');

                foreach ($info->paymentsInfoItems as $item) {
                    $feeAssign =  FeeAssign::where('id', $item->fee_assign_id)->first();
                    if (!empty($feeAssign)) {
                        $feeAssign->fine_amount = $item->fine_amount;
                        $feeAssign->save();
                    }
                }
                // Sum the 'fine_amount' for the related PaymentInfoItem objects
                $totalFineAmount = $info->paymentsInfoItems->sum('fine_amount');

                $info->fine_amount = $totalFineAmount;
                $info->total_amount = $info->payable_amount + $totalFineAmount;
                $info->save();
            }
            DB::commit();

            return response()->json("updated successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed, Payment Info fine adjust: $e");
            return response()->json($e->getMessage());
        }
    }
}
