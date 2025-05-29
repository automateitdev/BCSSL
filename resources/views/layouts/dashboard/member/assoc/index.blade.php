@extends('home')

@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="mb-25">
                        <a href="#">Associators Info</a>
                        <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
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
                        <div class="row">
                            @if (isset($users))
                                <table class="table table-light table-hover table-striped table-sm table-bordered" id="associnfo">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="max-width: max-content"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Member No.</th>
                                            <th>Joining Date</th>
                                            <th>Share No.</th>
                                            <th>Share Quantity</th>
                                            <th>BCS Batch</th>
                                            <th>Designation</th>
                                            <th>Work Place</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            @if ($user->role == 2)
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->mobile }}</td>
                                                @foreach ($assocs as $assoc)
                                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)"
                                                            name="member_no" id="member_no"></td>
                                                    <td><input type="date" class="form-control" name="join_date" id="join_date"></td>
                                                    <td><input type="text" class="form-control" name="share_no" id="share_no"></td>
                                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)"
                                                            name="share_quantity" id="share_quantity"></td>
                                                    <td><input type="text" class="form-control" name="bcs_batch" id="bcs_batch"></td>
                                                    <td><input type="text" class="form-control" name="designation" id="designation"></td>
                                                    <td><input type="text" class="form-control" name="company" id="company"></td>
                                        @endforeach
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#example-select-all').prop('checked', false);
            let associnfotable = $('#associnfo').DataTable({
                stateSave: true,
                'columnDefs': [{
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) {
                        return '<input type="checkbox" class="enrollcheckformul" name="id[]" value="' +
                            $('<div/>').text(
                                data).html() + '">';
                    }
                }],
    
                'select': {
                    'style': 'multi',
                    'selector': 'td:first-child'
                }
    
            });
    
            // Handle click on "Select all" control
            $('#example-select-all').on('click', function() {
                // Get all rows with search applied
                var rows = associnfotable.rows({
                    'search': 'applied'
                }).nodes();
                if ($(this).prop('checked')) {
                    associnfotable.rows().select();
                } else {
                    associnfotable.rows().deselect();
                }
                // Check/uncheck checkboxes for all rows in the table
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });
    
            // // Handle click on checkbox to set state of "Select all" control
            $('#associnfo tbody').on('change', 'input[type="checkbox"]', function() {
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
    
            $('#associnfo tbody').on('click', 'tr td:first-child', function(e) {
                if ($(e.target).is(':checkbox')) return; //ignore when click on the checkbox
                var $cb = $(this).find(':checkbox.enrollcheckformul');
                var ticked = $cb.prop('checked', !$cb.is(':checked'));
            });
    
    
            $('.toast').toast({
                autohide: true,
                animation: true,
                delay: 3000
            });
    
            $('#enrollupdate').click(function(e) {
                e.preventDefault();
                // console.log($('#modalFeehead').modal('hide'));
                var selectedRowInputs = $('.selected select').find('option:selected');
                
                var member_tid = $.map(associnfotable.rows('.selected').data(), function(item) {
                    return item[1];
                });
                var rollArray = [];
                var memberArray = [];
                var roll = associnfotable.rows('.selected').nodes().to$().find('select').find('option:selected').each(function(){
                    rollArray.push($(this).val());
                    var collmember = $(this).parent().parent().parent().find("input[name=member_id]").val();
                    memberArray.push(collmember);
                });

                var status = $.map(associnfotable.rows('.selected').data(), function(item) {
                    return item[8];
                });
                // console.log(rollArray, memberArray);
    
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('member.approved') }}",
                    // data: selectedRowInputs.serialize()+'&sms_id='+sms_id+'&sms='+sms,
                    data: {
                        'member_tid': memberArray,
                        'status': rollArray
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
        // });
    </script>
@endsection
