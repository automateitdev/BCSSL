@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))

@section('content')
    <div id="fine_adjustment">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="mb-25">
                        <a href="{{ route('admin.fine.adjust') }}">{{ get_page_meta('title', true) }}</a>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 mt-5">
                    <form action="{{ route('admin.fine.adjustment.update') }}" method="POST">
                        @csrf
                        <table class="table display table-light table-hover table-striped table-sm table-bordered"
                            id="fineAdjustTable">
                            <thead>
                                <tr>
                                    <th class="text-center" style="max-width: max-content">
                                        <input type="checkbox" class="select_all_payment" id="example-select-all">
                                    </th>
                                    <th width="25%">Name</th>
                                    <th width="25%">Membership No.</th>
                                    <th>Assign Date</th>
                                    <th>Fine Date</th>
                                    <th>Fine amount</th>
                                    <th>Payment Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($member->feeAssigns as $key => $item)
                                    {{-- @foreach ($item->paymentInfoItem as $payItem) --}}
                                    {{-- @if ($item->paymentInfoItem)
                                        @if($item->paymentInfoItem->paymentInfo->status == 'suspend')
                                            @continue
                                        @endif
                                    @endif --}}
                                    <tr>
                                        <td style="text-align:center">
                                            <input type="checkbox" class="payment_single_check"
                                                data-id="{{ $item->id }}">
                                            <input type="hidden" name="payment[{{ $key }}][fee_assign_id]"
                                                value="{{ $item->id }}" class="payment_value_one_{{ $item->id }}"
                                                disabled>
                                        </td>
                                        <td style="width: 25%">{{ $member->name }}</td>
                                        <td>{{ $member->associatorsInfo->membershp_number }}</td>
                                        <td style="width: 15%">
                                            {{ \Carbon\Carbon::parse($item->assign_date)->format('Y-m-d') }}
                                            ({{ \Carbon\Carbon::parse($item->assign_date)->format('F') }})
                                        </td>
                                        <td style="width: 15%">{{ $item->fine_date }}</td>
                                        <td><input type="number" name="fine_adjustment[{{ $key }}]"
                                                value="{{ $item->fine_amount ?? 0 }}"
                                                class="payment_value_one_{{ $item->id }}" disabled></td>
                                        <td>{{ $item->paymentInfoItem ? $item->paymentInfoItem->paymentInfo->invoice_no : 'No Invoice' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="button" class="btn btn-dark" data-toggle="modal"
                            data-target=".bd-example-modal-sm">Apply Changes</button>

                        <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm py-2">
                                <div class="modal-content">
                                    <p class="fw-bold p-1 text-danger m-0">Confirm the fine adjustments?</p>
                                    <div class="p-2">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <style>
            input {
                position: relative;
            }

            input:before {
                position: absolute;
                top: 3px;
                left: 3px;
                content: attr(data-date);
                display: inline-block;
                color: black;
            }

            input::-webkit-datetime-edit,
            input::-webkit-inner-spin-button,
            input::-webkit-clear-button {
                display: none;
            }

            input::-webkit-calendar-picker-indicator {
                position: absolute;
                top: 3px;
                right: 0;
                color: black;
                opacity: 1;
            }

            .image_main {
                display: flex;
                justify-content: flex-start;
                gap: 6px;
                flex-direction: row;
                height: auto;
                width: 100%;
            }

            .image_main_inner {
                width: 100%;
            }

            .image_main img {
                height: 150px;
                width: 150px;
            }
        </style>
    @endpush

    @push('script')
        <script src="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

        <script src="{{ asset('plugins/Image-PDF-Viewer-EZView/EZView.js') }}"></script>
        <script src="{{ asset('plugins/Image-PDF-Viewer-EZView/draggable.js') }}"></script>

        <script>
            let table = $('#fineAdjustTable').DataTable({
                scrollX: true,
            });
        </script>
    @endpush
@endsection
