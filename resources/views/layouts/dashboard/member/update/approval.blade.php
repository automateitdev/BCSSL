@extends('home')

@section('content')

    <div id="enrollment_auto">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="mb-25">
                        <a href="{{route('approval.index')}}">Approval</a> 
                        <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 mt-5">
                <!-- toast -->
                <div class="position-fixed top-0 end-0 p-3 fa-fade" style="z-index: 1111">
                    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-primary text-white">
                            <strong class="me-auto">SMS Notification</strong>
                            <small class="text-muted">just now</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body" id="smsToast">
                        </div>
                    </div>
                </div>
                <!-- toast end-->
                
                    <table class="table table-light table-hover table-striped table-sm table-bordered" id="enrolltable">
                        <thead>
                            <tr>
                                <th class="text-center" style="max-width: max-content"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Religion</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users  as $user)
                                <tr>
                                    <td style="text-align:center"></td>
                                    <td>{{$user->name}}
                                        <input type="hidden" name="member_id" value="{{$user->id}}">
                                    </td>
                                    <td>{{$user->gender}}</td>
                                    <td>{{$user->religion}}</td>
                                    <td>{{$user->mobile}}</td>
                                    <td>{{$user->email}}</td>
                                    @if ($user->role==3)
                                        <td>Pending</td>
                                    @elseif ($user->role==2)
                                        <td>Active</td>
                                    @elseif ($user->role==1)
                                        <td>Admin</td>
                                    @elseif ($user->role==4)
                                        <td>Operator</td>
                                    @elseif ($user->role==0)
                                        <td>Inactive</td>
                                    @endif
                                    <td>
                                        <select name="role" id="role" class="form-control">
                                            <option value="3">Pending</option>
                                            <option value="2">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-info" id="enrollupdate">Update</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('#example-select-all').prop('checked', false);
            let myenrolltable = $('#enrolltable').DataTable({
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
                var rows = myenrolltable.rows({
                    'search': 'applied'
                }).nodes();
                if ($(this).prop('checked')) {
                    myenrolltable.rows().select();
                } else {
                    myenrolltable.rows().deselect();
                }
                // Check/uncheck checkboxes for all rows in the table
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });
    
            // // Handle click on checkbox to set state of "Select all" control
            $('#enrolltable tbody').on('change', 'input[type="checkbox"]', function() {
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
    
            $('#enrolltable tbody').on('click', 'tr td:first-child', function(e) {
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
                
                var member_tid = $.map(myenrolltable.rows('.selected').data(), function(item) {
                    return item[1];
                });
                var rollArray = [];
                var memberArray = [];
                var roll = myenrolltable.rows('.selected').nodes().to$().find('select').find('option:selected').each(function(){
                    rollArray.push($(this).val());
                    var collmember = $(this).parent().parent().parent().find("input[name=member_id]").val();
                    memberArray.push(collmember);
                });

                var status = $.map(myenrolltable.rows('.selected').data(), function(item) {
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