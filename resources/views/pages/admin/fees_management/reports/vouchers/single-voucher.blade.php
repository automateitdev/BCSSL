@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))

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

                    <div class="card">
                        <div class="card-body">

                            <div class="member_info_section">
                                <div class="member_info_section_left">
                                    <div class="member_info">

                                        <table cellpadding="5" cellspacing="0" border="0" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Ledger name</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                @foreach ($traces as $tracer =>  $trace)
                                                <tr>
                                                    <td>{{$trace->ledger->ledger_name}}</td>
                                                    <td>{{$trace->debit}}</td>
                                                    <td>{{$trace->credit}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td style="text-align: center"><b>Balance</b></td>
                                                    <td><b>Total Debited: {{$traces->sum('debit')}}</b></td>
                                                    <td><b>Total Credited: {{$traces->sum('credit')}}</b></td>
                                                </tr>
                                                {{-- <tr>
                                                    <td colspan="3"><button type="button">Download Voucher</button>
                                                    </td>
                                                </tr> --}}
                                            </tbody>
                                        </table>
                                    </div>

                                </div>


                            </div>

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

        /* .member_info_section_left {
            width: 50%;
        } */

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
@endpush
@push('script')
@endpush
