@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))
@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <div class="card p-3 col-md-7 mx-auto my-2 mb-5">
                    <form>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="form-label">From</label>
                                <input type="date" class="form-control" name="from" id="startDate">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">To</label>
                                <input type="date" class="form-control" name="to" id="endDate">
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-primary btn-sm mt-2 float-right"
                                    id="voucherwise_search">
                                    <i class="fa-solid fa-magnifying-glass"></i> Search</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card p-3 my-2 table-responsive">
                <table class="table table-sm table-bordered table-hover" id="voucherReportList">
                    <thead>
                        <tr>
                            <th scope="col">#SL.</th>
                            <th scope="col">Voucher</th>
                            <th scope="col">Invoice</th>
                            <th scope="col">Type</th>
                            <th scope="col">Reference</th>
                            <th scope="col">Date</th>
                            <th scope="col">Description</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
            let table = $('#voucherReportList').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.voucherwise.report.list') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrf_token
                    },
                    data: function(d) {
                        // Add additional parameters to the data sent to the server
                        d.date_from = $('#startDate').val(); // Replace with the actual ID or selector of your date_from input
                        d.date_to = $('#endDate').val(); // Replace with the actual ID or selector of your date_to input
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'voucher_id',
                        name: 'voucher_id'
                    },
                    {
                        data: 'invoice_no',
                        name: 'invoice_no'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'reference',
                        name: 'reference'
                    },
                    {
                        data: 'voucher_date',
                        name: 'voucher_date'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'view',
                        name: 'view'
                    }
                ]
            });

            // Event handler for the button click
            $('#voucherwise_search').on('click', function (e) {
                e.preventDefault();
                // Update the DataTable with new date range parameters and reload the table
                table.ajax.reload();
            });
        </script>
    @endpush

@endsection
