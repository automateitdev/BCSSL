@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))

@section('content')
    <div id="enrollment_auto">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="mb-25">
                        <a href="{{ route('admin.payment.suspend.list') }}">{{ get_page_meta('title', true) }}</a>
                        <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                    </h3>
                </div>
            </div>

            <div class="row">
                <div class="card p-3 col-md-7 mx-auto my-2 mb-5">
                    <form>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="form-label">From</label>
                                <input type="date" class="form-control" name="from" id="startDate">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">To</label>
                                <input type="date" class="form-control" name="to" id="endDate">
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-primary btn-sm mt-2 float-right"
                                    id="voucherwise_search">
                                    <i class="fa-solid fa-magnifying-glass"></i> Search</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-12 mt-5">
                    <form action="{{ route('admin.payment.status.update') }}" method="POST">
                        @csrf
                        <table class="table table-light table-hover table-striped table-sm table-bordered" id="myTable">
                            <thead>
                                <tr>
                                    {{-- <th class="text-center" style="max-width: max-content"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th> --}}
                                    <th class="text-center" style="max-width: max-content">
                                        {{-- <input type="checkbox" class="select_all_payment" id="example-select-all"> --}}
                                    </th>
                                    <th>Member</th>
                                    <th>Ledger</th>

                                    {{-- <th>Date</th> --}}
                                    {{-- <th>Month</th> --}}
                                    <th>Payment Date</th>
                                    {{-- <th>Documents</th> --}}
                                    <th>Fine</th>
                                    <th>Payable</th>
                                    <th>Total</th>
                                    <th>Reasons</th>
                                    <th>Payment Type</th>
                                    <th>status</th>
                                    {{-- <th>View</th> --}}
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

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
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <script src="{{ asset('plugins/Image-PDF-Viewer-EZView/EZView.js') }}"></script>
        <script src="{{ asset('plugins/Image-PDF-Viewer-EZView/draggable.js') }}"></script>


        <script>
            let csrf_token = $('meta[name="csrf-token"]').attr('content');
            let table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.suspended.payment.list') }}",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-Csrf-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    data: function(d) {
                        // Add additional parameters to the data sent to the server
                        d.date_from = $('#startDate').val(); // Replace with the actual ID or selector of your date_from input
                        d.date_to = $('#endDate').val(); // Replace with the actual ID or selector of your date_to input
                    }
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'member.name',
                        name: 'member.name'
                    },
                    {
                        data: 'ledger.ledger_name',
                        name: 'ledger.ledger_name'
                    },
                    {
                        data: 'payment_date',
                        name: 'payment_date'
                    },
                    {
                        data: 'fine_amount',
                        name: 'fine_amount'
                    },
                    {
                        data: 'payable_amount',
                        name: 'payable_amount'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount'
                    },
                    {
                        data:'reasons_view',
                        name:'reasons_view'
                    },
                    {
                        data: 'payment_type',
                        name: 'payment_type'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    // {
                    //     data: 'view',
                    //     name: 'view'
                    // }
                ]


            });

            // Event handler for the button click
            $('#voucherwise_search').on('click', function (e) {
                e.preventDefault();
                // Update the DataTable with new date range parameters and reload the table
                table.ajax.reload();
            });
        </script>
    @endpush
@endsection
