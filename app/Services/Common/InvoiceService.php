<?php

namespace App\Services\Common;

use App\Models\PaymentInfo;
use PDF;
use NumberFormatter;
use App\Services\BaseService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvoiceService extends BaseService
{
    public function __construct(PaymentInfo $model)
    {
        parent::__construct($model);
    }

    public function invoiceView($id){
        $paymentInfo =$this->model::query()->with(['member.associatorsInfo','paymentsInfoItems.feeSetup'])->find($id);
        // dd($paymentInfo);
        $text = qr_text_generate($paymentInfo);
        // $text = $this->qr_text_generate($paymentInfo);

        $total_amount_num_to_sensts = $this->numberToSentence($paymentInfo->total_amount);
        // dd($total_amount_num_to_sensts);

         $qrcode = base64_encode(QrCode::format('png')->generate($text));

        return  ['text' => $text,'paymentInfo'=>$paymentInfo,'total_amount_num_to_sensts'=>$total_amount_num_to_sensts,'qrcode'=>$qrcode];
    }

    public function numberToSentence($number)
    {
        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::SPELLOUT);
        return ucfirst($formatter->format($number));
    }



}
