<?php

namespace App\Http\Controllers\dashboard\fees_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ledger;
use App\Models\FeeSetup;

class FeeSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ledgers = Ledger::all();
        $feesetups = FeeSetup::all();
        return view('layouts.dashboard.fees_management.fee_setup.index', compact('ledgers', 'feesetups'));
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
            return redirect(route('fees.index'))->with('error', 'Fine is not more then 100.');
        }
        $month = [1,2,3,4,5,6,7,8,9,10,11,12];
        $this_year =  \Carbon\Carbon::now()->year;
        $today =  \Carbon\Carbon::now();
        $fine = ($request->amount/100) * $request->fine;

        if($request->monthly == 1)
        {
            foreach($month as $key => $allMonth)
            {
                $dt = "$this_year-$allMonth-23"; 
                $input = new FeeSetup();
                $input->fee_head = $request->fee_head;
                $input->ledger_id = $request->ledger_id;
                $input->date = date("Y-m-01", strtotime($dt));
                $input->monthly = $request->monthly;
                $input->fine = $fine;
                $input->amount = $request->amount;
                $input->save();
            }
            return redirect(route('fees.index'))->with('message', 'Data Upload Successfully');
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
            
            return redirect(route('fees.index'))->with('message', 'Data Upload Successfully');
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
