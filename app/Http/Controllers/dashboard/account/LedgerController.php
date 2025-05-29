<?php

namespace App\Http\Controllers\dashboard\account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountGroup;
use App\Models\AccountCategory;
use App\Models\Ledger;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accgroups = AccountGroup::all();
        $acccats = AccountCategory::all();
        return view('layouts.dashboard.account.setup.index', compact('accgroups', 'acccats'));
    }

    public function getAccountGroup(Request $request)
    {
        $data = AccountGroup::select('group_name', 'id')->where('acc_category_id', $request->id)->get();
        return response()->json($data);
    }

    public function getAccountGroupnote(Request $request)
    {
        $data = AccountGroup::select('note')->where('id', $request->id)->first();
        return response()->json($data->note);
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
            'acc_group_id' => 'required',
            'ledger_name' => 'required'
        ]);

        $input = new Ledger();
        $input->acc_group_id = $request->acc_group_id;
        $input->ledger_name = $request->ledger_name;
        $input->save();
        return redirect(route('ledger.index'))->with('message', 'Ledger Upload Successfully.');
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
