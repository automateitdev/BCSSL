@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))

@section('content')
    <div id="enrollment_auto">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="mb-25">
                        <a href="{{ route('admin.payment.list') }}">{{ get_page_meta('title', true) }}</a>
                        <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 mt-5">
                    <form action="{{ route('admin.payment.status.update') }}" method="POST">

                        @csrf
                        @if (count($paymentInfos) > 0)
                            <table class="table display table-light table-hover table-striped table-sm table-bordered"
                                id="myTable">
                                <thead>
                                    <tr>
                                        {{-- <th class="text-center" style="max-width: max-content"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th> --}}
                                        <th class="text-center" style="max-width: max-content">
                                            <input type="checkbox" class="select_all_payment" id="example-select-all">
                                        </th>
                                        <th width="25%">Membership No.</th>
                                        <th width="25%">Name</th>
                                        <th>Ledger</th>

                                        <th width="25%">Assigned Date</th>
                                        {{-- <th>Month</th> --}}
                                        <th width="25%">Payment Date</th>
                                        <th width="25%">Payable</th>
                                        <th width="25%">Fine</th>
                                        <th width="25%">Total</th>
                                        <th width="25%">Payment Type</th>
                                        <th width="25%">Reasons</th>
                                        <th width="25%">Documents</th>
                                        <th style="width: 15%">Action</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentInfos as $key => $paymentInfo)
                                        <tr>
                                            <td style="text-align:center">
                                                <input type="checkbox" class="payment_single_check"
                                                    data-id="{{ $paymentInfo->id }}"
                                                    {{ $paymentInfo->status == \App\Models\PaymentInfo::STATUS_SUSPEND ? 'disabled' : '' }}>
                                                <input type="hidden" name="payment[{{ $key }}][payment_id]"
                                                    value="{{ $paymentInfo->id }}"
                                                    class="payment_value_one_{{ $paymentInfo->id }}"
                                                    {{ $paymentInfo->status == \App\Models\PaymentInfo::STATUS_SUSPEND ? 'disabled' : '' }}
                                                    disabled>

                                            </td>
                                            <td>{{ $paymentInfo->member->associatorsInfo->membershp_number }}</td>
                                            <td>
                                                {{ optional($paymentInfo->member)->name }}
                                            </td>
                                            <td>{{ optional($paymentInfo->ledger)->ledger_name }}</td>

                                            {{-- <td>
                                        {{\Carbon\Carbon::parse($paymentInfo->payment_date)->format('Y')}}
                                    </td> --}}
                                            <td >
                                                @forelse ($paymentInfo->paymentsInfoItems as $item)
                                                    {{ \Carbon\Carbon::parse($item->assign_date)->format('d-F-Y') }}
                                                    <br>
                                                @empty
                                                    -
                                                @endforelse
                                            </td>
                                            <td >
                                                {{ \Carbon\Carbon::parse($paymentInfo->payment_date)->format('d-F-Y') }}
                                            </td>


                                            <td>{{ $paymentInfo->payable_amount }}</td>
                                            <td>{{ $paymentInfo->fine_amount }}</td>
                                            <td>{{ $paymentInfo->total_amount }}</td>
                                            <td> {{ ucwords($paymentInfo->payment_type) }}</td>

                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm reason_btn"
                                                    id="reason_btn{{ $paymentInfo->id }}" data-toggle="modal"
                                                    style="display: {{ $paymentInfo->status == \App\Models\PaymentInfo::STATUS_SUSPEND ? 'block' : 'none' }};"
                                                    data-target="#reasonsExampleModal{{ $paymentInfo->id }}">
                                                    Reasons
                                                </button>
                                                <input type="hidden" name="payment[{{ $key }}][reasons]"
                                                    value="{{ $paymentInfo->reasons }}"
                                                    class="reason_tarea{{ $paymentInfo->id }}"
                                                    {{ $paymentInfo->status !== \App\Models\PaymentInfo::STATUS_SUSPEND ? 'disabled' : '' }}>

                                                <!-- Modal -->
                                                <div class="modal fade" id="reasonsExampleModal{{ $paymentInfo->id }}"
                                                    tabindex="-1" aria-labelledby="reasonsExampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="reasonsExampleModalLabel">
                                                                    Invoice No: {{ $paymentInfo->invoice_no }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlTextarea1">Reasons</label>
                                                                    <textarea class="form-control reason_tarea" data-id="{{ $paymentInfo->id }}" id="exampleFormControlTextarea1"
                                                                        rows="3">{{ $paymentInfo->reasons }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal"
                                                    data-target="#exampleModal{{ $paymentInfo->id }}">
                                                    <i class="fa fa-file"></i>
                                                    ({{ !is_null($paymentInfo->document_files) ? count(explode(',', $paymentInfo->document_files)) : 0 }})
                                                </button>
                                            </td>

                                            <td>

                                                @can('Payment Approval Edit')
                                                    <select name="payment[{{ $key }}][status]"
                                                        class="form-control  payment_value_one_{{ $paymentInfo->id }} status_change"
                                                        data-id='{{ $paymentInfo->id }}' disabled>
                                                        @foreach (\App\Models\PaymentInfo::ALL_PAYMENT_STATUS as $status)
                                                            <option value="{{ $status }}"
                                                                {{ $paymentInfo->status == $status ? 'selected' : '' }}
                                                                {{ $paymentInfo->status == \App\Models\PaymentInfo::STATUS_SUSPEND ? 'disabled' : '' }}>
                                                                {{ ucwords($status) }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                @endcan


                                            </td>

                                            <td>
                                                <a href="{{ route('admin.payment.invoice.view', ['id' => $paymentInfo->id]) }}"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        @if (!is_null($paymentInfo->document_files))
                                            <div class="modal  fade" id="exampleModal{{ $paymentInfo->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Invoice No:
                                                                {{ $paymentInfo->invoice_no }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    @php
                                                                        $files = explode(',', $paymentInfo->document_files);
                                                                    @endphp
                                                                    <div class="image_main">
                                                                        @foreach ($files as $file)
                                                                            <div class="image_main_inner">
                                                                                @if (get_file_extention($file) != 'pdf')
                                                                                    <img src="{{ get_file_extention($file) != 'pdf' ? get_storage_image(\App\Models\PaymentInfo::DOCUMENT_FILES_VIEW, $file) : get_pdf_image() }}"
                                                                                        alt="" class="img-fluid"
                                                                                        height="140">
                                                                                @else
                                                                                    <img src="{{ get_pdf_image() }}"
                                                                                        href="{{ get_storage_image(\App\Models\PaymentInfo::DOCUMENT_FILES_VIEW, $file) }}"
                                                                                        class="img-fluid" height="140">
                                                                                @endif

                                                                            </div>
                                                                        @endforeach
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        <div class="row">
                            <div class="col-md-6 text-right">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                        name="sms" value="yes">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Send SMS</label>
                                </div>
                            </div>
                            <div class="col-md-6 text-left">
                                <button type="submit" class="btn btn-success mb-3">Approved</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <style>
            input {
                position: relative;
            }

            input:before {
                position: absolute;
                top: 3px;
                left: 3px;
                content: attr(data-date);
                display: inline-block;
                color: black;
            }

            input::-webkit-datetime-edit,
            input::-webkit-inner-spin-button,
            input::-webkit-clear-button {
                display: none;
            }

            input::-webkit-calendar-picker-indicator {
                position: absolute;
                top: 3px;
                right: 0;
                color: black;
                opacity: 1;
            }

            .image_main {
                display: flex;
                justify-content: flex-start;
                gap: 6px;
                flex-direction: row;
                /* flex-wrap: wrap; */
                height: auto;
                width: 100%;

            }

            .image_main_inner {
                width: 100%;

            }

            .image_main img {
                height: 150px;
                width: 150px;
            }
        </style>
    @endpush
    @push('script')
        {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}

        <script src="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

        <script src="{{ asset('plugins/Image-PDF-Viewer-EZView/EZView.js') }}"></script>
        <script src="{{ asset('plugins/Image-PDF-Viewer-EZView/draggable.js') }}"></script>

        <script>
            let table = $('#myTable').DataTable({
                scrollX:true,
            });
        </script>
        <script>
            $(document).ready(function() {
                $(document).on('change', '.status_change', function(e) {
                    e.preventDefault();
                    let p_id = $(this).data('id');
                    let value = $(this).val();
                    $("#reason_btn" + p_id).hide();
                    $(".reason_tarea" + p_id).prop('disabled', true);
                    if (value == 'suspend') {
                        $("#reason_btn" + p_id).show();
                        $(".reason_tarea" + p_id).prop('disabled', false);
                    }
                    console.log(p_id, value);
                })

                $(document).on('keyup', '.reason_tarea', function(e) {
                    e.preventDefault();
                    let text = $(this).val();
                    let id = $(this).data('id');
                    $(".reason_tarea" + id).val(text);
                })
                // console.log('chck');

                $('img').EZView();
            });
        </script>
    @endpush
@endsection
