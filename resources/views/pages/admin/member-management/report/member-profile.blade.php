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
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Labore aperiam dolores blanditiis deserunt unde, ipsam adipisci officia expedita? Maiores rerum odio maxime tenetur, incidunt enim obcaecati fugiat unde consequatur sint.
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
            width: 150px; height: 20px;
            color: white;
        }

        input:before {
            position: absolute;
            top: 3px; left: 3px;
            content: attr(data-date);
            display: inline-block;
            color: black;
        }

        input::-webkit-datetime-edit, input::-webkit-inner-spin-button, input::-webkit-clear-button {
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

        $(document).on('submit', '#myForm', function(e) {
            e.preventDefault();
            $('#myTable').DataTable().draw();
        });

        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('admin.report.member.list.fetch')}}",
                type: 'GET',

            },
            dom: 'Blfrtip',
            buttons: [
               {
                   extend: 'pdf',
                   exportOptions: {
                       columns: [0,1,2,3,4,5,6,7] // Column index which needs to export
                   },
                //    text : 'paid infos',
                   filename: function(){
                        var d = new Date();
                        var n = d.getTime();
                        return 'MemberListReport' + n;
                    },
               },
               {
                   extend: 'csv',
                   exportOptions: {
                       columns: [0,1,2,3,4,5,6,7] // Column index which needs to export
                   },
                   filename: function(){
                        var d = new Date();
                        var n = d.getTime();
                        return 'MemberListReport' + n;
                    },
               },
               {
                   extend: 'excel',
                   exportOptions: {
                       columns: [0,1,2,3,4,5,6,7] // Column index which needs to export
                   },
                   filename: function(){
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
            .format( this.getAttribute("data-date-format") )
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
