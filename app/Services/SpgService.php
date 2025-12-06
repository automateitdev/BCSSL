<?php

namespace App\Services;

use App\Helpers\ApiResponseHelper;
use App\Models\InstituteDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SpgService
{
    protected $flexPayURL;
    protected $flexPayClient;
    protected $flexPayUser;
    protected $flexPayPassword;

    public function __construct()
    {
        $this->flexPayURL = config('app.env') === 'production'
            ? config('app.payflex')
            : config('app.payflex_uat');

        $this->flexPayUser = config('app.payflex_user');
        $this->flexPayPassword = config('app.payflex_password');
        $this->flexPayClient = Http::withBasicAuth($this->flexPayUser, $this->flexPayPassword);
    }

    public function createPayment($totalAmount, $disbursements, $invoiceData, $applicantData, $gatewayDetails): array
    {
        Log::channel('payflex_log')->info('SPG payment initiated for invoice: ' . $invoiceData['invoice']);

        // try {
        //     $datePart = substr($invoiceData['invoiceD'], -12); // last 12 chars should be date in ymdHis
        //     $invoiceDate = Carbon::createFromFormat('ymdHis', $datePart)->format('Y-m-d');
        // } catch (\Exception $e) {
        //     Log::channel('payflex_log')->error("Invoice Date format error: {$e->getMessage()}");
        //     $invoiceDate = $invoiceData->created_at->format('Y-m-d'); // fallback
        // }

        $invoiceDate = $invoiceData['invoiceDate'];
        $invoice = $invoiceData['invoice'];
        $applicantName = $applicantData['name'] ?? null;
        $applicantContact = $applicantData['contact'] ?? '00000000000';

        // Keep only digits
        $applicantContact = preg_replace('/\D/', '', $applicantContact ?? '');

        // Check length (8–15 digits)
        if (strlen($applicantContact) < 8 || strlen($applicantContact) > 15) {
            $applicantContact = str_repeat('0', 11); // fallback: 11 zeros
        }


        // Validation checks
        if (empty($applicantContact)) {
            Log::channel('payflex_log')->error("Applicant Contact can not be empty!");
            throw new Exception('Provide guardian contact to initiate payment');
        }

        if (empty($applicantName)) {
            Log::channel('payflex_log')->error("Applicant Name can not be empty!");
            throw new Exception('Provide applicant name to initiate payment');
        }


        // Call external payment API
        try {

            $authConfig = config('spg.spg_default_auth');

            ////////////////////////////////////////////////////////////////////////////////
            $response = $this->flexPayClient->post($this->flexPayURL . '/api/payment/init', [
                'pay_method'       => PaymentService::PAYMETHOD['sonali'],
                'spg_user'         => $authConfig['spg_user'],
                'spg_password'     => $authConfig['spg_password'],
                'invoice'          => $invoice,
                'invoice_date'     => $invoiceDate,
                'amount'           => $totalAmount,
                'applicantContact' => $applicantContact,
                'applicantName'    => $applicantName,
                'disbursement'     => $disbursements['accounts'] ?? [],
            ]);

            $responseData = $response->json();
            Log::channel('spg_log')->info("Response from payment init:", ['response' => $responseData]);

            if (!$response->successful()) {
                Log::channel('payflex_log')->error('Payment init failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                // Sometimes backend still says success inside `details`
                if (isset($responseData['details']['success']) && $responseData['details']['success'] === true) {
                    return [
                        'status'      => 'success',
                        'token'       => $responseData['details']['token'] ?? null,
                        'payment_url' => $responseData['details']['payment_url'] ?? null,
                        'message'     => $responseData['details']['message'] ?? 'Payment request created successfully',
                        'errors'      => [],
                    ];
                }

                throw new Exception('Payment request failed!');
            }

            // Mark invoice as pending
            $invoiceData->payment_state = PaymentService::INVOICE_STATUS['Pending'];
            $invoiceData->save();

            // Successful response
            return [
                'status'      => 'success',
                'token'       => $responseData['Token'] ?? null,
                'payment_url' => $responseData['RedirectToGateway'] ?? null,
                'message'     => $responseData['message'] ?? 'Payment request created successfully',
            ];
        } catch (\Exception $e) {
            Log::channel('payflex_log')->error('Payment request exception: ', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new Exception('Payment initiation failed');
        }
    }



    public function mapStatus(string $statusCode): string
    {
        return match ($statusCode) {
            '200'  => PaymentService::INVOICE_STATUS['Completed'],  // ✅ Success
            '400'  => PaymentService::INVOICE_STATUS['Failed'],     // ❌ Failed
            '500'  => PaymentService::INVOICE_STATUS['Processing'], // ⏳ Still processing
            '600'  => PaymentService::INVOICE_STATUS['Refunded'],   // 💸 Refunded
            '700'  => PaymentService::INVOICE_STATUS['Failed'],     // ⚠️ Technical error
            '201'  => PaymentService::INVOICE_STATUS['Unpaid'],     // ❌ Unpaid
            '401'  => PaymentService::INVOICE_STATUS['Canceled'],   // ❌ Cancelled by user
            '5017' => PaymentService::INVOICE_STATUS['Pending'],    // 📝 Manual payment pending
            '5555' => PaymentService::INVOICE_STATUS['Failed'],     // ❌ System error
            default => throw new \InvalidArgumentException(
                "Unsupported SPG status: {$statusCode}"
            ),
        };
    }
}
