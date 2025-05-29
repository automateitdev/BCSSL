<?php

namespace App\Console\Commands;

use App\Models\FeeAssign;
use App\Models\FineDate;
use App\Models\Member;
use App\Models\PaymentInfo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FeeFineCheck extends Command
{
    protected $signature = 'fine:check';
    protected $description = 'Check fee dates and apply cumulative fines for overdue payments. Suspend members after 3 overdue months.';

    // Monthly fine amount
    const MONTHLY_FINE = 100;
    const MAX_FINE_PERIOD = 3; // Maximum months for fines

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $paymentInfos = PaymentInfo::where('status', '!=', 'completed')
            ->where('payment_type', 'manual')
            ->with('paymentsInfoItems.feeAssign')
            ->get();

        // Initial processing of payment information
        foreach ($paymentInfos as $each_payment) {
            foreach ($each_payment->paymentsInfoItems as $paymentItem) {
                if ($paymentItem->feeAssign && $paymentItem->feeAssign->status == 'Paid') {
                    if ($each_payment->status == 'pending') {
                        $paymentItem->feeAssign->status = FeeAssign::STATUS_REQUEST;
                        $paymentItem->feeAssign->save();
                    } elseif ($each_payment->status == 'suspend') {
                        continue;
                    }
                }
            }
        }

        // Query for fee assignments with associated fine dates
        $feeAssigns = FeeAssign::query()
            ->with(['fineDates:id,fee_assign_id,find_date,status', 'user:id,name,status', 'fee_setup:id,fine'])
            ->select(['id', 'member_id', 'fee_setup_id', 'assign_date', 'fine_amount', 'status', 'fine_status'])
            // ->whereNull('fine_status')
            // ->where('member_id',1)
            ->where('status', '!=', FeeAssign::STATUS_PAID)
            // ->whereHas('fineDates', function ($query) {
            //     $query->where('status', '!=', FineDate::STATUS_COMPLETE);
            // })
            ->whereDoesntHave('paymentInfoItem.paymentInfo', function ($query) {
                $query->whereIn('status', ['pending', 'completed']);
            })
            ->latest()
            ->get();

        try {
            DB::beginTransaction();
            foreach ($feeAssigns as $feeAssign) {
                $fineDates = $feeAssign->fineDates->sortByDesc(function ($fineDate) {
                    Log::channel('fee_fine_check')->info("FeeAssign: {$fineDate->fee_assign_id}, FineDate: {$fineDate->find_date}, Status: {$fineDate->status}");
                    return Carbon::parse($fineDate->find_date);
                });

                $lastFineDate = $fineDates->first()->find_date ?? null;
                $overdueCount = 0;

                // Add new fine dates if the latest fine date has passed
                while ($lastFineDate && Carbon::now()->greaterThan(Carbon::parse($lastFineDate))) {
                    $newFineDate = Carbon::parse($lastFineDate)->addDays(30);
                    $feeAssign->fineDates()->create([
                        'find_date' => $newFineDate,
                    ]);
                    $lastFineDate = $newFineDate;
                    Log::channel('fee_fine_check')->info("Added new fine date: " . $newFineDate);
                }

                // Apply fines for existing fine dates
                foreach ($fineDates as $fineDate) {
                    $dueDate = Carbon::parse($fineDate->find_date);
                    if (Carbon::now()->greaterThanOrEqualTo($dueDate)) {
                        $overdueCount++;
                        Log::channel('fee_fine_check')->info("Due date {$dueDate} is overdue. Current: " . Carbon::now() . " Overdue Count: {$overdueCount}");
                        $fineDate->status = FineDate::STATUS_COMPLETE;
                        if ($fineDate->save()) {
                            Log::channel('fee_fine_check')->info("Fine date marked complete: {$fineDate->find_date}, Fee Assign: $fineDate->fee_assign_id ");
                        } else {
                            Log::channel('fee_fine_check')->error("Failed to save fine date: {$fineDate->find_date}, Fee Assign: $fineDate->fee_assign_id ");
                        }
                    } else {
                        //  Log::channel('fee_fine_check')->info("Due date {$dueDate} is not overdue. Current: " . Carbon::now());
                    }
                }

                // Calculate total fine
                $totalFine = $overdueCount * self::MONTHLY_FINE;
                $feeAssign->update([
                    'fine_status' => FeeAssign::STATUS_FINE,
                    'fine_amount' => $totalFine,
                ]);

                // Suspend member if overdue for 3+ months
                if ($overdueCount >= self::MAX_FINE_PERIOD) {
                    $member = Member::find($feeAssign->user->id);
                    $member->status = Member::STATUS_SUSPENDED;
                    $member->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::channel('fee_fine_check')->error('Error Fine Check', [
                'error_message' => $e->getMessage(),
            ]);
            DB::rollBack();
        }
        return 0;
    }
}
