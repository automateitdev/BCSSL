@extends('layouts.admin.admin-master')

@section('page_title',get_page_meta('title', true))

@section('content')
<div id="enrollment_auto">
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="mb-25">
                    <a href="{{route('admin.associators-info.edit',$assoc_info->id)}}">{{ get_page_meta('title', true) }}</a>
                    <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 mt-5">

            <form action="{{route('admin.associators-info.update',$assoc_info->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="exampleInputEmail1">User Name</label>
                    <input type="text" class="form-control" value="{{$assoc_info->user->name}}" readonly>

                </div>
                <div class="form-group">
                    <label for="membershp_number"> Membership Number (Office use only)
                    </label>
                    <input type="text" id="membershp_number" class="form-control" name="membershp_number" value="{{$assoc_info->membershp_number ?? old('membershp_number')}}" required>
                    @error('membershp_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="approval_date">Date of approval
                    </label>
                    <input type="date" id="approval_date" class="form-control" name="approval_date" value="{{$assoc_info->approval_date ?? old('approval_date')}}" required>
                    @error('approval_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="num_or_shares">Number of share/s
                    </label>
                    <input type="number" id="num_or_shares" class="form-control" name="num_or_shares" value="{{$assoc_info->num_or_shares ?? old('num_or_shares')}}" required>
                    @error('num_or_shares')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>

            </div>
        </div>
    </div>
</div>
@push('style')
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> --}}
@endpush
@push('script')


@endpush
@endsection

