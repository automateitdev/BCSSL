<?php
namespace App\Http\Controllers\Admin\FeesManagement;

use GuzzleHttp\Client as GuzzleClient;
use Carbon\Carbon;
use App\Models\User;
use NumberFormatter;
use App\Models\Member;
use App\Models\FeeAssign;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use App\Models\PaymentInfoItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Utils\FileUploadService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Requests\Admin\PaymentCreateRequest;
use App\Jobs\UpdateFeeLedgerTracesJob;
use App\Services\PaymentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Closure;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public $fileUploadService;
    public $spg_access_username;
    public $spg_access_password;
    public $spg_ar_account;
    public $spg_base_url_api;
    public $spg_auth;
    public $spg_redirect_url;
    protected $paymentService;
    public function __construct(FileUploadService $fileUploadService, PaymentService $paymentService)
    {
        $this->fileUploadService = $fileUploadService;
        $this->spg_access_username = config('app.spg_username');
        $this->spg_access_password = config('app.spg_password');
        $this->spg_ar_account = config('app.spg_account');
        $this->spg_auth = config('app.spg_auth');
        $this->spg_base_url_api = config('app.spg_base_url');
        $this->spg_redirect_url = config('app.spg_redirect_url');
        $this->paymentService = $paymentService;

        $this->middleware(function (Request $request, Closure $next) {
            if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
                return $next($request);
            }
            return route('member.portal');
        });
    }

    public function paymentCreate(PaymentCreateRequest $request)
    {
        $data = $request->validated();
        // dd('test',$data);
        // if(!isset($data['payment_type'])){
        // $data['payment_type'] = PaymentInfo::PAYMENT_TYPE_MANUAL;
        // something_wrong_flash('Payment Type is required!');

        // die();
        // when Only Online is active
        // $data['payment_type'] = PaymentInfo::PAYMENT_TYPE_ONLINE;
        // if (isset($data['document_files']) && count($data['document_files']) > 0) {
        //    $data['payment_type'] = PaymentInfo::PAYMENT_TYPE_MANUAL;
        //   }
        // }

        // dd('data',$data);
        //create payment member or admin detect
        if (Auth::guard('admin')->check()) {
            $user = User::find(Auth::guard('admin')->user()->id);
            $data['status'] = PaymentInfo::STATUS_PENDING;
            $data['created_by'] = $user->id;
        } else {
            $user = Member::find(Auth::guard('web')->user()->id);
            $data['status'] = PaymentInfo::STATUS_PENDING;
            $data['created_by'] = $user->id;
        }


        try {
            DB::beginTransaction();
            //get member fee assgin data
            $feeAssigns = FeeAssign::find($data['fee_assign_id']);

            // dd($feeAssign, $data['fee_assign_id']);

            $data['fine_amount'] = !is_null($feeAssigns) ? $feeAssigns->whereNotNull('fine_amount')->sum('fine_amount') : 0;
            $data['payable_amount'] = !is_null($feeAssigns) ? $feeAssigns->whereNotNull('amount')->sum('amount') : 0;
            $data['total_amount'] =  $data['fine_amount'] + $data['payable_amount'];


            // dd($data);
            $document_files = [];
            // dd($data['document_files']);
            //document file store
            // if (isset($data['payment_type']) && $data['payment_type'] == PaymentInfo::PAYMENT_TYPE_MANUAL) {
            if (isset($data['document_files']) && count($data['document_files']) > 0) {
                foreach ($data['document_files'] as $file) {
                    // dd($file, 'file');
                    $file_data =  $this->fileUploadService->uploadFile($file, PaymentInfo::DOCUMENT_FILES);
                    array_push($document_files, $file_data);
                }
                $data['document_files'] = implode(',', $document_files);
            }
            // }

            $now = Carbon::now();
            $invoiceDate = $now->format('Y-m-d');

            $unique_code = $now->format('ymdHis');
            $unique_invoice = 'INV' . $user->id . $unique_code;
            $data['invoice_no'] = strtoupper($unique_invoice);

            $data['payment_date'] = Carbon::now()->format('Y-m-d');

            if (isset($data['payment_type']) && $data['payment_type'] == PaymentInfo::PAYMENT_TYPE_ONLINE) {
                $data['ladger_id'] = 1;
                unset($data['document_files']);
                session(['online_payment' => $data]);
                // dd(session()->get('online_payment'));

                $invoiceData = [
                    'inovice' => $unique_invoice,
                    'invoiceDate' => $invoiceDate,
                ];

                $applicantData = [
                    'name' => $user?->name ?? null,
                    'contact' => $user?->mobile ?? "00000000000",
                ];

                $gatewayDetails = [
                    'spg_user'     => $this->spg_access_username,
                    'spg_password' => $this->spg_access_password,
                    'spg_account'  => $this->spg_ar_account,
                    'spg_auth'     => $this->spg_auth,
                    'spg_base_url' => $this->spg_base_url_api,
                    'spg_redirect_url' => $this->spg_redirect_url
                ];

                $initResponse = $this->paymentService->initiateGatewayPayment('SPG', $gatewayDetails, $applicantData, $data['total_amount'], [], $invoiceData);

                Log::channel('pay_flex')->info('Payment init response: ', ['response' => $initResponse]);

                return response()->json($initResponse);

                // //-------------------
                // $client = new GuzzleClient(array('base_uri' => $this->spg_base_url_api, 'curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
                // //API 1 (access_token )
                // $headers = [
                //     'Content-Type' => 'application/JSON',
                //     'Authorization' =>  $this->spg_auth,
                // ];
                // $body_data = '{"AccessUser":
                //           {"userName": "' . $this->spg_access_username . '",
                //           "password": "' . $this->spg_access_password . '"
                //           },
                //           "invoiceNo":"' . $data['invoice_no'] . '",
                //           "amount":"' . $data['total_amount'] . '",
                //           "invoiceDate":"' .  $data['payment_date'] . '",
                //           "accounts":[{"crAccount":"' . $this->spg_ar_account . '","crAmount":' . $data['total_amount'] .
                //     '}]}';



                // $res = $client->request(
                //     'POST',
                //     'api/v2/SpgService/GetAccessToken',
                //     ['headers' => $headers, 'body' => $body_data]
                // );
                // $token = json_decode($res->getBody(), true);
                // // dd('access_token',$body_data, $res, $token);
                // //API 1 end
                // //(API -II) session_token

                // $client = new GuzzleClient(array('base_uri' => $this->spg_base_url_api, 'curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
                // $data_two =
                //     '{
                //         "authentication":{
                //             "apiAccessUserId": "' . $this->spg_access_username . '",
                //             "apiAccessToken": "' . $token['access_token'] . '"
                //         },
                //         "referenceInfo": {
                //             "InvoiceNo": "' . $data['invoice_no'] . '",
                //             "invoiceDate": "' . $data['payment_date'] . '",
                //             "returnUrl": "' . route('admin.fees.payment.returnUrl') . '",
                //             "totalAmount": "' . $data['total_amount'] . '",
                //             "applicentName": "' . $user->name . '",
                //             "applicentContactNo": "010000000",
                //             "extraRefNo": "2132"
                //         },

                //         "creditInformations":
                //         [
                //             {
                //                 "slno": "1",
                //                 "crAccount": "' . $this->spg_ar_account . '",
                //                 "crAmount": "' . $data['total_amount'] . '",
                //                 "tranMode": "TRN"
                //             }
                //         ]
                //     }';
                // dd('data_two', $body_data,$data_two);
                // $res_two = $client->request(
                //     'POST',
                //     'api/v2/SpgService/CreatePaymentRequest',
                //     ['headers' => $headers, 'body' => $data_two]
                // );
                // $sessiontoken = json_decode($initResponse->getBody(), true);
                // $redirect_to = $this->spg_redirect_url.'SpgLanding/SpgLanding/'.$sessiontoken['session_token'];
                // https://spg.sblesheba.com:6313/SpgLanding/SpgLanding/{session_token}

                // return redirect()->to($redirect_to);
                // return view(
                //     'layouts.member.spg_paymentform',
                //     with([
                //         'spg_redirect_url' => $this->spg_redirect_url,
                //         'sessiontoken' => $initResponse
                //     ])
                // );

                //Post Transactional Data (API -II) end
                // dd('sessiontoken',$res_two,$sessiontoken, $redirect_to);
            } else {

                // dd($data);\
                if (isset($data['document_files']) && !empty($data['document_files'])) {
                    $paymentData = collect($data)->except(['fee_assign_id'])->toArray();
                } else {
                    $paymentData = collect($data)->except(['fee_assign_id', 'document_files'])->toArray();
                }

                $payment_infos = PaymentInfo::create($paymentData);

                if (!is_null($payment_infos)) {
                    foreach ($feeAssigns as $feeAssign) {
                    PaymentInfoItem::create([
                            'payment_info_id' => $payment_infos->id,
                            'fee_assign_id' => $feeAssign->id,
                            'fee_assign_id' => $feeAssign->id,
                            'assign_date' => $feeAssign->assign_date,
                            'amount' => $feeAssign->amount,
                            'fine_amount' => $feeAssign->fine_amount,
                            'monthly' => $feeAssign->monthly,
                        ]);
                        $feeAssign->update([
                            'status' => FeeAssign::STATUS_REQUEST
                        ]);
                    }

                    $user->paymentCreate()->create([
                        'payment_info_id' => $payment_infos->id
                    ]);

                    record_created_flash('Payment created Sucessfully');
                }

                // dd('result=',$payment_infos, $data);
                DB::commit();

                return redirect()->back();
            }
        } catch (\Exception $e) {

            DB::rollBack();
            Log::channel('payflex_log')->error($e->getMessage());
            something_wrong_flash($e->getMessage());
            dd($e);
            //throw $th;
        }
    }

    // public function paymentReturnUrl(Request $request){

    //     $session_token = $request['session_token'];
    //     $status = $request['status'];
    //     // dd($session_token, $status, $request->all());

    //     $data = session()->get('online_payment');
    //     if(!is_null($data)){
    //         $data['session_token'] = $session_token;
    //     }

    //     if($status == 'success'){
    //         if (session()->exists('online_payment')) {
    //             session()->forget('online_payment');
    //         }
    //         //Transaction Verification (API-III)
    //         $client = new GuzzleClient(array('base_uri'=> $this->spg_base_url_api, 'curl' =>array(CURLOPT_SSL_VERIFYPEER => false,),));
    //           $headers = [
    //               'Content-Type' => 'application/JSON',
    //               'Authorization' =>  $this->spg_auth,
    //               ];
    //               $body_data = '{"session_Token": "' . $session_token . '"}';
    //             //   dd('body_data', $body_data);
    //         $res = $client->request(
    //             'POST',
    //             'api/v2/SpgService/TransactionVerificationWithToken',
    //             ['headers' => $headers, 'body' => $body_data]
    //         );
    //         // dd($res);
    //         if (empty($res)) {
    //             return redirect()->back()->with('error', 'No response! i.e., If your payment has
    //            been deducted, Please contact your institute.');
    //         }
    //         $result = json_decode($res->getBody(), true);
    //         // dd($result);
    //         if(!empty($result)){
    //             $data['payment_status'] = $result['PaymentStatus'];
    //             $data['status_code'] = $result['status'];
    //             $data['transaction_id'] = $result['TransactionId'];
    //             $data['transaction_date'] = $result['TransactionDate'];
    //             $data['br_code'] = $result['BrCode'];
    //             $data['pay_mode'] = $result['PayMode'];

    //             $data['payable_amount'] = $result['TotalAmount'];
    //             $data['spg_pay_amount'] = $result['PayAmount'];
    //             $data['vat'] = $result['Vat'];
    //             $data['commission'] = $result['Commission'];
    //             $data['scroll_no'] = $result['ScrollNo'];
    //             //for online payment status all time completed
    //             $data['status'] = PaymentInfo::STATUS_COMPLETE;

    //             $feeAssigns = FeeAssign::find($data['fee_assign_id']);
    //             $payment_infos = PaymentInfo::create($data);
    //             $user = Member::find($data['member_id']);
    //             if(!is_null($payment_infos)){
    //                 foreach($feeAssigns as $feeAssign){
    //                     PaymentInfoItem::create([
    //                         'payment_info_id' => $payment_infos->id,
    //                         'fee_assign_id' => $feeAssign->id,
    //                         'fee_assign_id' => $feeAssign->id,
    //                         'assign_date' => $feeAssign->assign_date,
    //                         'amount' => $feeAssign->amount,
    //                         'fine_amount' => $feeAssign->fine_amount,
    //                         'monthly' => $feeAssign->monthly,
    //                     ]);
    //                     $feeAssign->update([
    //                         'status' => FeeAssign::STATUS_PAID
    //                     ]);
    //                 }

    //                 $user->paymentCreate()->create([
    //                     'payment_info_id' => $payment_infos->id
    //                 ]);

    //                 record_created_flash('Payment created Sucessfully');

    //                 // Ledger traces
    //                 // foreach ($payment_infos as $paymentInfo) {
    //                 foreach ($payment_infos->feeAssign as $feeAssign) {
    //                     dispatch(new UpdateFeeLedgerTracesJob($feeAssign, $payment_infos));
    //                     }
    //                 // }
    //             }


    //             return redirect()->route('member.memberInfo');
    //         }
    //         // dd('result', $result, $request->all());
    //     }else{
    //         if (session()->exists('online_payment')) {
    //             session()->forget('online_payment');
    //         }
    //         record_warning_flash('Payment created Fail');
    //         return redirect()->route('member.memberInfo');
    //     }

    // }

    public function paymentReturnUrl(Request $request)
    {

        $session_token = $request['session_token'];
        $status = $request['status'];
        // dd($session_token, $status, $request->all());

        $data = session()->get('online_payment');
        if (!is_null($data)) {
            $data['session_token'] = $session_token;
        }

        if ($status == 'success') {
            if (session()->exists('online_payment')) {
                session()->forget('online_payment');
            }
            //Transaction Verification (API-III)
            $client = new GuzzleClient(array('base_uri' => $this->spg_base_url_api, 'curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
            $headers = [
                'Content-Type' => 'application/JSON',
                'Authorization' =>  $this->spg_auth,
            ];
            $body_data = '{"session_Token": "' . $session_token . '"}';
            //   dd('body_data', $body_data);
            $res = $client->request(
                'POST',
                'api/v2/SpgService/TransactionVerificationWithToken',
                ['headers' => $headers, 'body' => $body_data]
            );
            // dd($res);
            if (empty($res)) {
                return redirect()->back()->with('error', 'No response! i.e., If your payment has
               been deducted, Please contact your institute.');
            }
            $result = json_decode($res->getBody(), true);
            Log::info("Payment Report ::: " . json_encode($result));
            // dd($result);
            if (!empty($result)) {
                $data['payment_status'] = $result['PaymentStatus'];
                $data['status_code'] = $result['status'];
                $data['transaction_id'] = $result['TransactionId'];
                $data['transaction_date'] = $result['TransactionDate'];
                $data['br_code'] = $result['BrCode'];
                $data['pay_mode'] = $result['PayMode'];

                $data['payable_amount'] = $result['TotalAmount'];
                $data['spg_pay_amount'] = $result['PayAmount'];
                $data['vat'] = $result['Vat'];
                $data['commission'] = $result['Commission'];
                $data['scroll_no'] = $result['ScrollNo'];


                //for online payment status all time completed
                $data['status'] = $result['PaymentStatus'] == 200 ? PaymentInfo::STATUS_COMPLETE : PaymentInfo::STATUS_PENDING;

                $feeAssigns = FeeAssign::find($data['fee_assign_id']);
                $payment_infos = PaymentInfo::create($data);
                $user = Member::find($data['member_id']);
                if (!is_null($payment_infos)) {
                    foreach ($feeAssigns as $feeAssign) {
                        PaymentInfoItem::create([
                            'payment_info_id' => $payment_infos->id,
                            'fee_assign_id' => $feeAssign->id,
                            'fee_assign_id' => $feeAssign->id,
                            'assign_date' => $feeAssign->assign_date,
                            'amount' => $feeAssign->amount,
                            'fine_amount' => $feeAssign->fine_amount,
                            'monthly' => $feeAssign->monthly,
                        ]);
                        $feeAssign->update([
                            'status' => $result['PaymentStatus'] == 200 ? FeeAssign::STATUS_PAID : FeeAssign::STATUS_DUE
                        ]);
                    }

                    $user->paymentCreate()->create([
                        'payment_info_id' => $payment_infos->id
                    ]);

                    record_created_flash('Payment created Sucessfully');

                    // Ledger traces
                    // foreach ($payment_infos as $paymentInfo) {
                    foreach ($payment_infos->feeAssign as $feeAssign) {
                        dispatch(new UpdateFeeLedgerTracesJob($feeAssign, $payment_infos));
                    }
                    // }
                }


                return redirect()->route('member.memberInfo');
            } else {

                if (!empty($result)) {
                    Log::info("Payment failed for : " . json_encode($result));
                } else {
                    Log::info("No Payment information in api/v2/SpgService/TransactionVerificationWithToken");
                }

                if (session()->exists('online_payment')) {
                    session()->forget('online_payment');
                }
                record_warning_flash('Payment has not been completed!');
                return redirect()->route('member.memberInfo');
            }
            // dd('result', $result, $request->all());
        } else {
            if (session()->exists('online_payment')) {
                session()->forget('online_payment');
            }
            record_warning_flash('Payment created Fail');
            return redirect()->route('member.memberInfo');
        }
    }

    public function dataUpdate(Request $request)
    {

        $data = $request->all();
        return $data;
        // $payment = PaymentInfo::find($data['payment_id']);
        // $payment->update($data);
        // return redirect()->back();
    }



    // public function paymentCreate(PaymentCreateRequest $request){
    //     $data = $request->validated();

    //     // dd('data',$data);
    //     //create payment member or admin detect
    //     if(Auth::guard('admin')->check()){
    //        $user = User::find(Auth::guard('admin')->user()->id);
    //        $data['status'] = PaymentInfo::STATUS_PENDING;
    //        $data['created_by'] =$user->id;
    //     }else{
    //         $user = Member::find(Auth::guard('web')->user()->id);
    //         $data['status'] = PaymentInfo::STATUS_PENDING;
    //         $data['created_by'] =$user->id;
    //     }

    //     try {
    //         DB::beginTransaction();
    //          //get member fee assgin data
    //         $feeAssigns = FeeAssign::find($data['fee_assign_id']);

    //         // dd($feeAssigns, $data['fee_assign_id']);

    //         $data['fine_amount'] = !is_null($feeAssigns) ? $feeAssigns->whereNotNull('fine_amount')->sum('fine_amount') : 0;
    //         $data['payable_amount'] = !is_null($feeAssigns) ? $feeAssigns->whereNotNull('amount')->sum('amount') : 0;
    //         $data['total_amount'] =  $data['fine_amount'] + $data['payable_amount'];
    //         // dd($data);
    //         $document_files = [];
    //         // dd($data['document_files']);
    //         //document file store
    //         if( isset($data['document_files']) && count($data['document_files']) > 0){
    //             foreach($data['document_files'] as $file){
    //                 // dd($file, 'file');
    //                $file_data =  $this->fileUploadService->uploadFile($file, PaymentInfo::DOCUMENT_FILES);
    //                array_push($document_files, $file_data);
    //             }
    //             $data['document_files'] = implode(',',$document_files);
    //         }
    //         $data['invoice_no']= invoiceNoGenerate();
    //         $data['payment_date']= Carbon::now()->format('Y-m-d');

    //         //  dd($data);

    //         // dd($data);
    //         $payment_infos = PaymentInfo::create($data);

    //         if(!is_null($payment_infos)){
    //             foreach($feeAssigns as $feeAssign){
    //                 PaymentInfoItem::create([
    //                     'payment_info_id' => $payment_infos->id,
    //                     'fee_assign_id' => $feeAssign->id,
    //                     'fee_assign_id' => $feeAssign->id,
    //                     'assign_date' => $feeAssign->assign_date,
    //                     'amount' => $feeAssign->amount,
    //                     'fine_amount' => $feeAssign->fine_amount,
    //                     'monthly' => $feeAssign->monthly,
    //                 ]);
    //                 $feeAssign->update([
    //                     'status' => FeeAssign::STATUS_PAID
    //                 ]);
    //             }

    //             $user->paymentCreate()->create([
    //                 'payment_info_id' => $payment_infos->id
    //             ]);

    //             record_created_flash('Payment created Sucessfully');
    //         }

    //         // dd('result=',$payment_infos, $data);
    //         DB::commit();

    //         return redirect()->back();
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         something_wrong_flash($e->getMessage());
    //         // dd($e->getMessage());
    //         //throw $th;
    //     }

    // }


    public function paymentInvoice($id)
    {
        $paymentInfo = PaymentInfo::query()->with(['member.associatorsInfo', 'paymentsInfoItems.feeSetup'])->find($id);

        $text = qr_text_generate($paymentInfo);
        // $text = $this->qr_text_generate($paymentInfo);

        $total_amount_num_to_sensts = $this->numberToSentence($paymentInfo->total_amount);
        // dd($total_amount_num_to_sensts);

        $qrcode = base64_encode(QrCode::format('png')->generate($text));
        //  dd($qrcode);

        $pdf = Pdf::loadView('pages.admin.pdf.invoices.invoice', ['text' => $text, 'paymentInfo' => $paymentInfo, 'total_amount_num_to_sensts' => $total_amount_num_to_sensts, 'qrcode' => $qrcode]);
        return $pdf->download($paymentInfo->invoice_no . '.pdf');

        // return view('pages.admin.pdf.invoices.invoice', compact('text','paymentInfo','total_amount_num_to_sensts','qrcode'));
        // $pdf = PDF::loadView('pages.admin.pdf.invoices.invoice');

        // return $pdf->download('itsolutionstuff.pdf');

    }


    public function numberToSentence($number)
    {
        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::SPELLOUT);
        return ucfirst($formatter->format($number));
    }

    public function qr_text_generate($paymentInfo)
    {

        $text = '';
        $qr_code_infos = [
            'Member Name : ' . $paymentInfo->member->name,
            'Member Id : ' . $paymentInfo->member->associatorsInfo->membershp_number,
            'Invoice Id : ' . $paymentInfo->invoice_no,
            'Paid Amount : ' . $paymentInfo->total_amount,
        ];
        foreach ($qr_code_infos as $qr_code_info) {
            $text = $text  . "\n" . $qr_code_info;
        }
        return $text;
    }
}
