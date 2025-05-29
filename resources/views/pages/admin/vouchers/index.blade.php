@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))
@section('content')
    <div id="bcs">
        <div class="container">
            <div class="card p-3 my-2">
                <form action="{{route('admin.approval.voucher.update')}}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped table-hover" id="voucherRequestTable">
                            <thead>
                                <tr>
                                    <th class="text-center" style="max-width: max-content">
                                        <input type="checkbox" class="select_all_payment" id="example-select-all">
                                    </th>
                                    <th style="width:min-content">SL No.</th>
                                    <th>Voucher ID</th>
                                    <th>Voucher Type</th>
                                    <th>Voucher Date</th>
                                    <th>Ledger From</th>
                                    <th>Ledger To</th>
                                    <th>Amount</th>
                                    <th>Reference</th>
                                    <th>Description</th>
                                    <th>Decision</th>
                                </tr>
                            </thead>

                            <tbody></tbody>

                            {{-- <tbody>
                            @foreach ($vouchers as $key => $item)
                                <tr>
                                    <td style="text-align:center">
                                        <input type="checkbox" class="payment_single_check" data-id="{{ $item->id }}">
                                        <input type="hidden" name="voucher[{{ $key }}][id]"
                                            value="{{ $item->id }}" class="payment_value_one_{{ $item->id }}" disabled>

                                    </td>
                                    <td>{{ $item->voucher_id }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->ledger_from->ledger_name }}</td>
                                    <td>{{ $item->ledger_to->ledger_name }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>

                                        @if ($item->state == 'approved')
                                            <span class="badge text-bg-success">Approved</span>
                                        @elseif ($item->state == 'approved')
                                            <span class="badge text-bg-danger">Declined</span>
                                        @else
                                            <select name="state" id="state">
                                                <option value="pending" {{ $item->state == 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="approved" {{ $item->state == 'approved' ? 'selected' : '' }}>
                                                    Approved
                                                </option>
                                                <option value="declined" {{ $item->state == 'declined' ? 'selected' : '' }}>
                                                    Declined
                                                </option>
                                            </select>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody> --}}
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success mb-3"><i class="fa fa-check-circle"> </i>
                                Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    @endpush
    @push('script')
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <script>
        let csrf_token = $('meta[name="csrf-token"]').attr('content');
            let table = $('#voucherRequestTable').DataTable({
                scrollX:true,
                processing: true,
                serverSide: true,
                ajax: {
                url: "{{ route('admin.vouchers.list') }}",
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                }
                },
                columnDefs: [{
                    orderable: false,
                    targets: [0,1]
                }],
                order: [[2, 'asc']],
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'voucher_id',
                        name: 'voucher_id'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'ledger_from.ledger_name',
                        name: 'ledger_from.ledger_name'
                    },
                    {
                        data: 'ledger_to.ledger_name',
                        name: 'ledger_to.ledger_name'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'reference',
                        name: 'reference'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'state',
                        name: 'state',
                    },
                ]
            });
        </script>
        <script>
            $(document).ready(function() {
                $(document).on('change', '.status_change', function(e) {
                    e.preventDefault();
                    let user_id = $(this).data('userid');
                    $(`#status_form_${user_id}`).submit();
                    // console.log(user_id);
                })
                // console.log('chck');
            });
        </script>
    @endpush

@endsection
