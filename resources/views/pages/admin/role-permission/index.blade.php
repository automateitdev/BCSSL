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
                <a href="{{route('admin.roles.create')}}" class="btn btn-primary float-right mb-2">Add Role</a>

                <table class="table table-light table-hover table-striped table-sm table-bordered" id="myTable">
                    <thead>
                        <tr>
                            {{-- <th class="text-center" style="max-width: max-content"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th> --}}
                            <th>No</th>
                            <th>Name</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($roles) > 0)
                        @foreach ($roles  as $role)
                            <tr>
                                <td style="text-align:center">
                                    {{$loop->iteration}}
                                </td>

                                <td>{{$role->name}}</td>


                                <td>
                                    @can('Roles Edit')
                                    <a href="{{route('admin.roles.edit',$role->id)}}" class="btn btn-success">Edit</a>
                                    @endcan


                                    {{-- <a href="{{ route('admin.roles.destroy',['role'=>$role->id]) }}"
                                        onclick="event.preventDefault();
                                            document.getElementById('roleDestry_{{ $role->id }}').submit();"
                                        class="btn btn-danger">Delete</a>

                                    <form  action="{{ route('admin.roles.destroy',['role'=>$role->id]) }}" method="POST" class="d-none" id="roleDestry_{{ $role->id }}">
                                        @csrf

                                        @method("DELETE")
                                    </form> --}}
                                    @can('Roles Delete')
                                    <a href="{{ route('admin.roles.destroy',['role'=>$role->id]) }}"
                                        data-dltform="role_form_{{ $role->id }}"
                                         class="btn btn-danger  dlt_btn">Delete</a>

                                     <form  action="{{ route('admin.roles.destroy',['role'=>$role->id]) }}" method="POST" class="d-none" id="role_form_{{ $role->id }}">
                                         @csrf
                                         {{-- // method spoofing --}}
                                         @method("DELETE")
                                     </form>

                                    @endcan

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

