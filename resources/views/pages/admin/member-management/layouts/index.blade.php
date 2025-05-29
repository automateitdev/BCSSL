@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))

@section('content')
    <div id="enrollment_auto">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="mb-25">
                        <a href="{{ route('admin.approval.list') }}">{{ get_page_meta('title', true) }}</a>
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
                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                            <div class="toast-body" id="smsToast">
                            </div>
                        </div>
                    </div>
                    <!-- toast end-->
                    <form action="{{ route('admin.approval.all.update') }}" method="POST">
                        @csrf
                        <table class="table table-light table-hover table-striped table-sm table-bordered" id="myTable">
                            <thead>
                                <tr>
                                    {{-- <th class="text-center" style="max-width: max-content"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th> --}}
                                    {{-- <th class="text-center" style="max-width: max-content">No</th> --}}
                                    <th class="text-center" style="max-width: max-content">
                                        <input type="checkbox" class="select_all_payment" id="example-select-all">
                                    </th>
                                    <th>Member No.</th>
                                    <th>Bcs Batch</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td style="text-align:center">
                                            <input type="checkbox" class="payment_single_check"
                                                data-id="{{ $user->id }}">
                                            <input type="hidden" name="member[{{ $key }}][member_id]"
                                                value="{{ $user->id }}" class="payment_value_one_{{ $user->id }}"
                                                disabled>
                                        </td>
                                        <td>
                                            {{ $user->associatorsInfo->membershp_number }}
                                        </td>
                                        <td>
                                            {{ $user->bcs_batch }}
                                        </td>
                                        <td>{{ $user->name }}
                                            {{-- <input type="hidden" name="member_id" value="{{$user->id}}"> --}}
                                        </td>
                                        <td>{{ $user->gender }}</td>

                                        <td>{{ $user->mobile }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td> {{ ucfirst($user->status) }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <div class="row">
                            <div class="col-md-6 text-right">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                        name="sms" value="yes">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Send SMS</label>
                                </div>
                            </div>
                            <div class="col-md-6 text-left">
                                <button type="submit" class="btn btn-success btn-sm mb-3"><i
                                        class="fa fa-check-circle"></i> Apply</button>
                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="certifyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p>Do you want to generate Certificate(s) ?</p>
                        <div>
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-success" id="certify_confirm"><span
                                    id="certify_spinner"><i class="fa fa-circle-notch fa-spin"></i></span> Generate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="idCardModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p>Do you want to generate ID Card(s) ?</p>
                        <div>
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-success" id="id-card_confirm"><span
                                    id="idCard_spinner"><i class="fa fa-circle-notch fa-spin"></i></span> Generate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    @endpush
    @push('script')
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#certify_spinner').hide();
                $('#idCard_spinner').hide();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                let datatable = $("#myTable").DataTable({
                    dom: 'Bflrtip',
                    buttons: [{
                        text: 'Certify',
                        attr: {
                            title: 'Certify',
                            id: 'certify'
                        },
                        className: 'btn btn-sm btn-success',
                        action: function() {
                            $('#certifyModal').modal('show'); // Show your Certify modal
                        }
                    }, {
                        text: 'ID Card',
                        attr: {
                            title: 'id-card',
                            id: 'id-card'
                        },
                        className: 'btn btn-sm btn-dark',
                        action: function() {
                            $('#idCardModal').modal('show'); // Show your ID Card modal
                        }
                    }]
                })

                $.ajaxSetup({
                    xhrFields: {
                        responseType: 'blob'
                    }
                });

                $("#certify_confirm").on('click', function(e) {
                    var checkedCheckboxes = $("input[type='checkbox'].payment_single_check:checked");
                    if (checkedCheckboxes.length == 0) {
                        alert("Error: No member selected to certify!!");
                    } else {
                        $('#certify_spinner').show();
                        $('#certify_confirm').prop('disabled', true);
                        const dataId = [];
                        checkedCheckboxes.each(function() {
                            dataId.push($(this).attr('data-id'));
                        });

                        $.ajax({
                            url: "{{ route('admin.layout.member.list.process-info') }}",
                            method: 'POST',
                            headers: {
                                "Authorization": "Bearer {{ $apiToken ?? '' }}",
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-Csrf-Token': csrfToken
                            },
                            xhrFields: {
                                withCredentials: true,
                                responseType: 'blob'
                            },
                            data: {
                                users: dataId,
                                type: 'certificate'
                            },
                            success: function(response) {
                                // Handle the success response from the server
                                console.log(response);

                                // Create a blob URL and initiate a download
                                var blob = new Blob([response]);
                                var link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                link.download = "certificate.pdf";
                                link.click();

                                $('#certify_spinner').hide();
                                $('#certify_confirm').prop('disabled', false);

                            },
                            error: function(error) {
                                // Handle the error response from the server
                                console.error(error);
                                $('#certify_spinner').hide();
                                $('#certify_confirm').prop('disabled', false);

                            }
                        });
                    }
                });


                $("#id-card_confirm").on('click', function(e) {
                    var checkedCheckboxes = $("input[type='checkbox'].payment_single_check:checked");
                    if (checkedCheckboxes.length == 0) {
                        alert("Error: No member selected to give ID card!!");
                    } else {
                        $('#idCard_spinner').show();
                        $('#id-card_confirm').prop('disabled', true);
                        const dataId = [];
                        checkedCheckboxes.each(function() {
                            dataId.push($(this).attr('data-id'));
                        });

                        $.ajax({
                            url: "{{ route('admin.layout.member.list.process-info') }}",
                            method: 'POST',
                            headers: {
                                "Authorization": "Bearer {{ $apiToken ?? '' }}",
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-Csrf-Token': csrfToken
                            },
                            xhrFields: {
                                withCredentials: true,
                                responseType: 'blob'
                            },
                            data: {
                                users: dataId,
                                type: 'id-card'
                            },
                            success: function(response) {
                                // Handle the success response from the server
                                console.log(response);

                                // Create a blob URL and initiate a download
                                var blob = new Blob([response]);
                                var link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                link.download = "id_card.pdf"; // Set the desired filename
                                link.click();

                                $('#idCard_spinner').hide();
                                $('#id-card_confirm').prop('disabled', false);

                            },
                            error: function(error) {
                                // Handle the error response from the server
                                console.error(error);
                                $('#idCard_spinner').hide();
                                $('#id-card_confirm').prop('disabled', false);

                            }
                        });
                    }
                });


            });
        </script>
    @endpush
@endsection
