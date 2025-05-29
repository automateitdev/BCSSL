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
                                    <th>Name</th>
                                    <th>Gender</th>

                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        {{-- <td style="text-align:center">
                                    {{$loop->iteration}}
                                </td> --}}
                                        <td style="text-align:center">
                                            <input type="checkbox" class="payment_single_check"
                                                data-id="{{ $user->id }}">
                                            <input type="hidden" name="member[{{ $key }}][member_id]"
                                                value="{{ $user->id }}" class="payment_value_one_{{ $user->id }}"
                                                disabled>

                                        </td>
                                        <td>{{ $user->name }}
                                            {{-- <input type="hidden" name="member_id" value="{{$user->id}}"> --}}
                                        </td>
                                        <td>{{ $user->gender }}</td>

                                        <td>{{ $user->mobile }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td> {{ ucfirst($user->status) }}</td>
                                        <td>
                                            @can('Profile Approval Edit')
                                                {{-- <form action="{{route('admin.approval.update')}}" method="post" id="status_form_{{$user->id}}">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                        <select  name="status" id="status_change" data-userid="{{$user->id}}" class="form-control status_change">
                                            <option value="{{\App\Models\User::STATUS_INACTIVE}}" >Inactive</option>
                                            <option value="{{  \App\Models\User::STATUS_ACTIVE }} ">Active</option>
                                            <option value=" {{\App\Models\User::STATUS_SUSPENDED}}">Suspended</option>
                                        </select>
                                    </form> --}}
                                                {{-- <select   name="member[{{$key}}][status]" id="status_change"  class="form-control status_change  payment_value_one_{{$user->id}}" disabled>
                                        <option value="{{\App\Models\User::STATUS_INACTIVE}}" >Inactive</option>
                                        <option value="{{  \App\Models\User::STATUS_ACTIVE }} ">Active</option>
                                        <option value=" {{\App\Models\User::STATUS_SUSPENDED}}">Suspended</option>
                                    </select> --}}

                                                @if ($user->status !== \App\Models\User::STATUS_INACTIVE)
                                                    <div class="form-check">
                                                        <input type="radio" name="member[{{ $key }}][status]"
                                                            id="status_inactive_{{ $key }}"
                                                            value="{{ \App\Models\User::STATUS_INACTIVE }}"
                                                            class="form-check-input status_change payment_value_one_{{ $user->id }}"
                                                            disabled>
                                                        <label for="status_inactive_{{ $key }}"
                                                            class="form-check-label">Inactive</label>
                                                    </div>
                                                @endif
                                                @if ($user->status !== \App\Models\User::STATUS_ACTIVE)
                                                    <div class="form-check">
                                                        <input type="radio" name="member[{{ $key }}][status]"
                                                            id="status_active_{{ $key }}"
                                                            value="{{ \App\Models\User::STATUS_ACTIVE }}"
                                                            class="form-check-input status_change payment_value_one_{{ $user->id }}"
                                                            disabled>
                                                        <label for="status_active_{{ $key }}"
                                                            class="form-check-label">Active</label>
                                                    </div>
                                                @endif

                                                @if ($user->status !== \App\Models\User::STATUS_SUSPENDED)
                                                    <div class="form-check">
                                                        <input type="radio" name="member[{{ $key }}][status]"
                                                            id="status_suspended_{{ $key }}"
                                                            value="{{ \App\Models\User::STATUS_SUSPENDED }}"
                                                            class="form-check-input status_change payment_value_one_{{ $user->id }}"
                                                            disabled>
                                                        <label for="status_suspended_{{ $key }}"
                                                            class="form-check-label">Suspend</label>
                                                    </div>
                                                @endif
                                            @endcan

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
                                <button type="submit" class="btn btn-success btn-sm mb-3"><i class="fa fa-check-circle"></i> Apply</button>
                            </div>
                        </div>
                    </form>
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
            let table = new DataTable('#myTable');
        </script>
        <script>
            $(document).ready(function() {
                $(document).on('change', '.status_change', function(e) {
                    e.preventDefault();
                    let user_id = $(this).data('userid');
                    $(`#status_form_${user_id}`).submit();
                    // console.log(user_id);
                })
                // console.log('chck');
            });
        </script>
    @endpush
@endsection
