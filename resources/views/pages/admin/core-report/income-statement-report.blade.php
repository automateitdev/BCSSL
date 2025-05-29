@php
    ini_set('memory_limit', '1024M');
    $incomeArr = [];
    $expenseArr = [];
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Income Statement</title>
    <style>
        @page {
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            display: inline-table;
            margin: 0px auto;
            margin-bottom: 15px;
        }

        * {
            font-family: DejaVu Serif;
            font-size: .8rem;
        }

        .customBg{
          font-size: .95rem;
        }

        table tr th {
            border: 1px solid black;
            background-color: lightgray;
            padding: 12px auto;
        }

        table tr td {
            border: 1px solid black;
            color: black;
            padding: 5px;
        }

        .pagebreak {
            page-break-inside: avoid;
        }

        @font-face {
            font-family: "DejaVu Serif";
            font-style: normal;
            font-weight: normal;
            src: asset('fonts/DejaVuSans.ttf') format('truetype');
        }
    </style>
</head>

<body>
    <div style="position: relative; width:100%">
        <h2 style="text-align: center">Cadre Officers' Co-operative Society Limited</h2>
        <h3 style="text-align: center">Income Statement [{{ $from }}, {{ $to }}]</h3>
        <table cellspacing="3" width="95%">
            <thead>
                <tr class="customBg">
                    <th>Income Ledgers</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($incomeledgerinfo as $income)
                    <tr>

                        <td>{{ $income['ledger_name'] }}</td>
                        @php
                            array_push($incomeArr, $income['ledger_traces_sum_credit']);
                        @endphp
                        <td style="text-align:right">{{ $income['ledger_traces_sum_credit'] }}</td>

                    </tr>
                @endforeach

                @if (array_sum($incomeArr) != 0)
                    <tr class="customBg">
                        <td style="text-align: right"> <b>Total Income</b></td>
                        <td style="text-align:right"><b>{{ array_sum($incomeArr) }}</b></td>
                    </tr>
                @endif
            </tbody>
        </table>

        <table cellspacing="3" width="95%">
            <thead>
                <tr>
                    <th>Expense Ledgers</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenseledgerinfo as $expense)
                    <tr>

                        <td>{{ $expense['ledger_name'] }}</td>
                        @php
                            array_push($expenseArr, $expense['ledger_traces_sum_debit']);
                        @endphp
                        <td style="text-align:right">{{ $expense['ledger_traces_sum_debit'] }}</td>

                    </tr>
                @endforeach
                @if (array_sum($expenseArr) != 0)
                    <tr class="customBg">
                        <td style="text-align: right;">
                            <b>Total Expense</b>
                        </td>
                        <td style="text-align:right"><b>{{ array_sum($expenseArr) }}</b></td>
                    </tr>
                @endif
            </tbody>
        </table>


        @php
            $result = array_sum($incomeArr) - array_sum($expenseArr);
            if ($result > 0) {
                $profit = true;
            } else {
                $profit = false;
            }
        @endphp

        <table cellspacing="3" width="95%">
            <thead>
                <tr class="customBg">
                    <th>Statement Result of [{{ $from }}, {{ $to }}]</th>
                    <th>{{ $profit ? 'Profit' : 'Loss' }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; font-weight:bold">
                        {{ $profit ? 'Income Over Expenditure' : 'Expenditure Over Income' }}</td>
                    <td style="text-align: center; font-weight:bold">{{ $result }}</td>
                </tr>
            </tbody>
        </table>
        <div style="position:absolute; left:0; bottom:0; font-size:.6rem">Powered By: Automate IT.</div>
    </div>
</body>

</html>
