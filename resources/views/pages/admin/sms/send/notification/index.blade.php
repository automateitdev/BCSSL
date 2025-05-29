@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))

@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="mb-25">
                        <a href="#">Due SMS</a>
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

                </div>
                <div class="col-md-2"></div>
            </div>

            <div class="row mt-5">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <table class="table table-striped table-bordered table-light table-hover table-sm" id="dueTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="max-width: max-content">
                                    <input type="checkbox" name="select_all" value="1" id="example-select-all">
                                </th>
                                <th width='5%'>Membership No</th>
                                <th width='15%'>Member Name</th>
                                <th width='15%'>Invoice No</th>
                                <th width='5%'>Year</th>
                                <th width='5%'>Month</th>
                                <th width='15%'>Payment Date</th>
                                <th width='35%'>Details</th>
                                <th width='10%'>Total Amount</th>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    {{-- //button  --}}
    <link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'>
    {{-- //input tupe date formate day month year --}}
    <style>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    {{-- //button --}}
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            // DataTable initialization
            var checkboxes;
            var Dbtable = $('#dueTable').DataTable({
                processing: true,
                serverSide: true,
                'select': {
                    'style': 'multi',
                    'selector': 'td:first-child'
                },
                ajax: {
                    url: "{{ route('admin.report.due.info.fetch') }}",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-Csrf-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    type: 'GET',
                },
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],

                dom: '<"row"<"col-md-6"B><"row col-md-6 p-0"<"col-md-6 p-0 text-right searchToggle"f><"col-md-6 p-0 text-right d-flex justify-content-end lengthToggle"l>>>rt<"row"<"col-md-6 text-left"i><"col-md-6 text-right"p>>',
                buttons: [{
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        filename: function() {
                            var d = new Date();
                            var n = d.getTime();
                            return 'DueInfos' + n;
                        },
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        filename: function() {
                            var d = new Date();
                            var n = d.getTime();
                            return 'DueInfos' + n;
                        },
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        filename: function() {
                            var d = new Date();
                            var n = d.getTime();
                            return 'DueInfos' + n;
                        },
                    },
                    {
                        text: "Send SMS",
                        attr: {
                            title: 'Notification SMS',
                            id: 'smsButton',
                            class: 'btn btn-info'
                        }
                    }
                ],
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
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
                    {
                        data: 'year',
                        name: 'year'
                    },
                    {
                        data: 'month',
                        name: 'month'
                    },
                    {
                        data: 'payment_date',
                        name: 'payment_date'
                    },
                    {
                        data: 'details',
                        name: 'details'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount'
                    },
                ],
            });

            // Handle click on "Select all" control
            $('#example-select-all').on('click', function() {
                // Get all rows with search applied
                var rows = Dbtable.rows({
                    'search': 'applied'
                }).nodes();
                if ($(this).prop('checked')) {
                    Dbtable.rows().select();
                } else {
                    Dbtable.rows().deselect();
                }
                // Check/uncheck checkboxes for all rows in the table
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            // Handle click on checkbox to set state of "Select all" control
            $('#dueTable tbody').on('change', 'input[type="checkbox"]', function() {
                if (!this.checked) {
                    var el = $('#example-select-all').get(0);
                    if (el && el.checked && ('indeterminate' in el)) {
                        el.indeterminate = true;
                    }
                }
            });

            $('#dueTable tbody').on('click', 'tr td:first-child', function(e) {
            if ($(e.target).is(':checkbox')) return; //ignore when click on the checkbox
            var $cb = $(this).find(':checkbox.smscheckformul');
            var ticked = $cb.prop('checked', !$cb.is(':checked'));
        });


            // sms send
            $('#smsButton').click(function(e) {
                e.preventDefault();

                var selectedRows = Dbtable.rows('.selected').data().toArray();

                var payInfo_ids = selectedRows.map(function(rowData) {
                    return rowData.id; // Assuming 'checkbox' is the correct property name
                });

                var details = selectedRows.map(function(rowData) {
                    return rowData.details;
                });

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.dueSmsSend') }}",
                    // data: selectedRowInputs.serialize()+'&sms_id='+sms_id+'&sms='+sms,
                    data: {
                        'id': payInfo_ids,
                        'details': details
                    },
                    success: function(data, textStatus, xhr) {
                        // Do something with the response data

                        // Check the XHR status
                        if (xhr.status === 201) {
                            $('#smsToast').html(
                                `<span class="text-success">${xhr.responseText}</span>`
                            );
                            $('.toast').toast('show');
                        } else {
                            // Do something if the status is not OK
                            console.log(xhr.status);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        if (xhr.status === 507) {
                            console.log(xhr.responseText);
                            $('#smsToast').html(
                                `<span class="text-danger">${xhr.responseText}</span>`
                            );
                            $('.toast').toast('show');
                        }
                    }
                });

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
