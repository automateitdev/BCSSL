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
use App\Models\PaymentRequest;
use App\Services\PaymentService;
use App\Services\SpgService;
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
    protected $spgService;
    public function __construct(FileUploadService $fileUploadService, PaymentService $paymentService, SpgService $spgService)
    {
        $this->fileUploadService = $fileUploadService;
        $this->spg_access_username = config('app.spg_username');
        $this->spg_access_password = config('app.spg_password');
        $this->spg_ar_account = config('app.spg_account');
        $this->spg_auth = config('app.spg_auth');
        $this->spg_base_url_api = config('app.spg_base_url');
        $this->spg_redirect_url = config('app.spg_redirect_url');
        $this->paymentService = $paymentService;
        $this->spgService = $spgService;

        $this->middleware(function (Request $request, Closure $next) {
            if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
                return $next($request);
            }
            return route('member.portal');
        });
    }

    // public function paymentCreate(PaymentCreateRequest $request)
    // {
    //     $data = $request->validated();
    //     //create payment member or admin detect
    //     if (Auth::guard('admin')->check()) {
    //         $user = User::find(Auth::guard('admin')->user()->id);
    //         $data['status'] = PaymentInfo::STATUS_PENDING;
    //         $data['creator_id'] = $user->id;
    //         $data['created_by'] = 'admin';

    //         $applicantContact = $user->mobile;
    //     } else {
    //         $user = Member::find(Auth::guard('web')->user()->id);
    //         $data['status'] = PaymentInfo::STATUS_PENDING;
    //         $data['creator_id'] = $user->id;
    //         $data['created_by'] = 'member';
    //         $applicantContact = $user->formatted_number;
    //     }


    //     try {
    //         DB::beginTransaction();
    //         //get member fee assgin data
    //         $feeAssigns = FeeAssign::find($data['fee_assign_id']);

    //         // dd($feeAssign, $data['fee_assign_id']);

    //         $data['fine_amount'] = !is_null($feeAssigns) ? $feeAssigns->whereNotNull('fine_amount')->sum('fine_amount') : 0;
    //         $data['payable_amount'] = !is_null($feeAssigns) ? $feeAssigns->whereNotNull('amount')->sum('amount') : 0;
    //         $data['total_amount'] =  $data['fine_amount'] + $data['payable_amount'];


    //         // dd($data);
    //         $document_files = [];
    //         // dd($data['document_files']);
    //         //document file store
    //         // if (isset($data['payment_type']) && $data['payment_type'] == PaymentInfo::PAYMENT_TYPE_MANUAL) {
    //         if (isset($data['document_files']) && count($data['document_files']) > 0) {
    //             foreach ($data['document_files'] as $file) {
    //                 // dd($file, 'file');
    //                 $file_data =  $this->fileUploadService->uploadFile($file, PaymentInfo::DOCUMENT_FILES);
    //                 array_push($document_files, $file_data);
    //             }
    //             $data['document_files'] = implode(',', $document_files);
    //         }
    //         // }

    //         $now = Carbon::now();
    //         $invoiceDate = $now->format('Y-m-d');

    //         $unique_code = $now->format('ymdHis');
    //         $unique_invoice = 'INV' . $user->id . $unique_code;
    //         $data['invoice_no'] = strtoupper($unique_invoice);

    //         $data['payment_date'] = Carbon::now()->format('Y-m-d');

    //         if (isset($data['payment_type']) && $data['payment_type'] == PaymentInfo::PAYMENT_TYPE_ONLINE) {

    //             $paymentRequest = PaymentRequest::create([
    //                 'invoice'        => $data['invoice_no'],
    //                 'fee_assign_ids' => $data['fee_assign_id'],
    //                 'total_amount'   => $data['total_amount'],
    //                 'creator_id'     => $data['creator_id'],
    //                 'created_by'     => $data['created_by'],
    //                 'status'         => 'pending',
    //             ]);

    //             Log::alert('Payment Request saved: ', [
    //                 $paymentRequest
    //             ]);


    //             $data['ladger_id'] = 1;
    //             unset($data['document_files']);
    //             session(['online_payment' => $data]);
    //             // dd(session()->get('online_payment'));

    //             $invoiceData = [
    //                 'invoice' => $unique_invoice,
    //                 'invoiceDate' => $invoiceDate,
    //             ];

    //             $applicantData = [
    //                 'name' => $user?->name ?? null,
    //                 'contact' => $applicantContact ?? "00000000000",
    //             ];

    //             $gatewayDetails = [
    //                 'spg_user'     => $this->spg_access_username,
    //                 'spg_password' => $this->spg_access_password,
    //                 'spg_account'  => $this->spg_ar_account,
    //                 'spg_auth'     => $this->spg_auth,
    //                 'spg_base_url' => $this->spg_base_url_api,
    //                 'spg_redirect_url' => $this->spg_redirect_url
    //             ];

    //             $accounts[] =   [
    //                 'crAccount' => $this->spg_ar_account,
    //                 'crAmount' => (float)$data['total_amount']
    //             ];

    //             $disbursements = [
    //                 'accounts' => $accounts
    //             ];

    //             Log::channel('payflex_log')->info('disbursements: ', [$disbursements]);

    //             $initResponse = $this->paymentService->initiateGatewayPayment('SPG', $gatewayDetails, $applicantData, $data['total_amount'], $disbursements, $invoiceData);

    //             Log::channel('payflex_log')->info('Payment init response: ', ['response' => $initResponse]);

    //             if ($initResponse['status'] == 'success' && !empty($initResponse['payment_url'])) {
    //                 return redirect()->to($initResponse['payment_url']);
    //             } else {
    //                 something_wrong_flash('Could not initiate the payment! try later.');
    //             }
    //         } else {

    //             // dd($data);\
    //             if (isset($data['document_files']) && !empty($data['document_files'])) {
    //                 $paymentData = collect($data)->except(['fee_assign_id'])->toArray();
    //             } else {
    //                 $paymentData = collect($data)->except(['fee_assign_id', 'document_files'])->toArray();
    //             }

    //             $payment_infos = PaymentInfo::create($paymentData);

    //             if (!is_null($payment_infos)) {
    //                 foreach ($feeAssigns as $feeAssign) {
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
    //                         'status' => FeeAssign::STATUS_REQUEST
    //                     ]);
    //                 }

    //                 $user->paymentCreate()->create([
    //                     'payment_info_id' => $payment_infos->id
    //                 ]);

    //                 record_created_flash('Payment created Sucessfully');
    //             }

    //             // dd('result=',$payment_infos, $data);
    //             DB::commit();

    //             return redirect()->back();
    //         }
    //     } catch (\Exception $e) {

    //         DB::rollBack();
    //         Log::channel('payflex_log')->error($e->getMessage());
    //         something_wrong_flash($e->getMessage());
    //         //throw $th;
    //     }
    // }

    public function paymentCreate(PaymentCreateRequest $request)
    {
        $data = $request->validated();

        // Detect user type
        if (Auth::guard('admin')->check()) {
            $user = User::find(Auth::guard('admin')->user()->id);
            $data['creator_id'] = $user->id;
            $data['created_by'] = 'admin';
            $applicantContact = $user->mobile;
        } else {
            $user = Member::find(Auth::guard('web')->user()->id);
            $data['creator_id'] = $user->id;
            $data['created_by'] = 'member';
            $applicantContact = $user->formatted_number;
        }

        // Fee Assigns & totals
        $feeAssigns = FeeAssign::find($data['fee_assign_id']);
        $data['fine_amount'] = $feeAssigns?->whereNotNull('fine_amount')->sum('fine_amount') ?? 0;
        $data['payable_amount'] = $feeAssigns?->whereNotNull('amount')->sum('amount') ?? 0;
        $data['total_amount'] = $data['fine_amount'] + $data['payable_amount'];

        // Invoice
        $now = Carbon::now();
        $unique_invoice = 'INV' . $user->id . $now->format('ymdHis');
        $data['invoice_no'] = strtoupper($unique_invoice);
        $data['payment_date'] = $now->format('Y-m-d');

        try {
            if (($data['payment_type'] ?? null) === PaymentInfo::PAYMENT_TYPE_ONLINE) {

                // Create PaymentRequest immediately
                $paymentRequest = PaymentRequest::create([
                    'invoice' => $data['invoice_no'],
                    'fee_assign_ids' => $data['fee_assign_id'],
                    'total_amount' => $data['total_amount'],
                    'creator_id' => $data['creator_id'],
                    'created_by' => $data['created_by'],
                    'status' => 'pending',
                ]);

                Log::alert('Payment Request saved: ', [$paymentRequest]);

                // Save data to session
                unset($data['document_files']);
                session(['online_payment' => $data]);

                // Prepare SPG
                $invoiceData = ['invoice' => $unique_invoice, 'invoiceDate' => $now->format('Y-m-d')];
                $applicantData = ['name' => $user?->name, 'contact' => $applicantContact];
                $gatewayDetails = [
                    'spg_user' => $this->spg_access_username,
                    'spg_password' => $this->spg_access_password,
                    'spg_account' => $this->spg_ar_account,
                    'spg_auth' => $this->spg_auth,
                    'spg_base_url' => $this->spg_base_url_api,
                    'spg_redirect_url' => $this->spg_redirect_url
                ];

                $disbursements = [['crAccount' => $this->spg_ar_account, 'crAmount' => (float)$data['total_amount']]];

                $initResponse = $this->paymentService->initiateGatewayPayment(
                    'SPG',
                    $gatewayDetails,
                    $applicantData,
                    $data['total_amount'],
                    ['accounts' => $disbursements],
                    $invoiceData
                );

                if ($initResponse['status'] == 'success' && !empty($initResponse['payment_url'])) {
                    return redirect()->to($initResponse['payment_url']);
                } else {
                    something_wrong_flash('Could not initiate the payment! try later.');
                }
            } else {
                // Manual payment
                DB::transaction(function () use ($data, $feeAssigns, $user) {
                    $paymentData = collect($data)->except(['fee_assign_id', 'document_files'])->toArray();
                    $paymentInfo = PaymentInfo::create($paymentData);

                    foreach ($feeAssigns as $feeAssign) {
                        PaymentInfoItem::create([
                            'payment_info_id' => $paymentInfo->id,
                            'fee_assign_id' => $feeAssign->id,
                            'assign_date' => $feeAssign->assign_date,
                            'amount' => $feeAssign->amount,
                            'fine_amount' => $feeAssign->fine_amount,
                            'monthly' => $feeAssign->monthly,
                        ]);
                        $feeAssign->update(['status' => FeeAssign::STATUS_REQUEST]);
                    }

                    $user->paymentCreate()->create(['payment_info_id' => $paymentInfo->id]);
                    record_created_flash('Payment created successfully');
                });

                return redirect()->back();
            }
        } catch (\Exception $e) {
            Log::channel('payflex_log')->error($e->getMessage());
            something_wrong_flash($e->getMessage());
            return redirect()->back();
        }
    }

    // public function handlePayFlexVerification(Request $request)
    // {
    //     Log::alert('HITS HANDLE PAYFLEX:::::::::::', [$request->all()]);
    //     $data = $request->all();
    //     // Check if PayFlex has provided data
    //     if (empty($data['data'])) {
    //         return response()->json(['status' => 'error', 'message' => 'No data received'], 400);
    //     }

    //     $verification = $data['data']; // Standardized payload from PayFlex
    //     $invoice = $verification['InvoiceNo'] ?? null;
    //     if (!$invoice) {
    //         return response()->json(['status' => 'error', 'message' => 'Invoice missing'], 400);
    //     }

    //     return $this->processPayInvoice($invoice, $verification);
    // }

    // private function processPayInvoice(string $invoice, array $verification)
    // {
    //     try {
    //         Log::alert('I ENTERED IN THE INVOICE PORCESS HUHAHAHAHAHAH');
    //         DB::transaction(function () use ($invoice, $verification) {

    //             $statusCode = $verification['Status'] ?? null;

    //             Log::channel('payflex_log')->info("Processing invoice {$invoice} with status {$statusCode}");

    //             // Fetch PaymentRequest
    //             $paymentRequest = PaymentRequest::where('invoice', $invoice)->first();

    //             if (!$paymentRequest) {
    //                 throw new \Exception("PaymentRequest not found for invoice {$invoice}");
    //             }

    //             // Fetch Member
    //             $user = Member::find($paymentRequest->creator_id);

    //             if (!$user) {
    //                 throw new \Exception("Member not found (ID: {$paymentRequest->creator_id}) for invoice {$invoice}");
    //             }

    //             // Prepare PaymentInfo data
    //             $data = [
    //                 'member_id'        => $user->creator_id,
    //                 'payment_status'   => $statusCode,
    //                 'status_code'      => $statusCode,
    //                 'transaction_id'   => $verification['TransactionId'] ?? null,
    //                 'transaction_date' => $verification['TransactionDate'] ?? null,
    //                 'br_code'          => $verification['Branch'] ?? null,
    //                 'pay_mode'         => $verification['PayMode'] ?? null,
    //                 'payable_amount'   => $verification['RequestTotalAmount'] ?? 0,
    //                 'spg_pay_amount'   => $verification['CustomerPaidAmount'] ?? 0,
    //                 'vat'              => $verification['vat'] ?? null,
    //                 'commission'       => $verification['commission'] ?? null,
    //                 'scroll_no'        => $verification['ScrollNo'] ?? null,
    //                 'invoice_no'       => $invoice,
    //                 'session_token'    => $verification['Token'] ?? null,
    //                 'ledger_id'        => 1,
    //                 'status'           => ($statusCode == 200)
    //                     ? PaymentInfo::STATUS_COMPLETE
    //                     : PaymentInfo::STATUS_PENDING,
    //             ];

    //             // Save PaymentInfo
    //             $paymentInfo = PaymentInfo::create($data);

    //             // Collect fee assigns
    //             $feeAssigns = FeeAssign::whereIn('id', $paymentRequest->fee_assign_ids)->get();

    //             // Create PaymentInfoItems
    //             foreach ($feeAssigns as $feeAssign) {
    //                 PaymentInfoItem::create([
    //                     'payment_info_id' => $paymentInfo->id,
    //                     'fee_assign_id'   => $feeAssign->id,
    //                     'assign_date'     => $feeAssign->assign_date,
    //                     'amount'          => $feeAssign->amount,
    //                     'fine_amount'     => $feeAssign->fine_amount,
    //                     'monthly'         => $feeAssign->monthly,
    //                 ]);

    //                 // Update fee assign status
    //                 $feeAssign->update([
    //                     'status' => ($statusCode == 200)
    //                         ? FeeAssign::STATUS_PAID
    //                         : FeeAssign::STATUS_DUE
    //                 ]);
    //             }

    //             // Attach to user's payments
    //             $user->paymentCreate()->create([
    //                 'payment_info_id' => $paymentInfo->id
    //             ]);

    //             // Dispatch background jobs
    //             foreach ($paymentInfo->feeAssign as $feeAssign) {
    //                 dispatch(new UpdateFeeLedgerTracesJob($feeAssign, $paymentInfo));
    //             }

    //             // Update PaymentRequest
    //             $paymentRequest->update(['status' => $statusCode]);
    //         });
    //         return response()->json([
    //             'status'  => 'success',
    //             'message' => 'Pay invoice updated'
    //         ]);
    //     } catch (\Throwable $e) {

    //         Log::channel('payflex_log')->error("ERROR processing invoice {$invoice}", [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Internal server error',
    //             'error'   => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function handlePayFlexNotification(Request $request)
    // {
    //     $response = $request->all();
    //     $paidInvoice = false;
    //     Log::channel('payflex_log')->info('IPN Request received:', $response);

    //     if (isset($response['invoice'])) {
    //         $invoiceNumber = $response['invoice'];

    //         $invoiceExist = PaymentRequest::where('invoice', $invoiceNumber)
    //             ->where('status', 200)
    //             ->exists();
    //         if ($invoiceExist) {
    //             $paidInvoice = true;
    //         }
    //     }

    //     if ($paidInvoice) {
    //         return response()->json(['message' => 'Invoice found and marked as paid.'], 200);
    //     } else {
    //         return response()->json(['error' => 'Invoice not updated'], 400);
    //     }
    // }

    // private function processPayInvoice($payInvoice, array $verification)
    // {
    //     try {
    //         DB::transaction(function () use ($payInvoice, $verification) {

    //             $statusCode    = $verification['Status'] ?? null;
    //             $token         = $verification['Token'] ?? null;
    //             Log::channel('payflex_log')->info("StatusCode {$statusCode}", [$verification]);

    //             $data['payment_status'] = $statusCode ?? null;
    //             $data['status_code'] = $statusCode ?? null;
    //             $data['transaction_id'] = $verification['TransactionId'] ?? null;
    //             $data['transaction_date'] = $verification['TransactionDate'] ?? null;
    //             $data['br_code'] = $verification['Branch'] ?? null;
    //             $data['pay_mode'] = $verification['PayMode'] ?? null;

    //             $data['payable_amount'] = $verification['RequestTotalAmount'];
    //             $data['spg_pay_amount'] = $verification['CustomerPaidAmount'];
    //             $data['vat'] =  $verification['vat'] ?? null;
    //             $data['commission'] = $verification['commission'] ?? null;
    //             $data['scroll_no'] = $verification['ScrollNo'] ?? null;
    //             $data['invoice_no'] = $payInvoice;
    //             $data['session_token'] = $token;
    //             $data['ledger_id'] = 1;

    //             //for online payment status all time completed
    //             $data['status'] = $statusCode == 200 ? PaymentInfo::STATUS_COMPLETE : PaymentInfo::STATUS_PENDING;

    //             $paymentRequest = PaymentRequest::where('invoice', $payInvoice)->first();

    //             $fee_assign_ids = $paymentRequest->fee_assign_ids;
    //             $feeAssigns = FeeAssign::find($fee_assign_ids);

    //             $payment_infos = PaymentInfo::create($data);

    //             if (!is_null($payment_infos)) {
    //                 foreach ($feeAssigns as $feeAssign) {
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
    //                         'status' => $statusCode == 200 ? FeeAssign::STATUS_PAID : FeeAssign::STATUS_DUE
    //                     ]);
    //                 }

    //                 $user->paymentCreate()->create([
    //                     'payment_info_id' => $payment_infos->id
    //                 ]);

    //                 // record_created_flash('Payment created Sucessfully');

    //                 // Ledger traces
    //                 // foreach ($payment_infos as $paymentInfo) {
    //                 foreach ($payment_infos->feeAssign as $feeAssign) {
    //                     dispatch(new UpdateFeeLedgerTracesJob($feeAssign, $payment_infos));
    //                 }
    //                 // }
    //             }


    //             $paymentRequest->status = $statusCode;
    //             $paymentRequest->save();
    //         });

    //         return response()->json([
    //             'status'  => 'success',
    //             'message' => 'Pay invoice updated'
    //         ]);
    //     } catch (\Throwable $e) {
    //         Log::channel('payflex_log')->error("Error in processPayInvoice: ", [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         // something_wrong_flash('An unexpected error occured!');
    //         return response()->json('Internal server error', 500);
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


    public function postPaymentReconcile(Request $request)
    {
        $paymentStatus = $request->input('status') ?? null;
        $invoice = $request->input('invoice') ?? null;
        $payInvoice = PaymentRequest::where('invoice', $invoice)->first();

        if ($paymentStatus != 200) {
            something_wrong_flash('Payment attempt canceled/failed');
        } else {
            record_created_flash('Payment has been done successfully!');
        }

        $returnUrl = config('app.url');
        if ($payInvoice) {
            if ($returnUrl) {
                return redirect()->away(
                    $returnUrl . "?status={$paymentStatus}&invoice={$invoice}"
                );
            }
        }

        if (!$returnUrl) {
            return response()->json(["Status" => 200, "Message" => "Payment verification reconciliation successful"]);
        }
    }
}
