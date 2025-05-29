<?php

namespace App\Http\Controllers\sms;

use App\Models\SmsTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $smstemps = SmsTemplate::all();
        return view('pages.admin.sms.create.template.index', compact('smstemps'));
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
        $this->validate($request,[
            'title'=> 'required',
            'sms'=> 'required'
        ]);

        $input = new SmsTemplate();
        $input->title = $request->title;
        $input->sms = $request->sms;
        $input->save();
        
        return redirect(route('admin.sms.temp.index'))->with('message', 'SMS Upload Successfully');
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
        $data = SmsTemplate::find($id);
        return view('layouts.dashboard.sms.create.template.edit', compact('data'));
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
        $input = SmsTemplate::find($id);
        $input->title = $request->title;
        $input->sms = $request->sms;
        $input->save();

        return redirect(route('admin.sms.temp.index'))->with('message', 'SMS Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SmsTemplate::find($id)->delete();
        return redirect()->back();
    }
}
