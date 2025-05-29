<?php

namespace App\Jobs;

use App\Models\Ledger;
use App\Models\LedgerTrace;
use App\Models\PaymentInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;

class UpdateFeeLedgerTracesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $paymentDate;
    protected $feeAssign;
    protected $paymentInfo;

    public function __construct($feeAssign, $paymentInfo)
    {
        $this->feeAssign = $feeAssign;
        $this->paymentInfo = $paymentInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $feeHead = $this->feeAssign->fee_setup->fee_head;
            $creditLedgerName = $this->feeAssign->fee_setup->ledger->ledger_name;
            $member_id = $this->feeAssign->user->associatorsInfo->membershp_number;
            $amount = $this->feeAssign->amount;

            $creditDescription = "`$feeHead` : `$amount`, member id: `$member_id`, credited to `$creditLedgerName` ledger";

            $this->paymentInfo->payment_type == 'manual' ? $vouch = 'VM' : $vouch = 'VO';

            if (strpos($this->paymentInfo->invoice_no, 'INV') !== false) {
                $invoice_digit = substr($this->paymentInfo->invoice_no, strpos($this->paymentInfo->invoice_no, 'INV') + 3);
            }
            // $previously_saved = LedgerTrace::where('invoice_no', $this->paymentInfo->invoice_no)->get();

            // if (count($previously_saved) > 2) {
            //     Log::channel('fee_ledger_traces')->error('Error updating fee ledger traces.', [
            //         'error_message' => "Prevoiously Saved",
            //         'Payment Info ID:' => $this->paymentInfo->id,
            //         'Fee Assign ID' => $this->feeAssign->id,
            //         'Invoice No.' => $this->paymentInfo->invoice_no,
            //         'count_in_ledger_traces' => count($previously_saved)
            //     ]);
            //     return;
            // }

            $creditInput = new LedgerTrace();
            $creditInput->type = $this->paymentInfo->payment_type;
            $creditInput->voucher_id = $vouch . (isset($invoice_digit) ? $invoice_digit : $this->paymentInfo->invoice_no);
            $creditInput->invoice_no = $this->paymentInfo->invoice_no;
            $creditInput->ledger_id = $this->feeAssign->fee_setup->ledger_id;
            $creditInput->feehead_id = $this->feeAssign->fee_setup->id;
            $creditInput->credit = $this->feeAssign->amount;
            $creditInput->reference = 'Fee Collection';
            $creditInput->description = $creditDescription;
            $creditInput->voucher_date = $this->paymentInfo->payment_date;
            $creditInput->save();

            if ($this->paymentInfo->payment_type == 'online' && empty($this->paymentInfo->ledger)) {
                $ledgerInfo = Ledger::find(1); // SBL - because only SPG is active for online payment
                $debitLedgerName = $ledgerInfo->ledger_name;
                $debitDescription = "`$feeHead` : `$amount`, member id: `$member_id`, debited to `$debitLedgerName` ledger";
                $debitLedgerId = $ledgerInfo->id;
            } else {
            $debitLedgerName = $this->paymentInfo->ledger->ledger_name;
            $debitDescription = "`$feeHead` : `$amount`, member id: `$member_id`, debited to `$debitLedgerName` ledger";
                $debitLedgerId = $this->paymentInfo->ladger_id;
            }


            $debitInput = new LedgerTrace();
            $debitInput->type = $this->paymentInfo->payment_type;
            $debitInput->voucher_id = $vouch . (isset($invoice_digit) ? $invoice_digit : $this->paymentInfo->invoice_no);
            $debitInput->invoice_no = $this->paymentInfo->invoice_no;
            $debitInput->ledger_id = $debitLedgerId;
            $debitInput->feehead_id = $this->feeAssign->fee_setup->id;
            $debitInput->debit = $this->feeAssign->amount;
            $debitInput->reference = 'Fee';
            $debitInput->description = $debitDescription;
            $debitInput->voucher_date = $this->paymentInfo->payment_date;
            $debitInput->save();

            if (!empty($this->feeAssign->fine_amount) && $this->feeAssign->fine_amount > 0) {
                $fineAmount = $this->feeAssign->fine_amount;

                // 1. Credit Entry - Fine is credited to Fine Ledger
                $fineLedger = Ledger::where('id', 6)->first(); // Replace with exact logic

                if (!$fineLedger) {
                    Log::channel('fee_ledger_traces')->warning('Fine ledger not found.', [
                        'Payment Info ID:' => $this->paymentInfo->id,
                        'Fee Assign ID' => $this->feeAssign->id,
                    ]);
                    return;
                }

                $fineLedgerId = $fineLedger->id;
                $fineLedgerName = $fineLedger->ledger_name;
                $voucherId = $vouch . (isset($invoice_digit) ? $invoice_digit : $this->paymentInfo->invoice_no);

                $creditFine = new LedgerTrace();
                $creditFine->type = $this->paymentInfo->payment_type;
                $creditFine->voucher_id = $voucherId;
                $creditFine->invoice_no = $this->paymentInfo->invoice_no;
                $creditFine->ledger_id = $fineLedgerId;
                $creditFine->feehead_id =  $this->feeAssign->fee_setup->id;
                $creditFine->credit = $fineAmount;
                $creditFine->reference = 'Fine Collection';
                $creditFine->description = "`Fine` : `$fineAmount`, member id: `$member_id`, credited to `$fineLedgerName` ledger";
                $creditFine->voucher_date = $this->paymentInfo->payment_date;
                $creditFine->save();

                // 2. Debit Entry - From payment source (bank/cash/online)
                if ($this->paymentInfo->payment_type == 'online' && empty($this->paymentInfo->ledger)) {
                    $paymentLedger = Ledger::find(1); // SBL - because only SPG is active for online payment
                } else {
                    $paymentLedger = $this->paymentInfo->ledger;
                }

                if ($paymentLedger) {
                    $debitFine = new LedgerTrace();
                    $debitFine->type = $this->paymentInfo->payment_type;
                    $debitFine->voucher_id = $voucherId;
                    $debitFine->invoice_no = $this->paymentInfo->invoice_no;
                    $debitFine->ledger_id = $paymentLedger->id;
                    $debitFine->feehead_id =  $this->feeAssign->fee_setup->id;
                    $debitFine->debit = $fineAmount;
                    $debitFine->reference = 'Fine Payment';
                    $debitFine->description = "`Fine` : `$fineAmount`, member id: `$member_id`, debited from `" . $paymentLedger->ledger_name . "` ledger";
                    $debitFine->voucher_date = $this->paymentInfo->payment_date;
                    $debitFine->save();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('fee_ledger_traces')->error('Error updating fee ledger traces.', [
                'error_message' => $e,
                'Payment Info ID:' => $this->paymentInfo->id,
                'Fee Assign ID' => $this->feeAssign->id,
            ]);
        }
    }
}
