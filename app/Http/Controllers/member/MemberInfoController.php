<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\AccountGroup;
use App\Models\FeeAssign;
use App\Models\Member;
use App\Models\PaymentInfo;
use App\Models\User;
use Illuminate\Http\Request;
use NumberFormatter;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class MemberInfoController extends Controller
{
    public function memberInfo()
    {
        set_page_meta('Member Panel');
        $user = auth()->user();
        $member = Member::with(['feeAssigns' => function ($query) {
            $query->with(['fee_setup'])->where('status', FeeAssign::STATUS_DUE);
        }, 'associatorsInfo:member_id,membershp_number', 'nominee', 'memberProfileUpdate:id,member_id,status', 'paymentInfos', 'memberChoices'])->find($user->id);
        $assetAccReceiveBy = AccountGroup::with(['Ledgers'])->find([1, 2, 3]);
        $user_gender = collect(User::USER_GENDER);

        return view('pages.member.dashboard.member-info', compact('member', 'assetAccReceiveBy', 'user_gender'));
    }

    public function paymentInvoice($id)
    {
        $paymentInfo = PaymentInfo::query()->with(['member.associatorsInfo', 'paymentsInfoItems.feeSetup'])->find($id);
        if (isset(request()->type)) {
            if (strtolower($paymentInfo->status) != strtolower(\App\Models\PaymentInfo::STATUS_COMPLETE)) {
                return redirect()->back();
            }
        }
        $text = qr_text_generate($paymentInfo);
        // $text = $this->qr_text_generate($paymentInfo);

        $total_amount_num_to_sensts = $this->numberToSentence($paymentInfo->total_amount);
        // dd($total_amount_num_to_sensts);

        $qrcode = base64_encode(QrCode::format('png')->generate($text));
        //  dd($qrcode);

        $pdf = PDF::loadView('pages.admin.pdf.invoices.invoice', ['text' => $text, 'paymentInfo' => $paymentInfo, 'total_amount_num_to_sensts' => $total_amount_num_to_sensts, 'qrcode' => $qrcode]);
        return $pdf->download('Invoice_' . make8digits($paymentInfo->invoice_no) . '.pdf');

        // return view('pages.admin.pdf.invoices.invoice', compact('text','paymentInfo','total_amount_num_to_sensts','qrcode'));
        // $pdf = PDF::loadView('pages.admin.pdf.invoices.invoice');

        // return $pdf->download('itsolutionstuff.pdf');

    }
    public function numberToSentence($number)
    {
        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::SPELLOUT);
        return ucfirst($formatter->format($number));
    }
}
