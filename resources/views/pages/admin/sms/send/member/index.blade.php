@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))
@section('content')
    <div id="fee_amount">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="mb-25">
                        <a href="{{ route('admin.member.sms.index') }}">Message Sending (Member)</a>
                    </h2>
                </div>
            </div>
            <div class="row">
                <!-- toast -->
                @include('layouts.message.toast')
                <!-- toast end-->
                <div class="row mt-2">
                    <div class="col-md-8">
                        <form action="{{ route('admin.member.sms.send') }}" method="POST" id="smsform">
                            @csrf
                            <div class="rkj">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Template</label>
                                            <select class="form-control single smstitle" name="sms_id" id="sms_id">
                                                <option selected value="">Choose one title</option>
                                                @foreach ($data as $item)
                                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 smsbody">
                                            <label for="sms" class="form-label">SMS Body</label>
                                            <textarea name="sms" id="sms" cols="35" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" id="sendsms">Send SMS</button>
                            </div>
                    </div>
                </div>
                @if (isset($members))
                    <div class="row mt-2">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <table class="table table-bordered table-light table-striped stdListforsms" id="smsDataTable"
                                style="font-weight:normal; font-size:.87rem; ">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="max-width: max-content"><input type="checkbox"
                                                name="select_all" value="1" id="example-select-all"></th>
                                        {{-- <th>Serial</th> --}}
                                        <th>Cader ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Mobile No.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $item)
                                        <tr>
                                            <td style="text-align:center"></td>
                                            {{-- <td>{{ $item->id }}</td> --}}
                                            <td>{{ $item->cader_id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->gender }}</td>
                                            <td>{{ $item->formatted_number }}</td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(document).on('change', '.smstitle', function() {

                let sms_id = $("select[name=sms_id]").val();
                var op = " ";
                $.ajax({
                    type: 'get',
                    url: '{{ route("admin.getsmsbody") }}',
                    data: {
                        'id': sms_id
                    },
                    success: function(data) {

                        $('.smsbody').html(" ");

                        op += '<label for="sms" class="form-label">SMS Body</label>';
                        // for (var key in data) {
                        op += '<textarea name="sms" id="sms" cols="35" rows="5">' + data[
                            'sms'] + '</textarea>';

                        // }
                        $('.smsbody').append(op);

                    },

                });

            });

            $("#smsinput").keyup(function() {
                let sms_count = $("#smsinput").val();
                $amount = sms_count * 0.30;
                // console.log($amount);
                $("#sms_price").val($amount);
                $("#smsbuy_price").val($amount);
            });
        });
        $(function() {
            $('#example-select-all').prop('checked', false);
            let mysmsTable = $('#smsDataTable').DataTable({
                stateSave: true,
                'columnDefs': [{
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) {
                        return '<input type="checkbox" class="smscheckformul" name="id[]" value="' +
                            $('<div/>').text(
                                data).html() + '">';
                    }
                }],

                'select': {
                    'style': 'multi',
                    'selector': 'td:first-child'
                },
                'order': [
                    [1, 'asc']
                ]

            });

            // Handle click on "Select all" control
            $('#example-select-all').on('click', function() {
                // Get all rows with search applied
                var rows = mysmsTable.rows({
                    'search': 'applied'
                }).nodes();
                if ($(this).prop('checked')) {
                    mysmsTable.rows().select();
                } else {
                    mysmsTable.rows().deselect();
                }
                // Check/uncheck checkboxes for all rows in the table
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            // // Handle click on checkbox to set state of "Select all" control
            $('#smsDataTable tbody').on('change', 'input[type="checkbox"]', function() {
                // If checkbox is not checked
                if (!this.checked) {
                    var el = $('#example-select-all').get(0);
                    // If "Select all" control is checked and has 'indeterminate' property
                    if (el && el.checked && ('indeterminate' in el)) {
                        // Set visual state of "Select all" control
                        // as 'indeterminate'
                        el.indeterminate = true;
                    }
                }
            });

            $('#smsDataTable tbody').on('click', 'tr td:first-child', function(e) {
                if ($(e.target).is(':checkbox')) return; //ignore when click on the checkbox
                var $cb = $(this).find(':checkbox.smscheckformul');
                var ticked = $cb.prop('checked', !$cb.is(':checked'));
            });


            $('.toast').toast({
                autohide: true,
                animation: true,
                delay: 3000
            });

            $('#sendsms').click(function(e) {
                e.preventDefault();
                // console.log($('#modalFeehead').modal('hide'));
                var selectedRowInputs = $('.selected input');
                var sms = $('#sms').val();
                var sms_id = $('#sms_id').val();

                var member_id = $.map(mysmsTable.rows('.selected').data(), function(item) {
                    return item[1];
                });

                var mobile_no = $.map(mysmsTable.rows('.selected').data(), function(item) {
                    return item[5];
                });

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route("admin.member.sms.send") }}',
                    // data: selectedRowInputs.serialize()+'&sms_id='+sms_id+'&sms='+sms,
                    data: {
                        'id': member_id,
                        'formatted_number': mobile_no,
                        'sms': sms,
                        'sms_id': sms_id
                    },
                    success: function(data, textStatus, xhr) {
                        // Do something with the response data
                        console.log(data);

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

@endsection
