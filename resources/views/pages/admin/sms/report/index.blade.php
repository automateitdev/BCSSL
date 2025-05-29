@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))
@section('content')
    <div id="sms">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="mb-25">
                        <a href="#">SMS History</a>
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <table class="table table-bordered table-light table-striped stdListforsms" id="history" style="font-weight:normal; font-size:.87rem; min-width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>SMS</th>
                                <th>Mobile No.</th>
                                <th>Response</th>
                                <th>Status</th>
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
    <script>
        $(function() {
            $('#history').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "{{ route('admin.smsReport.fetch') }}",
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-Csrf-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                },
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                dom: '<"row"<"col-md-6"B><"row col-md-6 p-0"<"col-md-6 p-0 text-right searchToggle"f><"col-md-6 p-0 text-right d-flex justify-content-end lengthToggle"l>>>rt<"row"<"col-md-6 text-left"i><"col-md-6"p>>',

                buttons: [{
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7] // Column index which needs to export
                        },
                        className:'btn btn-sm btn-danger',
                        //    text : 'paid infos',
                        filename: function() {
                            var d = new Date();
                            var n = d.getTime();
                            return 'sms_report' + n;
                        },
                    },
                    {
                        extend: 'csv',
                        className:'btn btn-sm btn-secondary',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7] // Column index which needs to export
                        },
                        filename: function() {
                            var d = new Date();
                            var n = d.getTime();
                            return 'sms_report' + n;
                        },
                    },
                    {
                        extend: 'excel',
                        className:'btn btn-sm btn-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7] // Column index which needs to export
                        },
                        filename: function() {
                            var d = new Date();
                            var n = d.getTime();
                            return 'sms_report' + n;
                        },
                    }
                ],

                columns: [
                    {
                        data: 'member.name',
                        name: 'name'
                    },
                    {
                        data: 'msg',
                        name: 'message'
                    },
                    {
                        data: 'number',
                        name: 'number'
                    },
                    {
                        data: 'response',
                        name: 'response'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ]
            });
        });
    </script>
@endsection
