<x-layouts.member-master>
    <div class="container">
        {{-- <div class="row">
            <div class="col">
                <h2 class="mb-25">
                    <a href="#">{{get_page_meta('title', true) }}</a>
                    <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                </h2>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="pills-information-tab" data-toggle="pill" href="#pills-information" role="tab" aria-controls="pills-information" aria-selected="true">Information</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-payment-tab" data-toggle="pill" href="#pills-payment" role="tab" aria-controls="pills-payment" aria-selected="false">Payment</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-report-tab" data-toggle="pill" href="#pills-report" role="tab" aria-controls="pills-report" aria-selected="false">Report</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-information" role="tabpanel" aria-labelledby="pills-information-tab">
                                @if(!is_null($member->memberProfileUpdate)&& $member->memberProfileUpdate->status == \App\Models\MemberProfileUpdate::STATUS_PENDING)
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                   <h5> Your profile is <strong>pending</strong> for approval</h5>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  @endif
                               <member-infos  :member="{{ json_encode($member) }}" :user-gender="{{$user_gender}}" />
                            </div>
                            <div class="tab-pane fade" id="pills-payment" role="tabpanel" aria-labelledby="pills-payment-tab">
                               <x-member.payment :asset-acc-receive-by="$assetAccReceiveBy" :member="$member" >

                               </x-member.payment>
                                {{-- E:\laragon\www\BCS\resources\views\pages\member\dashboard\partials\payment.blade.php --}}
                            </div>
                            <div class="tab-pane fade" id="pills-report" role="tabpanel" aria-labelledby="pills-report-tab">

                                <div class="card">
                                    <div class="card-header text-center">
                                        <h1>Report</h1>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-light table-hover table-striped table-sm table-bordered" id="myTable">
                                            <thead>
                                                <tr>
                                                    {{-- <th class="text-center" style="max-width: max-content"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th> --}}
                                                    <th class="text-center" style="max-width: max-content">
                                                        <input type="checkbox"  class="select_all_payment" id="example-select-all">
                                                    </th>
                                                    <th>Member</th>
                                                    <th>Ledger</th>

                                                    <th>Date</th>
                                                    {{-- <th>Month</th> --}}
                                                    <th>Payment Date</th>
                                                    <th>Documents</th>
                                                    <th>Fine</th>
                                                    <th>Payable</th>
                                                    <th>Total</th>
                                                    <th>Reasons</th>
                                                    <th>Status</th>
                                                    <th>Payment Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($member->paymentInfos->sortDesc()  as $key => $paymentInfo)
                                                    <tr>
                                                        <td style="text-align:center">
                                                            <input type="checkbox"  class="payment_single_check" data-id="{{$paymentInfo->id}}">
                                                                <input type="hidden" name="payment[{{$key}}][payment_id]" value="{{$paymentInfo->id}}" class="payment_value_one_{{$paymentInfo->id}}" disabled>

                                                        </td>
                                                        <td>
                                                            {{optional($paymentInfo->member)->name}}

                                                        </td>
                                                        <td>{{optional($paymentInfo->ledger)->ledger_name}}</td>

                                                        {{-- <td>
                                                            {{\Carbon\Carbon::parse($paymentInfo->payment_date)->format('Y')}}
                                                        </td> --}}
                                                        <td>
                                                            {{\Carbon\Carbon::parse($paymentInfo->payment_date)->format('Y')}}
                                                            <br> {{\Carbon\Carbon::parse($paymentInfo->payment_date)->format('F')}}
                                                        </td>
                                                        <td>{{$paymentInfo->payment_date}}</td>

                                                    <td>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$paymentInfo->id}}">
                                                            view ({{ !is_null($paymentInfo->document_files) ? count(explode(',',$paymentInfo->document_files)) : 0  }})
                                                        </button>
                                                    </td>
                                                    <td>{{$paymentInfo->fine_amount}}</td>
                                                    <td>{{$paymentInfo->payable_amount}}</td>
                                                    <td>{{$paymentInfo->total_amount}}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm reason_btn" id="reason_btn{{$paymentInfo->id}}" data-toggle="modal" style="display: {{$paymentInfo->status == \App\Models\PaymentInfo::STATUS_SUSPEND ? 'block' : 'none'}};"  data-target="#reasonsExampleModal{{$paymentInfo->id}}">
                                                            Reasons
                                                          </button>
                                                          <input type="hidden" name="payment[{{$key}}][reasons]" value="{{$paymentInfo->reasons}}" class="reason_tarea{{$paymentInfo->id}}"  {{ $paymentInfo->status !== \App\Models\PaymentInfo::STATUS_SUSPEND ? 'disabled' : ''}}>

                                                          <!-- Modal -->
                                                          <div class="modal fade" id="reasonsExampleModal{{$paymentInfo->id}}" tabindex="-1" aria-labelledby="reasonsExampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                              <div class="modal-content">
                                                                <div class="modal-header">
                                                                  <h5 class="modal-title" id="reasonsExampleModalLabel">Invoice No: {{ $paymentInfo->invoice_no }}</h5>
                                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                  </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="exampleFormControlTextarea1">Reasons</label>
                                                                        <textarea class="form-control reason_tarea" data-id="{{$paymentInfo->id}}" id="exampleFormControlTextarea1" rows="3">{{$paymentInfo->reasons}}</textarea>
                                                                      </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>

                                                    </td>
                                                    <td>
                                                        {{ ucwords($paymentInfo->status) }}
                                                    </td>
                                                    <td>
                                                        {{ ucwords($paymentInfo->payment_type) }}
                                                    </td>
                                                    <td>
                                                        @if(strtolower($paymentInfo->status) == strtolower(\App\Models\PaymentInfo::STATUS_COMPLETE))
                                                        <a href="{{ route('member.payment.invoice',['id'=>$paymentInfo->id]) }}?type=member" class="btn btn-sm btn-success">Get Receipt</a>
                                                        @endif
                                                    </td>

                                                    </tr>
                                                    <!-- Modal -->
                                                    @if(!is_null($paymentInfo->document_files))
                                                    <div class="modal  fade" id="exampleModal{{$paymentInfo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Invoice No: {{ $paymentInfo->invoice_no }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        @php
                                                                            $files = explode(',', $paymentInfo->document_files);
                                                                        @endphp
                                                                        <div class="image_main">
                                                                            @foreach($files as $file)
                                                                                <div class="image_main_inner">
                                                                                    @if(get_file_extention($file) != 'pdf')
                                                                                    <img src="{{ get_file_extention($file) != 'pdf' ? get_storage_image(\App\Models\PaymentInfo::DOCUMENT_FILES_VIEW, $file) : get_pdf_image() }}" alt="" class="img-fluid" height="140">
                                                                                    @else
                                                                                    <img src="{{  get_pdf_image() }}" href="{{ get_storage_image(\App\Models\PaymentInfo::DOCUMENT_FILES_VIEW, $file)}}" class="img-fluid" height="140">
                                                                                    @endif

                                                                                </div>
                                                                            @endforeach
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        .image_main{
            display: flex;
        justify-content: flex-start;
        gap: 6px;
        flex-direction: row;
        /* flex-wrap: wrap; */
        height: auto;
        width: 100%;

        }
        .image_main_inner{
            width: 100%;

        }
        .image_main img{
            height: 150px;
        width: 150px;
        }
    </style>
    @endpush
    @push('script')
    <script src="https://kit.fontawesome.com/91f9de4938.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script src="{{ asset('plugins/Image-PDF-Viewer-EZView/EZView.js') }}"></script>
    <script src="{{ asset('plugins/Image-PDF-Viewer-EZView/draggable.js') }}"></script>

    <script>
        let table = new DataTable('#myTable');
    </script>
    <script>
        $(document).ready(function(){
            $(document).on('change','.status_change', function(e){
                e.preventDefault();
                let user_id = $(this).data('userid');
                $(`#status_form_${user_id}`).submit();
                // console.log(user_id);
            })
            // console.log('chck');

            $('img').EZView();

        });
    </script>
    @endpush
</x-layouts.member-master>




