<?php

namespace App\Services\Common;

use App\Models\Member;
use App\Models\PaymentInfo;
use PDF;
use NumberFormatter;
use App\Services\BaseService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberService extends BaseService
{


    public function __construct(Member $model)
    {
        parent::__construct($model);
    }

   public function memberPdfDowload($id){
    // $member = Member::with(['associatorsInfo:member_id,membershp_number','nominee','memberChoices'])->find($id);
    // // return view('pages.admin.pdf.invoices.member-management.report.user-profile-pdf',compact('member'));
    // $pdf = PDF::loadView('pages.admin.pdf.invoices.member-management.report.user-profile-pdf', ['member' => $member]);
    //     return $pdf->download('MemberProfile_' . make8digits($member->id) . '.pdf');
   }



}
