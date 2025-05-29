<?php

namespace App\Http\Controllers\Admin\MemberManagement;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\AssociatorsInfo;
use App\Http\Controllers\Controller;

class AssociatorInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Associators Info View'])->only(['index']);
        $this->middleware(['permission:Associators Info Edit'])->only(['edit','update']);
    }
    public function index()
    {
        set_page_meta('Associators Info');
        $assoc_infos = AssociatorsInfo::with(['user'])->whereHas('user', function($query){
            $query->where('status', Member::STATUS_ACTIVE);
        })->get();
        return view('pages.admin.member-management.associator-info.index',compact('assoc_infos'));

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
        //
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
        set_page_meta('Associators Edit');
        $assoc_info = AssociatorsInfo::with(['user'])->find($id);
        return view('pages.admin.member-management.associator-info.edit',compact('assoc_info'));

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
        $validated = $request->validate([
            'membershp_number' => 'required',
            'approval_date' => 'required|date',
            'num_or_shares' => 'required|numeric',
        ]);

        $assoc_info = AssociatorsInfo::find($id);
        $assoc_info->membershp_number = $request->membershp_number;
        $assoc_info->approval_date = $request->approval_date;
        $assoc_info->num_or_shares = $request->num_or_shares;
        $assoc_info->updated_at = Carbon::now();
        if($assoc_info->save()){
            record_created_flash('Associator Info update Sucessfully');
            return redirect()->route('admin.associators-info.index');
        }
    }

    public function infoUpdate(Request $request, $id){
        // dd($request->all());
        $validated = $request->validate([
            'membershp_number' => 'required',
            'approval_date' => 'required|date',
            'num_or_shares' => 'required|numeric',
        ]);
        $assoc_info = AssociatorsInfo::find($id);
        $assoc_info->membershp_number = $request->membershp_number;
        $assoc_info->approval_date = $request->approval_date;
        $assoc_info->num_or_shares = $request->num_or_shares;
        $assoc_info->updated_at = Carbon::now();
        if($assoc_info->save()){
            record_created_flash('Associator Info update Sucessfully');
            return response()->json([
                'status' => 'success'
            ]);
        }
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
