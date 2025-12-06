<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class PaymentService
{
    // protected ?BkashService $bkashService = null;
    protected ?SpgService $spgService = null;
    // protected ?SslService $sslService = null;

    protected string $flexPayURL;
    protected string $flexPayUser;
    protected string $flexPayPassword;

    const CURRENCY = [
        "BDT" => "BDT",
        "USD" => "USD",
        "GBP" => "GBP",
        "EUR" => "EUR",
        "SGD" => "SGD",
        "MYR" => "MYR",
        "INR" => "INR",
    ];

    const PAYSTATUS = [
        "Unpaid" => 'UNPAID',
        "Removed" => 'REMOVED',
        "Paid" => 'PAID',
        "Refunded" => 'REFUNDED',
        "Omitted" => 'OMITTED',
        "Due" => 'DUE',
        "Rejected" => 'REJECTED'
    ];

    // SEQUENCE: 1.INTENDED
    // (if successful to hit gateway)
    // 2. PENDING (Until Gateway responded).
    // 3. Post Processing from gateway response:  PROCESSING, COMPLETED, CANCELED, FAILED, REFUNDED

    const INVOICE_STATUS = [
        "Intended" => "INTENDED",
        "Pending" => "PENDING",
        "Processing" => "PROCESSING",
        "Completed" => "COMPLETED",
        "Canceled" => "CANCELED",
        "Failed" => "FAILED",
        "Refunded" => "REFUNDED"
    ];

    const PAYTYPE = [
        "Online" => "online",
        "Offline" => "offline",
    ];

    const PAYMETHOD = [
        "sonali" => "SPG",
        "sslcommerz" => "SSL",
        "bkash" => "BKASH",
        "quick collection" => "QC"
    ];

    public function __construct()
    {
        $this->flexPayURL = config('app.env') === 'production'
            ? config('app.payflex')
            : config('app.payflex_uat');

        $this->flexPayUser = config('app.payflex_user');
        $this->flexPayPassword = config('app.payflex_password');

        Log::channel('payflex_log')->debug("PaymentService initialized");
    }

    /**
     * Lazy-load gateway services only when needed
     */
    // protected function getBkashService(): BkashService
    // {
    //     return $this->bkashService ??= app(BkashService::class);
    // }

    protected function getSpgService(): SpgService
    {
        return $this->spgService ??= app(SpgService::class);
    }

    // protected function getSslService(): SslService
    // {
    //     return $this->sslService ??= app(SslService::class);
    // }

    /**
     * Initiate payment through a specific gateway
     */
    public function initiateGatewayPayment($gateway, $gatewayDetails, $applicantData, $totalAmount, $disbursements = [], $invoiceData = [])
    {
        dd($invoiceData);
        switch ($gateway) {
            case self::PAYMETHOD['sonali']:
                return $this->getSpgService()->createPayment($totalAmount, $disbursements, $invoiceData, $applicantData, $gatewayDetails);

            // case self::PAYMETHOD['sslcommerz']:
            //     return $this->getSslService()->createPayment($totalAmount, $disbursements, $invoiceData, $applicantData, $gatewayDetails);

            // case self::PAYMETHOD['bkash']:
            //     return $this->getBkashService()->createPayment($totalAmount, $invoiceData, $applicantData, $gatewayDetails);

            default:
                throw new \InvalidArgumentException("Unsupported payment gateway: {$gateway}");
        }
    }
}
