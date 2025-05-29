@extends('layouts.admin.admin-master')

@section('page_title',get_page_meta('title', true))

@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="mb-25">
                        <a href="#">{{get_page_meta('title', true)}}</a>
                        <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <member-register :user-gender="{{$user_gender}}" :user-blood-group="{{ $user_blood_group }}"/>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @push('script')

    @endpush

@endsection
