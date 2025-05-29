<?php

namespace App\Http\Controllers\Admin\MemberManagement;


use Datatables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{

    public function __construct()
    {

        $this->middleware(['permission:Registration Add'])->only(['registration']);

    }

    public function registration(){
        set_page_meta('Member Registration');
        $user_gender = collect(User::USER_GENDER);
        $user_blood_group = collect(User::USER_BLOOD_GROUP);
        return view('pages.admin.member-management.member-registration', compact('user_gender', 'user_blood_group'));
    }



}
