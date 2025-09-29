@extends('layouts.admin.admin-master')

@section('page_title',get_page_meta('title', true))

@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="mb-25">
                        <a href="#">{{ get_page_meta('title', true) }}</a>
                        <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-9">

                   <div class="card" style="background-color: azure">
                    <div class="card-body">

                        <table class="header-section-table" style="display: inline-block">
                            <tr class="header-section-table-tr">
                                <td style="width: 15%;vertical-align: top"><img src="{{asset('storage/images/logo.jpeg')}}" alt="" class="img-fluid rounded"></td>
                                <td style="text-align: center; width: 80%;">
                                    <div class="header-section2-inner">
                                        <h4 style="mb-0">
                                            {{ !is_null(getSetting('name')) ? getSetting('name') : '{{ config('app.title') }}' }}
                                        </h4>
                                            <h5 class="mt-0">{{ !is_null(getSetting('address')) ? getSetting('address') : 'bcss.limited@gmail.com'}}</h5>
                                            <p class="m-0">Registration No:01/2023 &nbsp; &nbsp; &nbsp; &nbsp; Date:23/02/23</p>
                                            Email: {{ !is_null(getSetting('email')) ? getSetting('email') : ''}}
                                        <br>
                                        <p class="btn btn-secondary my-2 fw-thin text-uppercase disabled" style="letter-spacing:.25em">
                                            Payment Invoice
                                        </p>
                                    </div>
                                </td>
                                <td style="width: 10%;">
                                    <img src="data:image/png;base64, {!! $qrcode !!}">
                                </td>
                            </tr>
                        </table>

                        <div class="member_info_section">
                            <div class="member_info_section_left">
                                <div class="member_info">
                                    <table style="border-collapse: collapse">
                                        <tr>
                                            {{-- <td>      Member Id</td>
                                            <td>:</td>
                                            <td>{{optional(optional($paymentInfo->member)->associatorsInfo)->membershp_number}}</td> --}}

                                            <td>      <b>Name</b></td>
                                            <td>:</td>
                                            <td>{{optional($paymentInfo->member)->name}}</td>
                                            <td><pre style="margin: 0"></pre></td>
                                            <td>      <b>Invoice No.</b></td>
                                            <td>:</td>
                                            <td>{{$paymentInfo->invoice_no}}</td>
                                        </tr>
                                        <tr>
                                            {{-- <td>     <b>BCS Batch & Cadre</b></td>
                                            <td>:</td>
                                            <td>{{optional($paymentInfo->member)->bcs_batch}}</td>
                                            <td><pre style="margin: 0"></pre></td> --}}

                                            <td> <b>Payment Date</b></td>
                                            <td>:</td>
                                            <td>{{ \Carbon\Carbon::parse($paymentInfo->payment_date)->format('d-M-Y') }}</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>


                        </div>
                        @if(count($paymentInfo->paymentsInfoItems) > 0)
                        <div class="payment_item_section">
                            <table style="width:100%">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <th>Fee Type</th>
                                        <td>Fee Header</td>
                                        <td>Year</td>
                                        <td>Month</td>
                                        <td>Fee Amount</td>
                                        <td>Fine Amount</td>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paymentInfo->paymentsInfoItems as $item)
                                    <tr>

                                        <td> {{$loop->iteration}}</td>
                                        <td>{{$item->monthly ? "Monthly" : "One Time"}}</td>
                                        <td>
                                            {{ optional($item->feeSetup)->fee_head }}
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($item->feeAssign->assign_date)->format('Y')}}
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($item->feeAssign->assign_date)->format('F')}}
                                        </td>
                                        <td>
                                            {{$item->amount}}
                                        </td>
                                        <td>
                                            {{$item->fine_amount ?? 0}}
                                        </td>
                                        <td>
                                            {{ $item->amount + ($item->fine_amount ?? 0)}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6" rowspan="3">
                                            <h3><b>Note:</b></h3>
                                            <p> {{$paymentInfo->payment_type == \App\Models\PaymentInfo::PAYMENT_TYPE_MANUAL ? 'Cash Recieved' : 'Online Recieved'}}</p>
                                        </td>
                                        <td>Total Fine</td>
                                        <td>{{ optional($paymentInfo->paymentsInfoItems)->sum('fine_amount') }}</td>

                                    </tr>
                                    <tr>

                                        <td>Sub Total</td>
                                        <td>{{ optional($paymentInfo->paymentsInfoItems)->sum('amount') }}</td>

                                    </tr>
                                    <tr>

                                        <td>Total Payable</td>
                                        <td>{{ optional($paymentInfo->paymentsInfoItems)->sum('amount') + optional($paymentInfo->paymentsInfoItems)->sum('fine_amount')}}</td>

                                    </tr>
                                    <tr>
                                        <td colspan="8">
                                            <p>
                                               <b> Paid In Word:</b> {{$total_amount_num_to_sensts}}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="    font-size: 10px;">

                                        <td colspan="3" style="border-right: 0px;" >
                                            <small>Powered By: Automate IT LTD</small>

                                        </td>
                                        <td colspan="5" style="    border-left: 0px;text-align: right;">
                                            <small>Special Note: This Money Receipt was created on a software and is valid without signature and seal</small>
                                        </td>
                                    </tr>
                                </tbody>

                              </table>
                        </div>
                        @endif
                    </div>
                   </div>
                </div>
                <div class="col-md-1"></div>
            </div>


        </div>
    </div>


@endsection
@push('style')
<style>
    .container{
        /* width: 90%; */
        margin: 0 auto;
    }
    .header-section{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        text-align: center;
    }
    .monny_receipt{
        text-align: center;
        margin-right: 4%;
    }
    .monny_receipt b{
        border-bottom: 1px solid #000;
    }
    .member_info_section{
        margin-bottom: 10px;
    }
    .member_info_section_left{
        width: 90%;
    }
    .member_info_section_left table{
        width: 100%;
     margin: 0px;
    }
    .payment_item_section table, .payment_item_section th, .payment_item_section td {
    border: 1px solid black;
    border-collapse: collapse;
    }
    .powerd_by{
        display: flex;
        justify-content: space-between;
    }

    .header-section-table{
        width: 100%;
        margin: 0;
    }

</style>
@endpush
@push('script')

@endpush
