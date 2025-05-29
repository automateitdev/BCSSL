@extends('layouts.admin.admin-master')

@section('page_title',get_page_meta('title', true))
@section('content')
<div id="sms">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="mb-25">
                    <a href="#">Purchase SMS</a>
                    <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#smstemplateModal">
                        Add SMS
                    </button> -->
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
                @endif
                <div class="rkj">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>General SMS</h4>
                            <p>30 paisa per SMS</p>
                            <button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#smsModal">
                                Recharge Now
                            </button>
                        </div>
                        <div class="col-md-6">
                            <div class="ui">
                                <p>Your SMS Balance</p>
                                <p>{{$sms_data->sms_quantity ?? '0'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="smsModal" tabindex="-1" aria-labelledby="smsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="smsModalLabel">SMS Recharge</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('admin.sms.purchase.recharge')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="label-control">Quantity</label>
                                <input type="text" class="form-control" id="smsinput" onkeypress="return /[0-9]/i.test(event.key)" name="sms_quantity">
                            </div>
                            <div class="mb-3">
                                <label for="" class="label-control">Price</label>
                                <input type="text" disabled class="form-control" id="smsbuy_price">
                                <input type="hidden" class="form-control" id="sms_price" name="price">
                            </div>
                            <div class="mb-3 text-center">
                                <button class="btn btn-warning">Pay Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            $("#smsinput").keyup(function() {
                let sms_count = $("#smsinput").val();
                $amount = sms_count * 0.30;
                // console.log($amount);
                $("#sms_price").val($amount);
                $("#smsbuy_price").val($amount);
            });
        });
</script>
@endsection