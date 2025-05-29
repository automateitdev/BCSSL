@extends('layouts.admin.admin-master')

@section('page_title',get_page_meta('title', true))

@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="mb-25">
                        <a href="#">Fee Assign</a>
                        <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                    </h2>
                </div>
            </div>
             <form action="{{ route('admin.fees.assign.submit') }}" method="POST">
             @csrf
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    {{-- @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif --}}
                    <div class="rkj">
                        {{-- <form action="{{ route('admin.fees.store') }}" method="POST"> --}}
                            @csrf
                            @if(count($feesetups) > 0)
                            <div class="mb-3">
                                <label for="fee_setup" class="form-label">Fee Type</label>
                                <select name="fee_setup_id" id="fee_setup" class="form-control" required>
                                    <option selected>Choose One</option>
                                    @foreach($feesetups as $feesetup)
                                    <option value="{{$feesetup->id}}">{{$feesetup->fee_head}} - ({{ $feesetup->monthly ? 'Monthly' : 'On Time' }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 fine_assign_date" style="display:none">
                                <label for="fine_assign_date" class="form-label">Fine Assign Start Date</label>
                                <input type="date" name="fine_assign_date" id="fine_assign_date" class="form-control" disabled>
                            </div>
                            <div class="row month_sec_div" >
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="month_id" class="form-label">Month &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<span> <input class="form-check-input" type="checkbox" id="select_all_month"></span></label>
                                        <div class="fee_assign_month">
                                            <div>
                                                <div class="form-check">
                                                    <input class="form-check-input check_month month_sec_val" type="checkbox" value="1"  name="month_id[]" id="defaultCheck1">
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        January
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input check_month month_sec_val" type="checkbox" value="2"  name="month_id[]" id="defaultCheck2">
                                                    <label class="form-check-label" for="defaultCheck2">
                                                        February
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input check_month month_sec_val" type="checkbox" value="3"  name="month_id[]" id="defaultCheck3">
                                                    <label class="form-check-label" for="defaultCheck3">
                                                        March
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input check_month month_sec_val" type="checkbox" value="4"  name="month_id[]" id="defaultCheck4">
                                                    <label class="form-check-label" for="defaultCheck4">
                                                        April
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input check_month month_sec_val" type="checkbox" value="5"  name="month_id[]" id="defaultCheck5">
                                                    <label class="form-check-label" for="defaultCheck5">
                                                        May
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input check_month month_sec_val" type="checkbox" value="6"  name="month_id[]" id="defaultCheck6">
                                                    <label class="form-check-label" for="defaultCheck6">
                                                        June
                                                    </label>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="form-check">
                                                    <input class="form-check-input check_month month_sec_val" type="checkbox" value="7"  name="month_id[]" id="defaultCheck7">
                                                    <label class="form-check-label" for="defaultCheck7">
                                                        July
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input check_month month_sec_val" type="checkbox" value="8"  name="month_id[]" id="defaultCheck8">
                                                    <label class="form-check-label" for="defaultCheck8">
                                                        August
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input check_month month_sec_val" type="checkbox" value="9"  name="month_id[]" id="defaultCheck9">
                                                    <label class="form-check-label" for="defaultCheck9">
                                                        September
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input check_month month_sec_val" type="checkbox" value="10"  name="month_id[]" id="defaultCheck10">
                                                    <label class="form-check-label" for="defaultCheck10">
                                                        October
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input check_month month_sec_val" type="checkbox" value="11"  name="month_id[]" id="defaultCheck11">
                                                    <label class="form-check-label" for="defaultCheck11">
                                                        November
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input check_month month_sec_val" type="checkbox" value="12"  name="month_id[]" id="defaultCheck12">
                                                    <label class="form-check-label" for="defaultCheck12">
                                                        December
                                                    </label>
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="years" class="form-label">Years</label>
                                        <select name="years[]" id="years" class="form-control single month_sec_val" multiple="multiple">
                                            @foreach (range(2022,5000) as $year)
                                                <option value="{{$year}}" {{ $year == date('Y') ? 'selected' : '' }}>{{$year}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fine_date" class="form-label">Fine Date</label>
                                        <select name="fine_date" id="fine_date" class="form-control month_sec_val" >
                                            @foreach (range(1,30) as $date)
                                                <option value="{{$date}}" {{ $date == 21 ? 'selected': ''}}>{{$date}}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                            </div>


                            @can('Fee Assign Add')
                            <div class="mb-3">
                                <button type="submit" class="btn btn-info"> <i class="fa fa-plus-cirlce"></i>Save</button>
                            </div>
                            @endcan

                                 @endif
                        {{-- </form> --}}
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            @if (count($members) > 0)
            <div class="row mt-5">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table class="table table-light table-hover table-striped table-sm table-bordered" id="feeheads">
                            <thead>
                                <tr>
                                    <th class="text-center" style="max-width: max-content"><input type="checkbox"  class="select_all" id="example-select-all"></th>
                                   <th>Name</th>
                                   <th>Member Id</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Assign Fees</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach ($members as $member)
                                    <tr>
                                        <td style="text-align:center">
                                        <input type="checkbox"  class="user_single_check" data-userid="{{$member->id}}">
                                        <input type="hidden" name="user_id[]" value="{{$member->id}}" class="hide_user_check_{{$member->id}}" disabled>

                                        </td>

                                         <td>{{$member->name}}</td>
                                         <td>{{optional($member->associatorsInfo)->membershp_number ?? ''}}</td>
                                    <td>{{$member->email}}</td>
                                    <td>{{$member->mobile}}</td>
                                        <td>
                                            @if(count($member->feeAssigns) > 0)
                                            <ul class="">
                                                @foreach ($member->feeAssigns->groupBy('fee_setup_id') as $fee_assign)
                                            {{-- {{dd($fee_assign)}} --}}
                                                <li class="">
                                                    {{ $fee_assign->first()->fee_setup != Null ? $fee_assign->first()->fee_setup->fee_head : '' }} -
                                                    {{-- ({{  implode(", ",$fee_assign->pluck('assign_date')->toArray() ) }}) --}}
                                                    @php
                                                        $data_string = '';
                                                    @endphp
                                                    @foreach ($fee_assign->pluck('assign_date')->toArray() as $assign_date)
                                                    @php
                                                        $data_string .= \Carbon\Carbon::parse($assign_date)->format('F j Y').", ";
                                                    @endphp
                                                    @endforeach
                                                    {{$data_string}}
                                                </li>
                                                @endforeach

                                              </ul>
                                              @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
                <div class="col-md-1"></div>
            </div>
            @endif
            </form>
        </div>
    </div>

@endsection
@push('script')
<script>

    $(function(){


        $(".month_sec_div").fadeOut();
        // $("#month_id").removeAttr('required');

        $(document).on('change','#fee_setup',function(){
            let fee_setup_id = $(this).val();

          $.ajax({
            type: "get",
            url: "/admin/get-fee-setup/"+fee_setup_id,

            success: function success(data) {
                if(data.monthly){
                    $('.month_sec_val').removeAttr('disabled');
                    $('.month_sec_div').fadeIn();

                    $('.fine_assign_date').fadeOut();
                    $('#fine_assign_date').attr('disabled','disabled');

                }else{
                    $('.month_sec_val').attr('disabled','disabled');
                    $('.month_sec_div').fadeOut();

                    $('.fine_assign_date').fadeIn();
                    $('#fine_assign_date').removeAttr('disabled');

                }
                // console.log(data);
            }
            });
        })

        $(document).on('change','#select_all_month', function(e){
            if ($(this).prop("checked") == true) {
                $(".check_month").each(function () {
                    let self = $(this);
                    self.prop("checked", true);
                });
            } else if ($(this).prop("checked") == false) {
                $(".check_month").each(function () {
                    let self = $(this);
                    self.prop("checked", false);
                });
            }
        })



    })
</script>
@endpush

