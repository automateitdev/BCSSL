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

            @if (count($members) > 0)
            <div class="row mt-5">
                <div class="col-md-1"></div>
                <div class="col-md-10">

                    <table class="table table-light table-hover table-striped table-sm table-bordered" id="feeheads">
                        <thead>
                            <tr>
                                <th class="text-center">
                                No
                                </th>
                               <th>Name</th>
                               <th>Member Id</th>
                                <th>Email</th>
                                <th>Fee Assign</th>
                                <th>Total Assign Fee</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($members as $member)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>

                                     <td>{{$member->name}}</td>
                                     <td>{{optional($member->associatorsInfo)->membershp_number ?? ''}}</td>
                                <td>{{$member->email}}</td>
                                <td>{{optional($member->feeAssigns)->count() ?? 0}}</td>
                                <td>
                                    {{ count($member->feeAssigns) > 0 ? $member->feeAssigns->sum('amount') + $member->feeAssigns->sum('fine_amount')." BDT"  : 0 }}
                                </td>
                                <td>
                                    <a href="{{route('admin.fees.quick.collection',['id'=>$member->id])}}" class="btn btn-success">Process</a>
                                </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="col-md-1"></div>
            </div>
            @endif

        </div>
    </div>

@endsection

@push('script')
<script>

    $(function(){
        if($("#feeheads").length > 0){

        $('#feeheads').DataTable();
        }


        $(".month_id").fadeOut();
        $("#month_id").removeAttr('required');

        $(document).on('change','#fee_setup',function(){
            let fee_setup_id = $(this).val();

          $.ajax({
            type: "get",
            url: "/admin/get-fee-setup/"+fee_setup_id,

            success: function success(data) {
                if(data.monthly){
                    $(".month_id").fadeIn();
                    $("#month_id").removeAttr('disabled').attr('required','required');
                }else{
                    $(".month_id").fadeOut();
                        $("#month_id").attr('disabled','disabled').removeAttr('required')
                }
                // console.log(data);
            }
            });
        })



    })
</script>
@endpush
