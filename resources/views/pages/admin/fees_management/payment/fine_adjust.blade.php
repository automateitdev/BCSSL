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

            {{-- <div class="row">
                <form action="{{ route('admin.fine.adjust') }}" method="GET">
                    <select name="assign_date" id="" class="form-control"
                        style="max-width: 400px; display:inline-table">
                        @foreach ($assignDates as $date)
                            <option value="{{ $date->assign_date }}">
                                {{ \Carbon\Carbon::parse($date->assign_date)->format('Y-m-d') }}
                                ({{ \Carbon\Carbon::parse($date->assign_date)->format('F') }})
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="d-inline btn btn-primary">Search</button>
                </form>
            </div> --}}
            <div class="row">
                <div class="col-sm-12 col-md-12 mt-5">
                    <form action="{{ route('admin.fine.adjustment.update') }}" method="POST">
                        @csrf
                        <table class="table display table-light table-hover table-striped table-sm table-bordered w-100"
                            id="myTable">
                            <thead>
                                <tr>
                                    {{-- <th class="text-center" style="max-width: max-content">
                                        <input type="checkbox" class="select_all_payment" id="example-select-all">
                                    </th> --}}
                                    <th width="25%">Name</th>
                                    <th width="25%">Membership No.</th>
                                    <th>Fine Amount</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($collection as $key => $item)
                                    <tr>
                                        {{-- <td style="text-align:center">
                                            <input type="checkbox" class="payment_single_check"
                                                data-id="{{ $item->id }}">
                                            <input type="hidden" name="payment[{{ $key }}][payment_id]"
                                                value="{{ $item->id }}" class="payment_value_one_{{ $item->id }}"
                                                disabled>
                                        </td> --}}
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item?->associatorsInfo?->membershp_number }}</td>
                                        <td>{{ $item->total_fine ?? 0 }}</td>
                                        <td>
                                            <a href="{{ route('admin.fine.adjust.view', ['member' => $item->id]) }}"
                                                class="btn btn-sm btn-primary">Show more</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Button trigger modal -->
                        {{-- <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal" PP>
                            Adjust Fine
                        </button> --}}

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Update Fine Amount</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Fine Amount</label>
                                            <input type="number" class="form-control" id="fine_amount"
                                                name="fine_adjustment" placeholder="Enter Fine Amount" min="0"
                                                required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
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
            let table = $('#myTable').DataTable({
                scrollX: true,
            });
        </script>
    @endpush
@endsection
