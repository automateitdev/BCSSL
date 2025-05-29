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

                </div>
                <div class="col-md-2"></div>
            </div>

            <div class="row mt-5">
                <div class="col-md-1"></div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-light table-hover table-sm" id="myTable">
                        <thead>
                            <tr>
                                <th width='5%'>Membership No</th>
                                <th width='15%'>Member Name</th>
                                <th width='15%'>Image</th>
                                <th width='15%'>Email</th>
                                <th width='15%'>Cader Id</th>
                                <th width='15%'>BCS Batch</th>
                                <th width='15%'>Gender</th>
                                <th width='15%'>Status</th>

                                <th width='10%'>Action</th>
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
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> --}}
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('plugins/Image-PDF-Viewer-EZView/EZView.js') }}"></script>
    <script src="{{ asset('plugins/Image-PDF-Viewer-EZView/draggable.js') }}"></script>

    <script type="text/javascript">
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
                    url: "{{ route('admin.report.member.list.fetch') }}",
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
                // dom: '<"row"<"col-md-6"B><"row col-md-6 p-0"<"col-md-6 p-0 text-right searchToggle"f><"col-md-6 p-0 text-right d-flex justify-content-end lengthToggle"l>>>rt<"row"<"col-md-6 text-left"i><"col-md-6"p>>',

                buttons: [{
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7] // Column index which needs to export
                        },
                        //    text : 'paid infos',
                        filename: function() {
                            var d = new Date();
                            var n = d.getTime();
                            return 'MemberListReport' + n;
                        },
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7] // Column index which needs to export
                        },
                        filename: function() {
                            var d = new Date();
                            var n = d.getTime();
                            return 'MemberListReport' + n;
                        },
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7] // Column index which needs to export
                        },
                        filename: function() {
                            var d = new Date();
                            var n = d.getTime();
                            return 'MemberListReport' + n;
                        },
                    }
                ],
                columns: [
                    // {
                    //     data: 'id',
                    //     name: 'id'
                    // },
                    {
                        data: 'membership_no',
                        name: 'membership_no'
                    },
                    {
                        data: 'member_name',
                        name: 'member_name'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },

                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'cader_id',
                        name: 'cader_id'
                    },
                    {
                        data: 'bcs_batch',
                        name: 'bcs_batch'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
