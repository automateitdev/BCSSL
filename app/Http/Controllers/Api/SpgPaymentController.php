<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SpgPaymentController extends Controller
{
    public function dataUpdate(Request $request){

        $all_data = $request->all();

        $credential = $all_data['Credentials'];
        $data = $all_data['data'];

        if (empty($credential) || $credential['userName'] !== "a2i@pmo" || $credential['password'] !== "sbPayment0002") {
            return response("Unauthorized",Response::HTTP_UNAUTHORIZED);
        }
        Log::info('Request For: ',compact('data'));
        $payment_info = PaymentInfo::query()->where('session_token',$data['session_Token'])
        ->where('transaction_id',$data['TransactionId'])
        ->where('invoice_no', $data['InvoiceNo'])->first();
        if(!is_null($payment_info)){
            if($payment_info->status_code == 200){
                Log::info('Request
                Found At Update Table for response 200: ',
                compact('data'));

                return response()->json(["status" =>
                "200", "msg" => "Success", "transactionid" =>
                $data['TransactionId']]);
            }
            else {
                Log::info('status_code is not 200', compact('data'));
                return response()->json(["status" => "201",
                "msg" => "fail", "session_Token" => $data['TransactionId']]);
            }
        }else{
            Log::info('Data not found', compact('data'));
            return response()->json(["status" => "201",
            "msg" => "fail", "session_Token" => $data['TransactionId']]);
        }

    }
}
