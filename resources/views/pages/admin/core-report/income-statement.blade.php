@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))
@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <div class="card p-3 col-md-7 mx-auto my-2 mb-5">
                    <form action="{{ route('admin.core-report.income-statement.search') }}" method="post"
                        enctype="multipart/form-data">
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
                                <button type="submit" class="btn btn-primary btn-sm mt-2 float-right" id="opsinfo_search">
                                    <i class="fa-solid fa-magnifying-glass"></i> Search</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-md-12 mx-auto">
                @if (isset($incomeledgerinfo) && isset($expenseledgerinfo))
                    @php
                        $incomeArr = [];
                        $expenseArr = [];
                    @endphp
                    <button id="generate-pdf" class="btn btn-primary btn-sm my-2"><i class="fa fa-file-pdf"
                            aria-hidden="true"></i> Download PDF</button>
                    <table id="incomeState" class="display caption-top table table-sm table-light table-bordered">
                        <caption class="font-weight-bold incomeStatement"
                            style="padding:15px; text-align:center;
                        caption-side: top; background-color:cadetblue; color:white">
                            Income
                            Statement from {{ $from }} to {{ $to }}</caption>
                        <thead>
                            <tr class="customBg">
                                <th style="text-align:left">Ledger Name</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td style="text-align: center; font-weight:bold" colspan="2">Income List</td>
                            </tr>
                            @forelse ($incomeledgerinfo as $income)
                                <tr>
                                    <td>{{ $income->ledger_name }}</td>
                                    @php
                                        array_push($incomeArr, $income->ledger_traces_sum_credit);
                                    @endphp
                                    <td style="text-align: right">{{ $income->ledger_traces_sum_credit }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">
                                        <div class="alert alert-info">No Income List Found !!</div>
                                    </td>
                                </tr>
                            @endforelse

                            @if (array_sum($incomeArr) != 0)
                                <tr>
                                    <td style="text-align: right;background-color: cadetblue; color:white"> <b>Total
                                            Income</b></td>
                                    <td style="text-align: right;background-color: cadetblue; color:white"><b
                                            style="">{{ array_sum($incomeArr) }}</b>
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td style="text-align: center; font-weight:bold" colspan="2">Expense List</td>
                            </tr>
                            @forelse ($expenseledgerinfo as $expense)
                                <tr>
                                    <td>{{ $expense->ledger_name }}</td>
                                    @php
                                        array_push($expenseArr, $expense->ledger_traces_sum_debit);
                                    @endphp
                                    <td style="color:red; text-align: right">{{ $expense->ledger_traces_sum_debit }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">
                                        <div class="alert alert-info">No Expense List Found !!</div>
                                    </td>
                                </tr>
                            @endforelse
                            @if (array_sum($expenseArr) != 0)
                                <tr class="customBg">
                                    <td style="text-align: right;">
                                        <b>Total Expense</b>
                                    </td>
                                    <td style="text-align: right"><b>{{ array_sum($expenseArr) }}</b></td>
                                </tr>
                            @endif

                        </tbody>
                        <tfoot>
                            <tr class="customBg">
                                <th style="text-align:left"> Profit/Loss between [{{ $from }} -
                                    {{ $to }}]</th>
                                <th>{{ array_sum($incomeArr) - array_sum($expenseArr) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                @endif
            </div>
        </div>
    </div>
@push('script')
    <script>
        $(function() {
            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;
                return [year, month, day].join('-');
            }


            $('#generate-pdf').click(function(e) {
                e.preventDefault();
                let from_date = {!! isset($from) ? json_encode($from) : '' !!};
                let to_date = {!! isset($to) ? json_encode($to) : '' !!};
                let path = 'pages.admin.core-report.income-statement-report'
                // console.log(Token);
                $.ajax({
                    url: '/admin/income_statement_pdf',
                    type: 'POST',
                    headers: {
                        "Authorization": "Bearer {{ $apiToken ?? '' }}"
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    data: {
                        'from': formatDate(from_date),
                        'to': formatDate(to_date),
                        'pdfname': 'income_statement',
                        'path': path,
                    },

                    success: function(data) {
                        $('#mainloader').addClass('d-none');
                        var blob = new Blob([data], {
                            type: 'contentType'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'income_statement.pdf';
                        link.click();
                    },
                    error: function(e) {
                        console.log(e);
                        $('#mainloader').addClass('d-none');
                        alert("Something went wrong! Please try later.");
                    }
                });

            });
        });
    </script>
@endpush
@endsection
