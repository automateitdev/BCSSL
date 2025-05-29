<?php

namespace App\Http\Controllers\Admin\MemberManagement\Report;
set_time_limit(300);
use DataTables;
use Carbon\Carbon;
use App\Models\Member;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Common\InvoiceService;
use App\Services\Common\MemberService;
use PDF;

class MemberListController extends Controller
{
    public $memberService;
    public function __construct(MemberService $memberService){
        $this->memberService = $memberService;
        $this->middleware(['permission:Member List Edit'])->only(['memberEdit']);
        $this->middleware(['permission:Member List View'])->only(['memberList']);

    }

    public function memberList(){
        set_page_meta('Member List Report');
        // dd('memberList');
        return view('pages.admin.member-management.report.member-list');
    }

    public function memberListFetch(Request $request){
        $member = Member::query()->where('status', 'active')->with(['associatorsInfo']);

        $member = $member->latest()->get();

        return Datatables::of($member)

        ->setRowAttr([
            'align' => 'left',
        ])
        ->addColumn('membership_no', function(Member $data) {
            return $data->associatorsInfo->membershp_number ?? '';
        })
        ->addColumn('member_name', function(Member $data) {
            return $data->name ?? '';
        })
        ->addColumn('image', function(Member $data) {
            return '<img src="'.asset($data->avatar_url).'" width="50" height="50">';
        })
        ->addColumn('status', function(Member $data) {
            return member_status_badge($data->status);
        })
        ->addColumn('action', function(Member $data){

            $btn = "<div class='d-flex'><a href='" . route('admin.report.member.edit', $data->id) . "' class='edit text-info mr-1'><i class='fa fa-edit'></i></a><a href='" . route('admin.report.member.pdf', $data->id) . "' class='edit'><i class='fa fa-download'></i></a></div>";

                return $btn;
        })

        ->rawColumns(['updated_at','action','image','status'])
        ->make(true);

    }

    public function memberPdf($id){
        // return $this->memberService->memberPdfDowload($id);
        $member = Member::with(['associatorsInfo','nominee','memberChoices'])->find($id);
        // return view('pages.admin.pdf.invoices.member-management.report.user-profile-pdf',compact('member'));
        $pdf = PDF::loadView('pages.admin.pdf.invoices.member-management.report.user-profile-pdf', ['member' => $member]);
            return $pdf->download('MemberProfile_' . make8digits($member->id) . '.pdf');
    }

    public function memberEdit($id){
        set_page_meta('Member Edit');
        $member = $this->memberService->get($id,['nominee','associatorsInfo','memberChoices']);
        $user_gender = collect(User::USER_GENDER);
        return view('pages.admin.member-management.report.member-edit',compact('user_gender','member'));
        // dd($member);
    }

    public function suspended_list()
    {
        set_page_meta('Suspended');
        $users = Member::with(['associatorsInfo','nominee','memberChoices'])->where('status', 'suspended')->get();

        return view('pages.admin.member-management.suspended-list', compact('users'));
    }

}
