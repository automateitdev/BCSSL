<?php

namespace App\Services\Common;

use App\Models\LedgerTrace;
use NumberFormatter;
use App\Services\BaseService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VoucherService extends BaseService
{
    public function __construct(LedgerTrace $model)
    {
        parent::__construct($model);
    }

    public function voucherView($voucher_id)
    {
        $traces = $this->model::query()->where('voucher_id', $voucher_id)
            ->with(['ledger', 'feehead'])
            ->get();
        // $text = qr_text_generate($traces);
        // $text = $this->qr_text_generate($paymentInfo);

        // $total_amount_num_to_sensts = $this->numberToSentence($paymentInfo->total_amount);
        // dd($total_amount_num_to_sensts);

        // $qrcode = base64_encode(QrCode::format('png')->generate($text));

        return  ['traces' => $traces];
    }

    public function numberToSentence($number)
    {
        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::SPELLOUT);
        return ucfirst($formatter->format($number));
    }
}
