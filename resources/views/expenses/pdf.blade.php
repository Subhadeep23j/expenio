<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Monthly Expenses - {{ $monthLabel }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1a1814;
            font-size: 12px;
            line-height: 1.5;
        }

        .header {
            background: #0f0e0c;
            color: #f0ead8;
            padding: 22px 28px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 22px;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 11px;
            color: #c8bfae;
        }

        .summary {
            border: 1px solid #e3ddd4;
            margin-bottom: 20px;
        }

        .summary td {
            padding: 10px 14px;
            border-right: 1px solid #e3ddd4;
            text-align: center;
        }

        .summary td:last-child {
            border-right: none;
        }

        .label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #8c8070;
            display: block;
        }

        .value {
            font-size: 18px;
            font-weight: 700;
            margin-top: 3px;
        }

        .section-title {
            font-size: 14px;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #e3ddd4;
        }

        .expense-table {
            width: 100%;
            border-collapse: collapse;
        }

        .expense-table th {
            background: #f6f3ee;
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
            color: #8c8070;
            text-transform: uppercase;
            letter-spacing: .06em;
            border-bottom: 2px solid #e3ddd4;
        }

        .expense-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ece6dc;
            font-size: 11px;
        }

        .expense-table tr:nth-child(even) {
            background: #faf8f5;
        }

        .date-row {
            background: #f2eee8 !important;
        }

        .date-row td {
            font-weight: 700;
            color: #1a1814;
            border-bottom: 2px solid #e3ddd4;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
        }

        .online {
            background: #e8eef8;
            color: #5078c8;
        }

        .offline {
            background: #f5f0e2;
            color: #b8892a;
        }

        .footer {
            margin-top: 24px;
            border-top: 1px solid #e3ddd4;
            padding-top: 12px;
            text-align: center;
            font-size: 10px;
            color: #8c8070;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Expenio</h1>
        <p>Monthly Expense Report — {{ $monthLabel }}</p>
    </div>

    <table class="summary" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <span class="label">Month</span>
                <span class="value">{{ $monthLabel }}</span>
            </td>
            <td>
                <span class="label">Transactions</span>
                <span class="value">{{ $expenses->count() }}</span>
            </td>
            <td>
                <span class="label">Total Expense</span>
                <span class="value">₹{{ number_format($monthTotal, 2) }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">Expense Details</div>

    @if ($expenses->count() > 0)
        <table class="expense-table">
            <thead>
                <tr>
                    <th style="width: 10%;">#</th>
                    <th style="width: 40%;">Product</th>
                    <th style="width: 20%;">Type</th>
                    <th style="width: 30%;" class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @foreach ($groupedExpenses as $date => $dayExpenses)
                    <tr class="date-row">
                        <td colspan="4">{{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}</td>
                    </tr>
                    @foreach ($dayExpenses as $expense)
                        <tr>
                            <td>{{ $index++ }}</td>
                            <td>{{ $expense->product_name }}</td>
                            <td>
                                <span
                                    class="badge {{ $expense->type === 'online' ? 'online' : 'offline' }}">{{ ucfirst($expense->type) }}</span>
                            </td>
                            <td class="text-right">₹{{ number_format($expense->price, 2) }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @else
        <p style="font-size: 12px; color: #8c8070;">No expenses recorded for this month.</p>
    @endif

    <div class="footer">
        Generated on {{ now()->format('d M Y, h:i A') }}
    </div>
</body>

</html>
