<?php

namespace App\Http\Controllers\Admin\FeesManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ledger;
use App\Models\FeeSetup;

class FeeSetupController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:Fee Setup View'])->only(['index']);
        $this->middleware(['permission:Fee Setup Add'])->only(['store']);
    }

    public function index()
    {
        $ledgers = Ledger::where('acc_group_id',Ledger::AG_INCOME_FOR_FEE_ID)->get();
        $feesetups = FeeSetup::all();

        return view('pages.admin.fees_management.fee-setup.index', compact('ledgers', 'feesetups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request,[
            'fee_head' => 'required',
            'ledger_id' => 'required',
            'amount' => 'required'
        ]);

        if($request->fine > 100)
        {
            return redirect(route('admin.fees.index'))->with('error', 'Fine is not more then 100.');
        }
        $month = [1,2,3,4,5,6,7,8,9,10,11,12];
        $this_year =  \Carbon\Carbon::now()->year;
        $today =  \Carbon\Carbon::now();
        $fine = ($request->amount/100) * $request->fine;

        if($request->monthly == 1)
        {

                $input = new FeeSetup();
                $input->fee_head = $request->fee_head;
                $input->ledger_id = $request->ledger_id;
                $input->monthly = $request->monthly;
                $input->fine = $fine;
                $input->amount = $request->amount;
                $input->save();
            return redirect(route('admin.fees.index'))->with('message', 'Data Upload Successfully');
        }
        if($request->monthly == 0)
        {
                $input = new FeeSetup();
                $input->fee_head = $request->fee_head;
                $input->ledger_id = $request->ledger_id;
                $input->date = $request->date;
                $input->monthly = $request->monthly;
                $input->fine = $fine;
                $input->amount = $request->amount;
                $input->save();

            return redirect(route('admin.fees.index'))->with('message', 'Data Upload Successfully');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
