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
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <div class="rkj">
                        <form method="POST" id="myForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="from" class="form-label">From</label>
                                        {{-- <input type="date" name="from" id="from" class="form-control"> --}}
                                        <input type="date" data-date="" data-date-format="DD MMMM YYYY" name="from"
                                            id="from" class="form-control"
                                            value="{{ old('from') ?? \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="to" class="form-label">To</label>
                                        {{-- <input type="date" name="to" id="to" class="form-control"> --}}
                                        <input type="date" data-date="" data-date-format="DD MMMM YYYY" name="to"
                                            id="to" class="form-control"
                                            value="{{ old('to') ?? \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-info btn-block"> <i
                                        class="fa fa-plus-cirlce"></i>Search</button>
                            </div>


                        </form>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            {{-- @if (isset($feesetups))
            <div class="row mt-5">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <table class="table table-striped table-bordered table-light table-hover table-sm" id="feeheads">
                        <thead>
                            <tr>
                                <th>Fee Head</th>
                                <th>Fine</th>
                                <th>Amount</th>
                                <th>Fee Type</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feesetups as $fee)
                            <tr>
                                <td>{{$fee->fee_head}}</td>
                                <td>{{$fee->fine}}</td>
                                <td>{{$fee->amount}}</td>
                                <td>{{$fee->monthly ? 'Monthly' : 'One Time'}}</td>
                                <td>{{$fee->date}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-1"></div>
            </div>
            @endif --}}
            <div class="row mt-5">
                <div class="col-md-1"></div>
                <div class="">
                    <table class="table display table-striped table-bordered table-light table-hover table-sm"
                        id="myTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#No.</th>
                                <th>Membership No.</th>
                                <th>Invoice</th>
                                {{-- <th>Year</th>
                                <th>Month</th> --}}
                                <th>Details</th>
                                <th>Payment Method</th>
                                <th>Paid Amount</th>
                                <th>Fine Amount</th>
                                <th>Member Since</th>
                                <th>Total Savings</th>
                                <th>Total Fine</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>


@endsection
@push('style')
    {{-- //data table  --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"> --}}
    {{-- //button  --}}
    {{-- <link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'> --}}
    {{-- //input tupe date formate day month year --}}
    <style>
        table.display tr td {
            min-width: fit-content !important;
        }

        input {
            position: relative;
            width: 150px;
            height: 20px;
            color: white;
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
    </style>
    {{-- //input tupe date formate day month year(end) --}}
@endpush
@push('script')
    {{-- //datatable --}}
    <script src="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    {{-- //button --}}
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {

            $(document).on('submit', '#myForm', function(e) {
                e.preventDefault();
                $('#myTable').DataTable().draw();
            });

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "{{ route('admin.report.paid.info.search') }}",
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-Csrf-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    data: function(d) {
                        d.to = $('#to').val();
                        d.from = $('#from').val();
                    }
                },
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                dom: '<"row"<"col-md-6"B><"row col-md-6 p-0"<"col-md-6 p-0 text-right searchToggle"f><"col-md-6 p-0 text-right d-flex justify-content-end lengthToggle"l>>>rt<"row"<"col-md-6 text-left"i><"col-md-6 text-right"p>>',

                buttons: [{
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 4, 5, 6, 7, 8, 9],
                        },
                        className: 'btn btn-sm btn-danger',
                        //    text : 'paid infos',
                        filename: function() {
                            var d = new Date();
                            var n = d.getTime();
                            return 'PaidInfos' + n;
                        },
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] // Column index which needs to export
                        },
                        className: 'btn btn-sm btn-secondary',
                        filename: function() {
                            var d = new Date();
                            var n = d.getTime();
                            return 'PaidInfos' + n;
                        },
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] // Column index which needs to export
                        },
                        className: 'btnb btn-sm btn-success',
                        filename: function() {
                            var d = new Date();
                            var n = d.getTime();
                            return 'PaidInfos' + n;
                        },
                    }
                ],
                columns: [{
                        data: 'membership_no',
                        name: 'membership_no'
                    },
                    {
                        data: 'member_name',
                        name: 'member_name'
                    },
                    {
                        data: 'invoice_no',
                        name: 'invoice_no'
                    },
                    // {
                    //     data: 'year',
                    //     name: 'year'
                    // },
                    // {
                    //     data: 'month',
                    //     name: 'month'
                    // },
                    {
                        data: 'details',
                        name: 'details'
                    },
                    {
                        data: 'payment_type',
                        name: 'payment_type'
                    },


                    {
                        data: 'payable_amount',
                        name: 'payable_amount',
                        // render: function(data, type, full, meta) {
                        //     if (data) {
                        //         var formattedAmount = parseFloat(data).toLocaleString('en-US', {
                        //             style: 'currency',
                        //             currency: 'BDT'
                        //         });
                        //         return formattedAmount;
                        //     } else {
                        //         return '';
                        //     }
                        // }
                    },

                    {
                        data:'fine_amount',
                        name: 'fine_amount',
                    },
                    {
                        data: 'member.joining_date',
                        name: 'joining_date',
                    },
                    {
                        data: 'total_payment_since_joining',
                        name: 'total_payment_since_joining',
                        // render: function(data, type, full, meta) {
                        //     if (data) {
                        //         var formattedAmount = parseFloat(data).toLocaleString('en-US', {
                        //             style: 'currency',
                        //             currency: 'BDT'
                        //         });
                        //         return formattedAmount;
                        //     } else {
                        //         return '';
                        //     }
                        // }
                    },

                    {
                        data: 'total_fine_since_joining',
                        name: 'total_fine_since_joining',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });


        });
    </script>


    {{-- //input tupe date formate day month year --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
    <script>
        $("input").on("change", function() {

            this.setAttribute(
                "data-date",
                moment(this.value, "YYYY-MM-DD")
                .format(this.getAttribute("data-date-format"))
            )
        }).trigger("change")
    </script>
    {{-- //input tupe date formate day month year(end) --}}
    {{-- <script>

    $(function(){
        $('#feeheads').DataTable();
    })
</script> --}}
@endpush
