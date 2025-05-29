<?php

namespace App\Http\Controllers\sms;

use App\Models\SmsRecharge;
use Illuminate\Http\Request;
use ShurjopayPlugin\Shurjopay;
use App\Models\SmsPurchaseDetails;
use ShurjopayPlugin\PaymentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SmsSettingsController extends Controller
{
    public $sp_instance;
    /* Shurjopay injected in a constructor */
    public function __construct(Shurjopay $sp)
    {
        $this->sp_instance = $sp;
    }

    public function smsrecharge(Request $request)
    {
        // dd(Auth::user());
        $this->validate($request, [
            'sms_quantity' => 'required',
        ]);

        $final_price = $request->sms_quantity * 0.30;
        
        $payment_request = new PaymentRequest();

        $payment_request->currency = 'BDT';
        $payment_request->amount = $final_price;
        $payment_request->customerName = "COCSOL";
        $payment_request->customerPhone = Auth::user()->mobile;
        $payment_request->customerEmail = Auth::user()->email;
        $payment_request->customerAddress = "738, 2/B, Ibrahimpur, Kafrul, Dhaka";
        $payment_request->customerCity = "Dhaka";
        $payment_request->customerState = "Dhaka";
        $payment_request->value1 = $request->sms_quantity;

        return $this->sp_instance->makePayment($payment_request);
    }

    public function confirm(Request $request)
    {
        $data = $this->sp_instance->verifyPayment($request->order_id);
        if(empty($data[0]->customer_order_id) && empty($data[0]->invoice_no))
        {
            return redirect(route('admin.sms.purchase.index'))->with('error', 'SMS Purchase Canceled');
        }
        $sms_details = new SmsPurchaseDetails();
        $sms_details->order_id = $data[0]->order_id;
        $sms_details->customer_order_id = $data[0]->customer_order_id;
        $sms_details->amount = $data[0]->recived_amount;
        $sms_details->invoice_no = $data[0]->invoice_no;
        $sms_details->sp_message = $data[0]->sp_message;
        $sms_details->method = $data[0]->method;
        $sms_details->date_time = $data[0]->date_time;
        $sms_details->save();

        $mit = SmsRecharge::first();

        if (empty($mit->sms_quantity)) {
            if ($data[0]->sp_message == "Success") {
                $input = SmsRecharge::updateOrCreate(
                    ['sms_quantity' => $data[0]->value1]
                );
                return redirect(route('admin.sms.purchase.index'))->with('message', 'SMS Purchase Successfully');
            }
        } else {
            if ($data[0]->sp_message == "Success") {
                $input = SmsRecharge::updateOrCreate(
                    ['sms_quantity' => $mit->sms_quantity + $data[0]->value1]
                );
                return redirect(route('admin.sms.purchase.index'))->with('message', 'SMS Purchase Successfully');
            }
        }
        return redirect(route('admin.sms.purchase.index'))->with('error', 'SMS Purchase Closed');
    }
    
    public function smsrecharge_cancel()
    {
        return redirect(route('admin.sms.purchase.index'))->with('message', 'SMS Purchase Cancel');
    }
    public function index()
    {
        $sms_data = SmsRecharge::first();
        //you have to make this layouts 
        return view('pages.admin.sms.recharge.index', compact('sms_data'));
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
