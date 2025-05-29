@extends('layouts.admin.admin-master')

@section('page_title',get_page_meta('title', true))

@section('content')
<div id="enrollment_auto">
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="mb-25">
                    <a href="{{route('admin.associators-info.index')}}">{{ get_page_meta('title', true) }}</a>
                    <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                </h3>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-12 col-md-12 mt-5">
                <a href="{{route('admin.users.create')}}" class="btn btn-primary float-right mb-2">Add Admin</a>

                <table class="table table-light table-hover table-striped table-sm table-bordered" id="myTable">
                    <thead>
                        <tr>
                            {{-- <th class="text-center" style="max-width: max-content"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th> --}}
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($users) > 0)
                        @foreach($users as $key => $user)

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                   {{ $user->email }}
                                </td>
                                <td>
                                    @foreach($user->getRoleNames() as $name)
                                    <span class="badge badge-success" style="font-size: 14px;">
                                        {{ $name }}
                                    </span>
                                    @endforeach
                                </td>
                                <td>
                                    @can('Users Edit')
                                    <a href="{{ route('admin.users.edit',['user'=>$user->id]) }}" class="btn btn-success btn-sm">Edit</a>
                                    @endcan

                                    @can('Users Delete')
                                    @if($user->id != auth()->user()->id)
                                    <a href="{{ route('admin.users.destroy',['user'=>$user->id]) }}"
                                        data-dltform="role_form_{{ $user->id }}"
                                         class="btn btn-danger btn-sm  dlt_btn">Delete</a>

                                     <form  action="{{ route('admin.users.destroy',['user'=>$user->id]) }}" method="POST" class="d-none" id="role_form_{{ $user->id }}">
                                         @csrf
                                         {{-- // method spoofing --}}
                                         @method("DELETE")
                                     </form>
                                     @endif
                                    @endcan


                                    {{-- <a href="{{ route('Users.destroy',['role'=>$role->id]) }}" class="btn btn-danger btn-sm">Delete</a> --}}
                                </td>

                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

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

@endpush
@endsection

