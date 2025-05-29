<?php

namespace App\Console\Commands;

use App\Models\Ledger;
use App\Models\LedgerTrace;
use App\Models\PaymentInfo;
use Illuminate\Console\Command;

class LedgerBackfillFineTraces extends Command
{
    protected $signature = 'ledger:backfill-fine-traces';

    protected $description = 'Backfill ledger traces for fine amounts that were not previously inserted';

    public function handle()
    {
        $FINE_LEDGER_ID = 6; // Replace with actual Fine Ledger ID if different

        $this->info("Starting fine trace backfill...");

        // Get all invoice_nos already traced in the fine ledger
        $existingTracedInvoices = LedgerTrace::where('ledger_id', $FINE_LEDGER_ID)
            ->pluck('invoice_no')
            ->toArray();

        // Get all payment records with fine amounts and not already traced
        $payments = PaymentInfo::with(['feeAssign.fee_setup', 'feeAssign.user.associatorsInfo', 'ledger'])
            ->whereNotIn('invoice_no', $existingTracedInvoices)
            ->get();

        $bar = $this->output->createProgressBar($payments->count());
        $bar->start();

        $count = 0;

        foreach ($payments as $payment) {
            foreach ($payment->feeAssign as $feeAssign) {
                if ($feeAssign->fine_amount <= 0) {
                    continue;
                }

                $feeHead = optional($feeAssign->fee_setup)->fee_head;
                $memberId = optional($feeAssign->user->associatorsInfo)->membershp_number;
                $amount = $feeAssign->fine_amount;
                $invoiceNo = $payment->invoice_no;

                $voucherPrefix = $payment->payment_type === 'manual' ? 'VM' : 'VO';
                $voucherId = $voucherPrefix . preg_replace('/[^0-9]/', '', $invoiceNo);

                // Credit to Fine Ledger
                LedgerTrace::create([
                    'type' => $payment->payment_type,
                    'voucher_id' => $voucherId,
                    'invoice_no' => $invoiceNo,
                    'ledger_id' => $FINE_LEDGER_ID,
                    'feehead_id' => $feeAssign->fee_setup->id ?? null,
                    'credit' => $amount,
                    'reference' => 'Fine Collection',
                    'description' => "`$feeHead` fine: `$amount`, member id: `$memberId`, credited to Fine ledger",
                    'voucher_date' => $payment->payment_date,
                ]);

                // Debit from Payment Ledger (fallback to SBL Ledger ID 1 if missing)
                $debitLedger = $payment->ledger ?? Ledger::find(1);

                LedgerTrace::create([
                    'type' => $payment->payment_type,
                    'voucher_id' => $voucherId,
                    'invoice_no' => $invoiceNo,
                    'ledger_id' => $debitLedger->id,
                    'feehead_id' => $feeAssign->fee_setup->id ?? null,
                    'debit' => $amount,
                    'reference' => 'Fine Payment',
                    'description' => "`$feeHead` fine: `$amount`, member id: `$memberId`, debited from `{$debitLedger->ledger_name}`",
                    'voucher_date' => $payment->payment_date,
                ]);

                $count++;
            }

            $bar->advance();
        }

        $bar->finish();

        $this->newLine();
        $this->info("Backfill complete. Total fine traces added: {$count}");

        return Command::SUCCESS;
    }
}
