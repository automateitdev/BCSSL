@props(['assetAccReceiveBy','member'])

<div>
    {{-- <form action="#" method="POST" enctype="multipart/form-data" id="paymentCreateForm"> --}}
    <form action="{{route('admin.fees.payment.create')}}" method="POST" enctype="multipart/form-data" id="paymentCreateForm">
        @csrf
        <input type="hidden" name="member_id" value="{{$member->id}}">
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="{{$member->avatar_url}}" alt="{{$member->name}}"  class="img-fluid" style="  width: 91% !important;margin-top: 11px;height: 280px;">
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
                                <label for="receiveBt">Payment Type</label>
                                <select id="payment_type" name="payment_type" class="form-control">
                                    <option selected value="">Choose One</option>
                                    {{-- <option value="manual">Manual</option> --}}
                                    <option value="online">Online</option>

                                </select>
                            </div>
                            <div class="form-group fee_setup m_common" style="display: none;">
                            <label for="receiveBt">Payment To</label>
                            <select name="ladger_id" id="fee_setup" class="form-control i_common" required disabled>
                                <option selected>Choose One</option>
                                @foreach($assetAccReceiveBy as $receive_by)
                                    @if(count($receive_by->ledgers) > 0)
                                        @foreach($receive_by->ledgers as $ledger)
                                        <option value="{{$ledger->id}}">{{$ledger->ledger_name}} </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                            </div>
                            <div class="form-group document_files m_common" style="display: none;">
                                <label for="document_files">Document</label>
                                <input type="file" class="form-control-file i_common" name="document_files[]" id="document_files" multiple="multiple" required disabled>
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
                            <button type="submit" class="btn btn-primary submit_btn m_common proceed_btn" data-type='manual' style="display: none;" >Submit</button>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary pay_btn m_common" data-toggle="modal" data-target="#payNowModal" style="display: none;">
                                Pay Now
                            </button>

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
                    <table class="table table-light table-hover table-striped table-sm table-bordered" id="feeheads">
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
                            @foreach ($member->feeAssigns as $assign)
                                <tr>
                                    <td style="text-align:center">
                                    {{-- <input type="checkbox"  class="user_single_check" data-userid="{{$assign->id}}" data-totalamount="{{$assign->fee_setup->amount + ($assign->fee_setup->fine_amount ?? 0)}}">
                                    <input type="hidden" name="fee_assign_id[]" value="{{$assign->id}}" class="hide_user_check_{{$assign->id}}" disabled> --}}

                                    @if(now_is_grater_old_date($assign->assign_date))
                                    <input type="checkbox"  class="single_check_sum" data-userid="{{$assign->id}}" data-totalamount="{{$assign->amount + ($assign->fine_amount ?? 0)}}" {{ now_is_grater_old_date($assign->assign_date) ? 'checked' : '' }} onclick="return false;">
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
                                    {{-- <td>{{ $assign->fee_setup->fine_amount ?? 0 }}</td> --}}
                                    <td>{{ $assign->fine_amount ?? 0 }}</td>
                                    <td>{{ $assign->fee_setup->amount + ($assign->fee_setup->fine_amount ?? 0) }}</td>

                                <td> <span class="badge {{ $assign->status == \App\Models\FeeAssign::STATUS_DUE ? 'badge-warning' : 'badge-success'}} ">{{ ucwords($assign->status) }}</span></td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>

    </form>

        </div>
        <div class="col-md-1"></div>
    </div>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="payNowModal" tabindex="-1" aria-labelledby="payNowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title text-danger" id="payNowModalLabel"> Read Before Proceeding</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body ">
                <div class="card border-danger mb-3" >

                    <div class="card-body text-danger">
                      <ul>
                        <li>
                            <b>Payment can not be initiated for 5 minutes after each attempt.</b>
                        </li>
                        <li>
                            <b> Check balance: </b>Please check balance after payment, if amount is deducted, do not try again.
                        </li>
                        <li>
                            <b> Amount is not deducted: </b>If amount is not deducted wait for 15 minutes and recheck the balance.
                        </li>
                        <li>
                            <b> Balance deducted but payment report not found: </b>In such case, please, do not try to pay again.
                        </li>
                      </ul>
                    </div>
                  </div>


            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success proceed_btn" data-type='manual' >Proceed</button>
            </div>
        </div>
        </div>
    </div>
</div>

@push('script')

<script>
    $(document).ready(function(){
        $(document).on('click','.proceed_btn',function(e){
            e.preventDefault();
            // let type = $(this).data('type')
            // let url = "{{route('admin.fees.payment.create')}}"
            $("#paymentCreateForm").submit()

        })
    });
    </script>

@endpush
