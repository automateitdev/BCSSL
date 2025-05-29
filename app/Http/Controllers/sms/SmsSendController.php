<?php

namespace App\Http\Controllers\sms;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\SmsHistory;
use App\Models\PaymentInfo;
use App\Models\SmsRecharge;
use App\Models\SmsTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AssociatorsInfo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class SmsSendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SmsTemplate::all();
        $members = Member::all();
        return view('pages.admin.sms.send.member.index', compact('data', 'members'));
    }

    public function getsmsbody(Request $request)
    {
        $data = SmsTemplate::select('sms')->where('id', $request->id)->first();

        return $data;
    }

    public function smsSendToMember(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'id' => 'required|array|min:1',
            'sms' => 'required',
            'formatted_number' => 'required|array|min:1'
        ]);

        $memberCounter = count($request->id);
        $smslength = ceil((floatval(mb_strlen($request->sms)) + 2) / 46);
        $totalsms = $memberCounter * $smslength;

        $smsbank = SmsRecharge::first();

        if ($smsbank->sms_quantity < $totalsms) {
            return response("Insufficient SMS Balance: $smsbank->sms_quantity", Response::HTTP_INSUFFICIENT_STORAGE);
        } else {

            $client = new GuzzleClient(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));

            $sentsmscounter = 0;

            foreach ($request->id as $key => $member_id) {
                $member = Member::where('id', $member_id)->first();

                // API endpoint
                $apiEndpoint = "https://sms.mram.com.bd/smsapi";

                // Your API key, sender ID, content type, schedule date time, message, and contacts
                $apiKey = "C30007426572e72cab2a29.86593074";
                $senderId = "8809601013355";
                $contentType = "unicode";
                $message = $request->sms;
                $contacts = $member->formatted_number;


                // Request data
                $data = [
                    'api_key' => $apiKey,
                    'senderid' => $senderId,
                    'type' => $contentType,
                    'msg' => $message,
                    'contacts' => $contacts,
                ];

                // Guzzle request
                $response = $client->post($apiEndpoint, [
                    'json' => $data,
                ]);

                // Get the response body as a string
                $responseBody = $response->getBody()->getContents();
                //    SMS SUBMITTED: ID - bw-rdC3000742659117f47d8b8
                if (strrpos($responseBody, "SMS SUBMITTED") !== false){
                    $status = 200;
                    $mit = SmsRecharge::first();
                    if ($mit) {
                        $sms_recharge = $mit->update([
                            'sms_quantity' => max(0, $mit->sms_quantity - $smslength)
                        ]);
                    }
                    $sentsmscounter++;
                } else {
                    $status = 417;
                }
                $input = new SmsHistory();
                $input->member_id = $member->id;
                $input->sms_length = $smslength;
                $input->number = $member->formatted_number;
                $input->msg = $request->sms;
                $input->response = $responseBody;
                $input->status = $status;
                $input->save();
            }

            return response('SMS Sent Successfully', Response::HTTP_CREATED);
        }
    }

    public function notificationSms()
    {
        return view('pages.admin.sms.send.notification.index');
    }
    public function dueSmsSend(Request $request)
    {
        // dd($request->all());

        foreach($request->id as $key => $id)
            // dd($id, $request->details[$key]);
        {
            $memberCounter = count($request->id);

            $smsbank = SmsRecharge::first();

            if ($smsbank->sms_quantity < $memberCounter+1) {
                return response("Insufficient SMS Balance: $smsbank->sms_quantity", Response::HTTP_INSUFFICIENT_STORAGE);
            } else {

                $client = new GuzzleClient(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));

                $sentsmscounter = 0;

                    $pyInfo = PaymentInfo::find($id);
                    $member = Member::find($pyInfo->member_id);
                    $ass = AssociatorsInfo::where('member_id', $member->id)->first();
                    // API endpoint
                    $apiEndpoint = "https://sms.mram.com.bd/smsapi";

                    $details = $request->details[$key];
                    // Your API key, sender ID, content type, schedule date time, message, and contacts
                    $apiKey = "C30007426572e72cab2a29.86593074";
                    $senderId = "8809601013355";
                    $contentType = "unicode";
                    $message = "Payment due for $details. Thank you, $member->name Your Member ID is $ass->membershp_number.";
                    $contacts = $member->formatted_number;

                    $smslength = ceil((floatval(mb_strlen($message)) + 2) / 46);
                    if ($smsbank->sms_quantity < $smslength) {
                        return response("Insufficient SMS Balance: $smsbank->sms_quantity", Response::HTTP_INSUFFICIENT_STORAGE);
                    }
                    // Request data
                    $data = [
                        'api_key' => $apiKey,
                        'senderid' => $senderId,
                        'type' => $contentType,
                        'msg' => $message,
                        'contacts' => $contacts,
                    ];

                    // Guzzle request
                    $response = $client->post($apiEndpoint, [
                        'json' => $data,
                    ]);

                    // Get the response body as a string
                    $responseBody = $response->getBody()->getContents();
                    //    SMS SUBMITTED: ID - bw-rdC3000742659117f47d8b8
                    if (strrpos($responseBody, "SMS SUBMITTED") !== false){
                        $status = 200;
                        $mit = SmsRecharge::first();
                        if ($mit) {
                            $sms_recharge = $mit->update([
                                'sms_quantity' => max(0, $mit->sms_quantity - $smslength)
                            ]);
                        }
                        $sentsmscounter++;
                    } else {
                        $status = 417;
                    }
                    $input = new SmsHistory();
                    $input->member_id = $member->id;
                    $input->sms_length = $smslength;
                    $input->number = $member->formatted_number;
                    $input->msg = $request->sms;
                    $input->response = $responseBody;
                    $input->status = $status;
                    $input->save();
            }
        }
        return response('SMS Sent Successfully', Response::HTTP_CREATED);
    }

    public function smsReport()
    {
        return view('pages.admin.sms.report.index');
    }

    public function smsReportFetch()
    {
        $history = SmsHistory::query()->with('member');
        $history = $history->latest()->get();

        return DataTables::of($history)
            ->addColumn('status_display', function ($row) {
                return $row->status == 200 ? 'Success' : 'Failed';
            })
            ->setRowAttr([
                'align' => 'left',
            ])->make(true);
    }
}
