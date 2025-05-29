<?php

namespace App\Http\Controllers\Admin\FeesManagement;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;
use App\Models\FeeSetup;
use App\Models\FeeAssign;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeeAssignRequest;
use App\Models\FineDate;

class FeeAssignController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:Fee Assign View'])->only(['index']);
        $this->middleware(['permission:Associators Info Edit'])->only(['approvalUpdate']);
    }


    public function index(){
        set_page_meta('Fee Assign');
        $feesetups = FeeSetup::all();
        $members = Member::with(['feeAssigns','feeAssigns.fee_setup','associatorsInfo:id,member_id,membershp_number'])->where('status',User::STATUS_ACTIVE)->latest()->get();

        return view('pages.admin.fees_management.fee-assign.index',compact('feesetups','members'));
    }

    public function getFeeSetup($id){
        return FeeSetup::find($id);
    }

    public function feeAssignStore(Request $request){

        // dd($request->all());
        $fee_setup = FeeSetup::find($request->fee_setup_id);
        try {
            DB::beginTransaction();
            if($fee_setup->monthly){
                $data = $request->validate([
                    'fee_setup_id' => 'required|numeric',
                    'fine_date' => 'required',
                    'month_id' => 'required',
                    'month_id.*' => 'required',
                    'user_id' => 'required',
                    'user_id.*' => 'required',
                    'years' => 'required',
                    'years.*' => 'required',
                ]);
                // dd($data);
                foreach($data['user_id'] as $user_id){
                    foreach($data['years'] as $year){
                        foreach($data['month_id'] as $month_id){
                            $assign_date_string = $year."-".$month_id."-1";
                            $fine_date_string = $year."-".$month_id."-".$request->fine_date;
                            $assign_date = Carbon::parse($assign_date_string)->format('Y-m-d');
                            //fine first date
                            $find_date = Carbon::parse($fine_date_string);
                            // $find_date = Carbon::parse($fine_date_string)->format('Y-m-d');
                            // dd( $find_date->format("Y-m-d H:i:s"));

                            $fee_assign = FeeAssign::where('member_id', $user_id)->where('fee_setup_id',$data['fee_setup_id'])->whereDate('assign_date',$assign_date)->first();
                            if(is_null($fee_assign)){
                                $fee_assign = FeeAssign::create([
                                    'member_id' => $user_id,
                                    'fee_setup_id' =>$fee_setup->id,
                                    'assign_date' => $assign_date,
                                    'fine_date' => $find_date,
                                    'monthly'=> 1,
                                    'amount' => $fee_setup->amount,
                                    'status' => FeeAssign::STATUS_DUE,
                                    'fine_amount' => NULL
                                ]);
                                $this->find_assign($fee_assign, $find_date);
                            }

                        }
                    }

                }

            }else{
                foreach($request->user_id as $user_id){
                    $data = $request->validate([
                        'fee_setup_id' => 'required|numeric',
                        'fine_assign_date' => 'required',
                        'month_id' => 'nullable',
                        'month_id.*' => 'nullable',
                        'user_id' => 'required',
                        'user_id.*' => 'required',
                        'years' => 'nullable',
                        'years.*' => 'nullable',
                    ]);
                    $find_date = Carbon::parse($request->fine_assign_date);
                    // dd($find_date);
                    $fee_assign = FeeAssign::where('member_id', $user_id)->where('fee_setup_id',$data['fee_setup_id'])->whereDate('assign_date',$fee_setup->date)->first();
                    if(is_null($fee_assign)){
                       $fee_assign = FeeAssign::create([
                            'member_id' => $user_id,
                            'fee_setup_id' =>$fee_setup->id,
                            'assign_date' =>$fee_setup->date,
                            'fine_date' => $find_date,
                            'monthly'=> 0,
                            'amount' => $fee_setup->amount,
                            'status' => FeeAssign::STATUS_DUE,
                            'fine_amount' => NULL
                        ]);
                        $this->find_assign($fee_assign, $find_date);
                    }
                }
            }
            DB::commit();
            record_created_flash('Data Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            something_wrong_flash($e->getMessage());
            // dd($e->getMessage());
            //throw $th;
        }


        return redirect(route('admin.fees.assign'));
    }

    public function find_assign($fee_assign, $find_date){

        // ################## Fee assgin wise find date assign ##################
        // first dete assign
        $fee_assign->fineDates()->create([
            'find_date' => $find_date
        ]);

        // for($i=1;$i<=3;$i++){
        //     $days = 30 * $i;

        //     $newDateTime = Carbon::parse($find_date)->addDay($days);
        //     $fee_assign->fineDates()->create([
        //         'find_date' => $newDateTime
        //     ]);
        // }


        // $fee_assign->fineDates()->create([
        //     'find_date' => Carbon::now()
        // ]);

        //     //test
        // for($i=1;$i<=3;$i++){
        //     $days = 2 * $i;
        //     $newDateTime = Carbon::now()->addMinute($days);
        //     $fee_assign->fineDates()->create([
        //         'find_date' => $newDateTime
        //     ]);
        // }

    }

    public function fineDateSetup(){
        $feeAssigns = FeeAssign::query()
        ->where('status','!=',FeeAssign::STATUS_PAID)
        ->doesntHave('fineDates')
        ->latest()->get();
        foreach($feeAssigns as $feeAssign){
            $find_date = Carbon::parse($feeAssign->fine_date);
            $this->find_assign($feeAssign, $find_date);
        }

        return 'fine-date-auto-setup';
        // dd($feeAssigns);
    }

    public function updateFineDates()
    {
        // Fetch fee assigns with non-empty assign_date and empty fine_date
        $feeAssigns = FeeAssign::whereNotNull('assign_date')
        ->whereNull('fine_date')
        ->get();

        foreach ($feeAssigns as $feeAssign) {
            // Calculate the fine_date (21 days after assign_date)
            $fineDate = Carbon::parse($feeAssign->assign_date)->addDays(20);

            // Check if fine_date already exists for the fee_assign_id
            $existingFineDate = FineDate::where('fee_assign_id', $feeAssign->id)
                ->whereDate('find_date', $fineDate)
                ->first();

            if (!$existingFineDate) {
                // Insert the fine date with status incomplete
                FineDate::create([
                    'fee_assign_id' => $feeAssign->id,
                    'find_date' => $fineDate,
                    'status' => 'incomplete',
                ]);
            }

            // Update the fine_date in fee_assigns table
            $feeAssign->fine_date = $fineDate;
            $feeAssign->save();
        }

        return response()->json(['message' => 'Fine dates updated successfully.']);
    }
}
