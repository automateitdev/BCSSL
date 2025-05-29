@extends('layouts.admin.admin-master')

@section('page_title',get_page_meta('title', true))

@section('content')
    <div >
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="mb-25">
                        <a href="#">{{get_page_meta('title', true) }}</a>
                        <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                    </h2>
                </div>
            </div>
            <form action="{{route('admin.fees.payment.create')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="member_id" value="{{$member->id}}">
                <div class="card">
                    <div class="card-body">
                        @include('layouts.admin.partials.notificaion')
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @can('Quick Collection View')
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Quick Collection</button>
                                </li>
                            @endcan
                            @can('Quick Collection Invoices View')
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Quick Collection Invoices</button>
                                </li>
                            @endcan


                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <img src="{{$member->avatar_url}}" alt="{{$member->name}}"  class="img-fluid" style="    width: 91% !important;margin-top: 11px;height: 280px;">
                                        <p class="text-center">Member Id: {{ $member->associatorsInfo->membershp_number ?? '' }}</p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table">

                                                    <tbody>
                                                    <tr>
                                                        <td>Name</td>
                                                        <td>{{ $member->name ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>BCS Batch</td>
                                                        <td>{{ $member->bcs_batch ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cader Id</td>
                                                        <td>{{ $member->cader_id ?? '' }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Mobile</td>
                                                        <td>{{ $member->mobile ?? '' }}</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">

                                                    <div class="form-group">
                                                    <label for="receiveBt">Receive By</label>
                                                    <select name="ladger_id" id="fee_setup" class="form-control" required>
                                                        <option selected>Choose One</option>
                                                        @foreach($asset_acc_receive_by as $receive_by)
                                                            @if(count($receive_by->ledgers) > 0)
                                                                @foreach($receive_by->ledgers as $ledger)
                                                                <option value="{{$ledger->id}}">{{$ledger->ledger_name}} </option>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="document_files">Document</label>
                                                        <input type="file" class="form-control-file" name="document_files[]" id="document_files" multiple="multiple">
                                                    </div>
                                                    @php
                                                        $total_amount = 0;
                                                         foreach ($member->feeAssigns as $assign){
                                                            if(now_is_grater_old_date($assign->assign_date)){
                                                                $total_amount += $assign->amount + ($assign->fine_amount ?? 0);
                                                            }

                                                         }
                                                    @endphp
                                                    <div class="form-group grand_total" style="{{$total_amount <= 0 ? 'display:none': ''}} ">
                                                        <label for="grand_total">Total Amount</label>
                                                        <p id="total_amount">{{$total_amount}}</p>
                                                        @if($total_amount <= 0)
                                                        <input type="hidden" name="total_amount" id="grand_total"  required>
                                                        @else
                                                        <input type="hidden" name="total_amount" id="grand_total" value="{{$total_amount}}"  required>
                                                        @endif
                                                    </div>
                                                    @can('Quick Collection Add')
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                    @endcan


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (count($member->feeAssigns) > 0)
                                <div class="row mt-5">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">

                                    <div class="card">
                                        <div class="card body">
                                            <table class="table table-light table-hover table-striped table-sm table-bordered" id="feeheads1">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="max-width: max-content"><input type="checkbox"  class="select_all" id="example-select-all"></th>
                                                        <th>Fee Type</th>
                                                        <th>Fee Header</th>
                                                        <th>Year</th>
                                                        <th>Month</th>
                                                        <th>Activate Date</th>
                                                        <th>Fee Amount</th>
                                                        <th>Fine Amount</th>
                                                        <th>Total Amount</th>
                                                        <th>Status</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($member->feeAssigns->sortBy('assign_date') as $assign)
                                                        <tr>
                                                            <td style="text-align:center">

                                                            @if(now_is_grater_old_date($assign->assign_date))
                                                            <input type="checkbox"  class="single_check_sum user_single_check" data-userid="{{$assign->id}}" data-totalamount="{{$assign->amount + ($assign->fine_amount ?? 0)}}" {{ now_is_grater_old_date($assign->assign_date) ? 'checked' : '' }} >
                                                            @else
                                                            <input type="checkbox"  class="user_single_check single_check_sum" data-userid="{{$assign->id}}" data-totalamount="{{$assign->fee_setup->amount + ($assign->fee_setup->fine_amount ?? 0)}}" >
                                                            @endif
                                                            <input type="hidden" name="fee_assign_id[]" value="{{$assign->id}}" class="hide_user_check_{{$assign->id}}" {{ !now_is_grater_old_date($assign->assign_date) ? 'disabled' : '' }}>
                                                            {{-- <input type="hidden" name="fee_assign_id[]" value="{{$assign->id}}" class="hide_user_check_{{$assign->id}}" disabled> --}}

                                                            </td>

                                                            <td>{{$assign->fee_setup->monthly ? "Monthly" : "One Time"}}</td>

                                                            <td>{{$assign->fee_setup->fee_head}}</td>

                                                            <td>
                                                                {{\Carbon\Carbon::parse($assign->assign_date)->format('Y')}}
                                                            </td>
                                                            <td>
                                                                {{\Carbon\Carbon::parse($assign->assign_date)->format('F')}}
                                                            </td>

                                                            <td>{{!is_null($assign->assign_date)  ? $assign->assign_date : '' }}</td>

                                                            <td>{{ $assign->fee_setup->amount ?? 0 }}</td>
                                                            <td>{{ $assign->fine_amount ?? 0 }}</td>
                                                            <td>{{ $assign->fee_setup->amount + ($assign->fine_amount ?? 0) }}</td>

                                                        <td> <span class="badge {{ $assign->status == \App\Models\FeeAssign::STATUS_DUE ? 'badge-warning' : 'badge-success'}} ">{{ ucwords($assign->status) }}</span></td>


                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                    </div>
                                </div>

                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <img src="{{$member->avatar_url}}" alt="{{$member->name}}"  class="img-fluid" style="    max-width: 85% !important;margin-top: 11px;">
                                        <p class="text-center">Member Id: {{ $member->associatorsInfo->membershp_number ?? '' }}</p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table">

                                                    <tbody>
                                                    <tr>
                                                        <td>Name</td>
                                                        <td>{{ $member->name ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>BCS Batch</td>
                                                        <td>{{ $member->bcs_batch ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cader Id</td>
                                                        <td>{{ $member->cader_id ?? '' }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Mobile</td>
                                                        <td>{{ $member->mobile ?? '' }}</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @if(count($paymentInfos) > 0)
                                <div class="row mt-5">

                                    <div class="col-md-10 offset-1">

                                        <div class="card">
                                                <div class="card body">
                                                    <table class="table table-light table-hover table-striped table-sm table-bordered" id="feeheads">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" style="max-width: max-content"><input type="checkbox"  class="select_all" id="example-select-all"></th>
                                                                <th>Member Id</th>
                                                                <th>Payment Date</th>
                                                                <th>Invoice</th>
                                                                <th>Amount</th>
                                                                <th>Payment Status</th>
                                                                <th>Payment Type</th>

                                                                <th>Download</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($paymentInfos as $paymentInfo)
                                                                <tr>
                                                                    <td style="text-align:center">
                                                                        {{$loop->iteration}}

                                                                    </td>

                                                                    <td> {{ $member->associatorsInfo->membershp_number ?? '' }}</td>

                                                                    <td>
                                                                        {{\Carbon\Carbon::parse($paymentInfo->payment_date)->format('j F, Y')}}
                                                                    </td>

                                                                    <td>
                                                                        {{ $paymentInfo->invoice_no }}
                                                                    </td>

                                                                    <td>
                                                                       {{$paymentInfo->total_amount}}
                                                                    </td>

                                                                    <td>
                                                                        {{ucwords($paymentInfo->status)}}
                                                                     </td>
                                                                    <td>
                                                                        {{ucwords($paymentInfo->payment_type)}}
                                                                     </td>
                                                                     <td>
                                                                        @can('Quick Collection Invoices pdf View')
                                                                        <a href="{{ route('admin.payment.invoice',['id'=>$paymentInfo->id]) }}" class="btn btn-sm btn-success">Get Receipt</a>
                                                                        @endcan

                                                                     </td>


                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @endif
                    </div>
                </div>
            </form>




        </div>
    </div>


@endsection
@push('script')
<script>

    $(function(){
        if($("#feeheads1").length > 0){

        $('#feeheads1').DataTable();
        }
    })
</script>
@endpush
