<?php

namespace App\Http\Controllers\Admin\AccountManagement\account;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountGroup;
use App\Models\AccountCategory;
use App\Models\FeeSetup;
use App\Models\Ledger;

class LedgerController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:Create Ledger View'])->only(['index']);
        $this->middleware(['permission:Create Ledger Add'])->only(['store']);
    }


    public function index()
    {
        $accgroups = AccountGroup::all();
        $acccats = AccountCategory::all();
        $ledgers = Ledger::with('account_group', 'account_group.account_category')->get();
        return view('pages.admin.account.setup.index', compact('accgroups', 'acccats', 'ledgers'));
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
        return redirect(route('admin.ledger.index'))->with('message', 'Ledger Upload Successfully.');
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
