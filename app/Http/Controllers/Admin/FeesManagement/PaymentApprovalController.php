<?php

namespace App\Http\Controllers\Admin\FeesManagement;

use App\Models\Member;
use App\Models\FeeAssign;
use App\Models\SmsHistory;
use App\Models\PaymentInfo;
use App\Models\SmsRecharge;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AssociatorsInfo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleClient;
use App\Services\Common\InvoiceService;
use App\Http\Requests\Admin\PaymentStatusUpdateRequest;
use App\Jobs\UpdateFeeLedgerTracesJob;
use App\Models\LedgerTrace;
use App\Models\FeeSetup;
use App\Models\PaymentInfoItem;
use Carbon\Carbon;

class PaymentApprovalController extends Controller
{
    public $invoiceService;
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
        $this->middleware(['permission:Payment Approval View'])->only(['paymentList']);
        $this->middleware(['permission:Payment Approval Edit'])->only(['paymentStatusUpdate']);
    }

     public function paymentList()
    {
        set_page_meta('Payment Approval');
        $paymentInfos = PaymentInfo::query()
            ->where('status', 'pending')
            ->with(['member.associatorsInfo', 'ledger:id,ledger_name'])
            ->latest()
            ->get();
        return view('pages.admin.fees_management.payment.approval', compact('paymentInfos'));
    }

    public function paymentComplete()
    {
        return view('pages.admin.fees_management.payment.completed');
    }


  public function paymentCompleteList()
    {
        set_page_meta('Complete List');
        $date_from = request('date_from', Carbon::yesterday()->toDateString());
        $date_to = request('date_to', Carbon::today()->toDateString());
        // if ($request->ajax()) {
        $query = PaymentInfo::query()
            ->where('status', 'completed')
            ->with(['member.associatorsInfo', 'ledger:id,ledger_name'])
            ->whereBetween('payment_date', [$date_from, $date_to])
            ->get();


        return datatables()
            ->of($query)
            ->addColumn('documents', function ($query) {
                $modalContent = "<button type='button' class='btn btn-sm btn-secondary' data-toggle='modal' data-target='#exampleModal" . $query->id . "'><i class='fa fa-file'></i>(" . (!is_null($query->document_files) ? count(explode(',', $query->document_files)) : 0) . ")</button>";
                $modalContent .= "<div class='modal fade' id='exampleModal" . $query->id . "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                $modalContent .= "<div class='modal-dialog modal-lg'>";
                $modalContent .= "<div class='modal-content'>";
                $modalContent .= "<div class='modal-header'>";
                $modalContent .= "<h5 class='modal-title' id='exampleModalLabel'>Invoice No: " . $query->invoice_no . "</h5>";
                $modalContent .= "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                $modalContent .= "<span aria-hidden='true'>&times;</span>";
                $modalContent .= "</button>";
                $modalContent .= "</div>";
                $modalContent .= "<div class='modal-body'>";
                $modalContent .= "<div class='card'>";
                $modalContent .= "<div class='card-body'>";
                $modalContent .= "<div class='image_main'>";

                // Loop through each file
                foreach (explode(',', $query->document_files) as $file) {
                    $modalContent .= "<div class='image_main_inner'>";
                    if (get_file_extention($file) != 'pdf') {
                        $modalContent .= "<img src='" . get_storage_image(PaymentInfo::DOCUMENT_FILES_VIEW, $file) . "' alt='' class='img-fluid' height='140'>";
                    } else {
                        $modalContent .= "<img src='" . get_pdf_image() . "' href='" . get_storage_image(PaymentInfo::DOCUMENT_FILES_VIEW, $file) . "' class='img-fluid' height='140'>";
                    }
                    $modalContent .= "</div>";
                }

                $modalContent .= "</div>"; // .image_main
                $modalContent .= "</div>"; // .card-body
                $modalContent .= "</div>"; // .card
                $modalContent .= "</div>"; // .modal-body
                $modalContent .= "<div class='modal-footer'>";
                $modalContent .= "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                $modalContent .= "</div>"; // .modal-footer
                $modalContent .= "</div>"; // .modal-content
                $modalContent .= "</div>"; // .modal-dialog
                $modalContent .= "</div>"; // .modal

                return $modalContent;
            })
            ->addColumn('view', function ($row) {
              return "<a href='/admin/payment-invoice-view/$row->id' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> View</a>";
            })
            ->addIndexColumn()
            ->rawColumns(['view', 'documents'])
            ->make(true);
    }
    
    public function paymentSuspend()
    {
        set_page_meta('Suspended List');
        return view('pages.admin.fees_management.payment.suspended');
    }

    public function paymentSuspendList()
    {
        set_page_meta('Suspended List');
        $date_from = request('date_from', Carbon::yesterday()->toDateString());
        $date_to = request('date_to', Carbon::today()->toDateString());
        // if ($request->ajax()) {
        $query = PaymentInfo::query()
            ->where('status', 'suspend')
            ->with(['member:id,name', 'ledger:id,ledger_name'])
            ->whereBetween('payment_date', [$date_from, $date_to])
            ->get();


        return datatables()
            ->of($query)
            ->addColumn('reasons_view', function ($row) {
                return "<button type='button' class='btn btn-primary btn-sm reason_btn' id='reason_btn$row->id' data-toggle='modal' style='display:block' data-target='#reasonsExampleModal$row->id'> Reasons</button>
                <div class='modal fade' id='reasonsExampleModal$row->id' tabindex='-1' aria-labelledby='reasonsExampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='reasonsExampleModalLabel'>Invoice No:  $row->invoice_no</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <div class='form-group'>
                                    <label for='exampleFormControlTextarea1'>Reasons</label>
                                    <textarea class='form-control reason_tarea' data-id='$row->id' id='exampleFormControlTextarea1' rows='3'>$row->reasons</textarea>
                                </div>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                            </div>
                        </div>
                    </div>
                </div>
";
            })
            ->addIndexColumn()
            ->rawColumns(['reasons_view'])
            ->make(true);
    }

    public function paymentStatusUpdate(PaymentStatusUpdateRequest $request)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            foreach ($data['payment'] as $payment) {

                // dd($payment['status']);
                if ($request->sms == "yes") {
                    $memberCounter = count($data['payment']);

                    $smsbank = SmsRecharge::first();

                    if ($smsbank->sms_quantity < $memberCounter) {
                        return response("Insufficient SMS Balance: $smsbank->sms_quantity", Response::HTTP_INSUFFICIENT_STORAGE);
                    } else {

                        $client = new GuzzleClient(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));

                        $sentsmscounter = 0;

                        $pyInfo = PaymentInfo::find($payment['payment_id']);
                        $pydetails = PaymentInfoItem::with('feeAssign')->find($pyInfo->id);
                        $feeAssign = FeeAssign::find($pydetails->fee_assign_id);
                        $feeSetup = FeeSetup::find($feeAssign->fee_setup_id);
                        $member = Member::find($pyInfo->member_id);
                        $ass = AssociatorsInfo::where('member_id', $member->id)->first();
                        // API endpoint
                        $apiEndpoint = "https://sms.mram.com.bd/smsapi";

                        // Your API key, sender ID, content type, schedule date time, message, and contacts
                        $apiKey = "C30007426572e72cab2a29.86593074";
                        $senderId = "8809601013355";
                        $contentType = "unicode";
                        $message = "Payment {$payment['status']} for $feeSetup->fee_head. Fee amount: $pyInfo->total_amount BDT. Thank you, $member->name. Your Member ID is $ass->membershp_number.";
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
                    }
                }

                if (!isset($payment['status']) || !isset($payment['payment_id'])) {
                    continue;
                }

                $paymentInfo = PaymentInfo::query()->with(['feeAssign', 'ledger'])->find($payment['payment_id']);

                if ($payment['status'] == PaymentInfo::STATUS_SUSPEND) {
                    $paymentInfo->update([
                        'status' => $payment['status'],
                        'reasons' => $payment['reasons'] ?? null
                    ]);
                } else {
                    $paymentInfo->update([
                        'status' => $payment['status']
                    ]);
                }

                // $is_reported = LedgerTrace::where('invoice_no', $paymentInfo->invoice_no)->exists();
                // if ($is_reported) {
                //     continue;
                // }

                if (count($paymentInfo->feeAssign) > 0) {

                    foreach ($paymentInfo->feeAssign as $feeAssign) {
                        $feeAssignData = FeeAssign::find($feeAssign->id);
                        if ($payment['status'] == PaymentInfo::STATUS_COMPLETE) {
                            // if ($payment['status'] == PaymentInfo::STATUS_COMPLETE) {
                            $feeAssignData->update([
                                'status' => FeeAssign::STATUS_PAID
                            ]);
                                // update ledger traces
                                dispatch(new UpdateFeeLedgerTracesJob($feeAssign, $paymentInfo));
                            // }
                        } else {
                            if ($payment['status'] == PaymentInfo::STATUS_SUSPEND) {
                                $feeAssignData->update([
                                    'status' =>  FeeAssign::STATUS_DUE
                                ]);
                            }
                        }
                    }
                }
            }
            DB::commit();
            record_created_flash('Approval Updated Sucessfully');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            something_wrong_flash($e->getMessage());
            //throw $th;
        }
    }

    public function paymentInvoiceView($id)
    {
        set_page_meta('Payment Invoices');
        $invoiceData = $this->invoiceService->invoiceView($id);
        return view('pages.admin.fees_management.reports.invoices.single-invoice',
            [
                'text' => $invoiceData['text'],
                'paymentInfo' => $invoiceData['paymentInfo'],
                'total_amount_num_to_sensts' => $invoiceData['total_amount_num_to_sensts'],
                'qrcode' => $invoiceData['qrcode']
            ]
        );
    }
}
