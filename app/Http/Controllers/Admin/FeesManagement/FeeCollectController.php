<?php

namespace App\Http\Controllers\Admin\FeesManagement;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;
use App\Models\FeeSetup;
use App\Models\FeeAssign;
use App\Models\PaymentInfo;
use App\Models\AccountGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeeAssignRequest;
use Illuminate\Support\Facades\Route;

class FeeCollectController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:Fee Collection View'])->only(['index']);
        $this->middleware(['permission:Quick Collection View'])->only(['quickCollection']);

    }

    public function index(){
        set_page_meta('Fee Collections');

        $members = Member::query()
        ->with(['associatorsInfo:id,member_id,membershp_number','feeAssigns'=> function($query){
            $query->where('status',FeeAssign::STATUS_DUE);
        }])->where('status',User::STATUS_ACTIVE)
        // ->whereHas('feeAssigns', function($query){
        //     $query->where('status',FeeAssign::STATUS_DUE);
        // })
        ->latest()->get();
            // dd($members);
        return view('pages.admin.fees_management.fee-collection.index',compact('members'));
    }

    public function quickCollection($id){
        set_page_meta(' Quick Collection View');
         $member = Member::with(['feeAssigns'=> function($query){
            $query->with(['fee_setup'])->where('status',FeeAssign::STATUS_DUE);
        },'associatorsInfo:member_id,membershp_number'])->find($id);
        $asset_acc_receive_by = AccountGroup::with(['Ledgers'])->find([1,2,3]);
        $paymentInfos = PaymentInfo::where('member_id', $id)->latest()->get();

        // dd(Route::is('admin.fees.quick.collection'), \Request::route()->getName(), in_array(\Request::route()->getName(),['admin.member.registration','admin.associators-info.index','admin.approval.list','admin.report.member.list']));

        return view('pages.admin.fees_management.fee-collection.quick-collection', compact('member','asset_acc_receive_by','paymentInfos'));

    }


}
