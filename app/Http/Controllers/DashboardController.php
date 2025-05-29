<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:Deashboard View'])->only(['index']);

    }
    public function index(){
        $active_member = Member::where('status',Member::STATUS_ACTIVE)->count();
        $inactive_member = Member::where('status',Member::STATUS_INACTIVE)->count();
        $suspend_member = Member::where('status',Member::STATUS_SUSPENDED)->count();

        $complete_invoice = PaymentInfo::where('status', PaymentInfo::STATUS_COMPLETE)->count();
        $pending_invoice = PaymentInfo::where('status', PaymentInfo::STATUS_PENDING)->count();
        $suspend_invoice = PaymentInfo::where('status', PaymentInfo::STATUS_SUSPEND)->count();
        // dd($active_member, $inactive_member, $suspend_member);

        return view("pages.dashboard.index", compact('active_member','inactive_member','suspend_member','complete_invoice','pending_invoice','suspend_invoice'));
    }
}
