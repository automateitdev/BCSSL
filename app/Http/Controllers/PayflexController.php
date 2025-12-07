<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateFeeLedgerTracesJob;
use App\Models\FeeAssign;
use App\Models\Member;
use App\Models\PaymentInfo;
use App\Models\PaymentInfoItem;
use App\Models\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayflexController extends Controller
{
    public function handlePayFlexVerification(Request $request)
    {
        Log::channel('payflex_log')->info('Verify request: ', [$request->all()]);
        $data = $request->all();
        // Check if PayFlex has provided data
        if (empty($data['data'])) {
            return response()->json(['status' => 'error', 'message' => 'No data received'], 400);
        }

        $verification = $data['data']; // Standardized payload from PayFlex
        $invoice = $verification['InvoiceNo'] ?? null;
        if (!$invoice) {
            return response()->json(['status' => 'error', 'message' => 'Invoice missing'], 400);
        }

        return $this->processPayInvoice($invoice, $verification);
    }

    private function processPayInvoice(string $invoice, array $verification)
    {
        try {
            Log::channel('payflex_log')->info('I ENTERED IN THE INVOICE PORCESS HUHAHAHAHAHAH');
            DB::transaction(function () use ($invoice, $verification) {

                $statusCode = $verification['Status'] ?? null;

                Log::channel('payflex_log')->info("Processing invoice {$invoice} with status {$statusCode}");

                // Fetch PaymentRequest
                $paymentRequest = PaymentRequest::where('invoice', $invoice)->first();

                if (!$paymentRequest) {
                    throw new \Exception("PaymentRequest not found for invoice {$invoice}");
                }

                // Fetch Member
                $user = Member::find($paymentRequest->creator_id);

                if (!$user) {
                    throw new \Exception("Member not found (ID: {$paymentRequest->creator_id}) for invoice {$invoice}");
                }

                // Prepare PaymentInfo data
                $data = [
                    'member_id'        => $user->creator_id,
                    'payment_status'   => $statusCode,
                    'status_code'      => $statusCode,
                    'transaction_id'   => $verification['TransactionId'] ?? null,
                    'transaction_date' => $verification['TransactionDate'] ?? null,
                    'br_code'          => $verification['Branch'] ?? null,
                    'pay_mode'         => $verification['PayMode'] ?? null,
                    'payable_amount'   => $verification['RequestTotalAmount'] ?? 0,
                    'spg_pay_amount'   => $verification['CustomerPaidAmount'] ?? 0,
                    'vat'              => $verification['vat'] ?? null,
                    'commission'       => $verification['commission'] ?? null,
                    'scroll_no'        => $verification['ScrollNo'] ?? null,
                    'invoice_no'       => $invoice,
                    'session_token'    => $verification['Token'] ?? null,
                    'ledger_id'        => 1,
                    'status'           => ($statusCode == 200)
                        ? PaymentInfo::STATUS_COMPLETE
                        : PaymentInfo::STATUS_PENDING,
                ];

                // Save PaymentInfo
                $paymentInfo = PaymentInfo::create($data);

                // Collect fee assigns
                $feeAssigns = FeeAssign::whereIn('id', $paymentRequest->fee_assign_ids)->get();

                // Create PaymentInfoItems
                foreach ($feeAssigns as $feeAssign) {
                    PaymentInfoItem::create([
                        'payment_info_id' => $paymentInfo->id,
                        'fee_assign_id'   => $feeAssign->id,
                        'assign_date'     => $feeAssign->assign_date,
                        'amount'          => $feeAssign->amount,
                        'fine_amount'     => $feeAssign->fine_amount,
                        'monthly'         => $feeAssign->monthly,
                    ]);

                    // Update fee assign status
                    $feeAssign->update([
                        'status' => ($statusCode == 200)
                            ? FeeAssign::STATUS_PAID
                            : FeeAssign::STATUS_DUE
                    ]);
                }

                // Attach to user's payments
                $user->paymentCreate()->create([
                    'payment_info_id' => $paymentInfo->id
                ]);

                // Dispatch background jobs
                foreach ($paymentInfo->feeAssign as $feeAssign) {
                    dispatch(new UpdateFeeLedgerTracesJob($feeAssign, $paymentInfo));
                }

                // Update PaymentRequest
                $paymentRequest->update(['status' => $statusCode]);
            });
            return response()->json([
                'status'  => 'success',
                'message' => 'Pay invoice updated'
            ]);
        } catch (\Throwable $e) {

            Log::channel('payflex_log')->error("ERROR processing invoice {$invoice}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Internal server error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function handlePayFlexNotification(Request $request)
    {
        $response = $request->all();
        $paidInvoice = false;
        Log::channel('payflex_log')->info('IPN Request received:', $response);

        if (isset($response['invoice'])) {
            $invoiceNumber = $response['invoice'];

            $invoiceExist = PaymentRequest::where('invoice', $invoiceNumber)
                ->where('status', 200)
                ->exists();
            if ($invoiceExist) {
                $paidInvoice = true;
            }
        }

        if ($paidInvoice) {
            return response()->json(['message' => 'Invoice found and marked as paid.'], 200);
        } else {
            return response()->json(['error' => 'Invoice not updated'], 400);
        }
    }
}
