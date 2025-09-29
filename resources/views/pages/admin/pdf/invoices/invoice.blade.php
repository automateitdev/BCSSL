<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .container {
            /* width: 90%; */
            margin: 0 auto;
        }

        .header-section {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            text-align: center;
        }

        .monny_receipt {
            text-align: center;
            margin-right: 4%;
        }

        .monny_receipt b {
            border-bottom: 1px solid #000;
        }

        .member_info_section {
            margin-bottom: 10px;
        }

        .member_info_section_left {
            width: 100%;
        }

        .member_info_section_left table {
            width: 100%;
            margin: 0px;
        }

        .payment_item_section table,
        .payment_item_section th,
        .payment_item_section td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .powerd_by {
            display: flex;
            justify-content: space-between;
        }

        .header-section-table {
            width: 100%;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">


        <table class="header-section-table">
            <tr class="header-section-table-tr">
                <td style="    width: 10%;">
                    <img src="{{ !is_null(getSetting('image')) ? get_storage_image_public_path('setting', getSetting('image')) : asset('assets/images/dummy_pp_image.jpg') }}"
                        alt="" class="img-fluid" style="height: 120px; width: 120px" id="uploadPreview" />
                </td>
                <td style="    text-align: center;    width: 80%;">
                    <div class="header-section2-inner">
                        <h4>
                            {{ !is_null(getSetting('name')) ? getSetting('name') : '{{ config('app.title') }}' }}
                        </h4>
                    </div>
                </td>
                <td style="width: 10%;">
                    <img src="data:image/png;base64, {!! $qrcode !!}">
                </td>
            </tr>
        </table>

        <h3 class='monny_receipt'>
            <b>Money Receipt</b>
        </h3>
        <div class="member_info_section">
            <div class="member_info_section_left">
                <div class="member_info">
                    <table style="width: 100%">
                        <tr>
                            <td> Member Id</td>
                            <td>:</td>
                            <td>{{ optional(optional($paymentInfo->member)->associatorsInfo)->membershp_number }}</td>

                            <td> Payment Date</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($paymentInfo->payment_date)->format('j F, Y') }}</td>
                        </tr>
                        <tr>
                            <td> Name</td>
                            <td>:</td>
                            <td>{{ optional($paymentInfo->member)->name }}</td>

                            <td> Invoice</td>
                            <td>:</td>
                            <td>{{ $paymentInfo->invoice_no }}</td>

                        </tr>

                        <tr>

                            <td> BCS Batch</td>
                            <td>:</td>
                            <td>{{ optional($paymentInfo->member)->bcs_batch }}</td>

                            <td> Cadre Id</td>
                            <td>:</td>
                            <td>{{ optional($paymentInfo->member)->cader_id }}</td>
                        </tr>
                    </table>
                </div>

            </div>
            {{-- <div class="member_info_section_right">
                <div class="member_info">
                    <div>
                        Academic Year
                    </div>
                    <div>:</div>
                    <div>2023</div>
                </div>
                <div class="member_info">
                    <div>
                        Academic Year
                    </div>
                    <div>:</div>
                    <div>2023</div>
                </div>
                <div class="member_info">
                    <div>
                        Academic Year
                    </div>
                    <div>:</div>
                    <div>2023</div>
                </div>
                <div class="member_info">
                    <div>
                        Academic Year
                    </div>
                    <div>:</div>
                    <div>2023</div>
                </div>
            </div> --}}

        </div>
        @if (count($paymentInfo->paymentsInfoItems) > 0)
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
                        @foreach ($paymentInfo->paymentsInfoItems as $item)
                            <tr>

                                <td> {{ $loop->iteration }}</td>
                                <td>{{ $item->monthly ? 'Monthly' : 'One Time' }}</td>
                                <td>
                                    {{ optional($item->feeSetup)->fee_head }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->assign_date)->format('Y') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->assign_date)->format('F') }}
                                </td>
                                <td>
                                    {{ $item->amount }}
                                </td>
                                <td>
                                    {{ $item->fine_amount ?? 0 }}
                                </td>
                                <td>
                                    {{ $item->amount + ($item->fine_amount ?? 0) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="6" rowspan="3">
                                <h3><b>Note:</b></h3>
                                @if ($paymentInfo->payment_type == \App\Models\PaymentInfo::PAYMENT_TYPE_MANUAL)
                                    <p>Cash Recieved</p>
                                @else
                                    <p>Online Payment</p>
                                @endif
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
                            <td>{{ optional($paymentInfo->paymentsInfoItems)->sum('amount') + optional($paymentInfo->paymentsInfoItems)->sum('fine_amount') }}
                            </td>

                        </tr>
                        <tr>
                            <td colspan="8">
                                <p>
                                    <b> Paid In Word:</b> {{ $total_amount_num_to_sensts }}
                                </p>
                            </td>
                        </tr>
                        <tr style="    font-size: 10px;">

                            <td colspan="3" style="border-right: 0px;">
                                <small>Powered By: Automate IT Limited</small>

                            </td>
                            <td colspan="5" style="    border-left: 0px;text-align: right;">
                                <small>Special Note: This Money Receipt was created on a software and is valid without
                                    signature and seal</small>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        @endif
    </div>
</body>

</html>
