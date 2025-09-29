<?php

namespace App\Http\Controllers\Admin\MemberManagement;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;
use App\Models\SmsHistory;
use App\Models\SmsRecharge;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AssociatorsInfo;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleClient;
use App\Http\Requests\Admin\UserApprovalRequest;

class ApprovalController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:Profile Approval View'])->only(['index']);
        $this->middleware(['permission:Associators Info Edit'])->only(['approvalUpdate']);
    }

    public function index()
    {
        set_page_meta('Approval');
        $users = Member::where('status', '!=', 'suspended')->get();

        return view('pages.admin.member-management.approval', compact('users'));
    }

    public function approvalAlUpdate(UserApprovalRequest $request)
    {

        $data = $request->validated();
        foreach ($data['member'] as $member) {

            $member_data = Member::where('id', $member['member_id'])->first();
            // dd($member_data->formatted_number, $member_data->name);
            $member_data->status = $member['status'];

            if ($member_data->save()) {

                if (is_null($member_data->associatorsInfo)) {
                    $member_data->associatorsInfo()->insert([
                        'member_id' => $member_data->id,
                        'created_at' =>  Carbon::now()
                    ]);
                }
            }
            if ($request->sms == "yes") {
                $memberCounter = count($request->member);
                // $smslength = ceil((floatval(mb_strlen($request->sms)) + 2) / 46);
                // $totalsms = $memberCounter * $smslength;

                $smsbank = SmsRecharge::first();

                if ($smsbank->sms_quantity < $memberCounter) {
                    return response("Insufficient SMS Balance: $smsbank->sms_quantity", Response::HTTP_INSUFFICIENT_STORAGE);
                } else {

                    $client = new GuzzleClient(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));

                    $sentsmscounter = 0;

                    // foreach ($request->id as $key => $member_id) {
                    $member = Member::where('id', $member['member_id'])->first();
                    $ass = AssociatorsInfo::where('member_id', $member->id)->first();
                    // dd($member->status);
                    // API endpoint
                    $apiEndpoint = "https://sms.mram.com.bd/smsapi";

                    // Your API key, sender ID, content type, schedule date time, message, and contacts
                    $apiKey = "C30007426572e72cab2a29.86593074";
                    $senderId = "8809601013355";
                    $contentType = "unicode";
                    $message = "Dear {$member->name}, we are pleased to inform you that your membership has been {$member->status}. Your Member ID is {$ass->membershp_number}. Welcome to " . config('app.title') . " family. Thank you.";

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
                    if (strrpos($responseBody, "SMS SUBMITTED") !== false) {
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
                    // }

                    return response('SMS Sent Successfully', Response::HTTP_CREATED);
                }
            }
        }
        record_created_flash('Member status update Sucessfully');
        return redirect()->back();
    }

    public function approvalUpdate(Request $request)
    {

        $user = Member::with(['associatorsInfo'])->find($request->user_id);
        $user->status = $request->status;

        if ($user->save()) {

            if (is_null($user->associatorsInfo)) {
                $user->associatorsInfo()->insert([
                    'member_id' => $user->id,
                    'created_at' =>  Carbon::now()
                ]);
            }
            record_created_flash('Member status update Sucessfully');
        }

        return redirect()->back();
    }
}
