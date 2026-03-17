<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Expenio Report - {{ $monthName }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1a1814;
            font-size: 12px;
            line-height: 1.5;
        }

        .header {
            background: #0f0e0c;
            color: #f0ead8;
            padding: 24px 32px;
            margin-bottom: 24px;
        }

        .header h1 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .header p {
            font-size: 11px;
            color: #8c8070;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .summary-table td {
            padding: 12px 16px;
            text-align: center;
            border: 1px solid #e3ddd4;
        }

        .summary-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #8c8070;
            display: block;
            margin-bottom: 4px;
        }

        .summary-value {
            font-size: 18px;
            font-weight: 600;
        }

        .green {
            color: #3d6b4f;
        }

        .red {
            color: #b83a24;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a1814;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 2px solid #e3ddd4;
        }

        .expense-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .expense-table th {
            background: #f6f3ee;
            padding: 8px 12px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #8c8070;
            border-bottom: 2px solid #e3ddd4;
        }

        .expense-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e3ddd4;
            font-size: 11px;
        }

        .expense-table tr:nth-child(even) {
            background: #faf8f5;
        }

        .date-row {
            background: #f6f3ee !important;
        }

        .date-row td {
            font-weight: 600;
            font-size: 11px;
            color: #1a1814;
            padding: 6px 12px;
            border-bottom: 2px solid #e3ddd4;
        }

        .type-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 500;
        }

        .type-online {
            background: #e8eef8;
            color: #5078c8;
        }

        .type-offline {
            background: #f5f0e2;
            color: #b8892a;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1px solid #e3ddd4;
            text-align: center;
            font-size: 10px;
            color: #8c8070;
        }

        .breakdown {
            margin-bottom: 24px;
        }

        .breakdown-row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            font-size: 11px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h1>Expenio</h1>
        <p>Expense Report &mdash; {{ $monthName }} &mdash; {{ $user->name }}</p>
    </div>

    <!-- Summary -->
    <table class="summary-table">
        <tr>
            <td>
                <span class="summary-label">Total Expenses</span>
                <span class="summary-value red">Rs. {{ number_format($totalExpense, 2) }}</span>
            </td>
            <td>
                <span class="summary-label">Total Income</span>
                <span class="summary-value green">Rs. {{ number_format($totalIncome, 2) }}</span>
            </td>
            <td>
                <span class="summary-label">Net Savings</span>
                <span class="summary-value {{ $totalIncome - $totalExpense >= 0 ? 'green' : 'red' }}">Rs.
                    {{ number_format(abs($totalIncome - $totalExpense), 2) }}</span>
            </td>
            <td>
                <span class="summary-label">Transactions</span>
                <span class="summary-value">{{ $expenses->count() }}</span>
            </td>
        </tr>
    </table>

    <!-- Online vs Offline -->
    <table class="summary-table" style="margin-bottom:24px;">
        <tr>
            <td>
                <span class="summary-label">Online Expenses</span>
                <span class="summary-value" style="font-size:14px; color:#5078c8;">Rs.
                    {{ number_format($onlineTotal, 2) }}</span>
            </td>
            <td>
                <span class="summary-label">Offline Expenses</span>
                <span class="summary-value" style="font-size:14px; color:#b8892a;">Rs.
                    {{ number_format($offlineTotal, 2) }}</span>
            </td>
        </tr>
    </table>

    <!-- Expense Details -->
    <div class="section-title">Expense Details</div>

    @if ($expenses->count() > 0)
        <table class="expense-table">
            <thead>
                <tr>
                    <th style="width:10%;">#</th>
                    <th style="width:30%;">Product</th>
                    <th style="width:15%;">Type</th>
                    <th style="width:20%;">Date</th>
                    <th style="width:25%;" class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $serial = 1;
                    $lastDate = null;
                @endphp
                @foreach ($expenses as $expense)
                    @php $currentDate = $expense->date->toDateString(); @endphp
                    @if ($currentDate !== $lastDate)
                        <tr class="date-row">
                            <td colspan="5">{{ $expense->date->format('l, j F Y') }}
                                @php
                                    $dayTotal = $grouped[$currentDate]->sum('price');
                                @endphp
                                <span style="float:right; color:#b83a24;">Rs. {{ number_format($dayTotal, 2) }}</span>
                            </td>
                        </tr>
                        @php $lastDate = $currentDate; @endphp
                    @endif
                    <tr>
                        <td>{{ $serial++ }}</td>
                        <td>{{ $expense->product_name }}</td>
                        <td>
                            <span
                                class="type-badge {{ $expense->type === 'online' ? 'type-online' : 'type-offline' }}">
                                {{ ucfirst($expense->type) }}
                            </span>
                        </td>
                        <td>{{ $expense->date->format('d M Y') }}</td>
                        <td class="text-right" style="font-weight:500;">Rs. {{ number_format($expense->price, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align:center; color:#8c8070; padding:24px 0;">No expenses recorded for {{ $monthName }}.</p>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Generated by Expenio on {{ now()->format('d M Y, h:i A') }} by Subhadeep Maity</p>
        <p style="margin-top:4px;">{{ $user->name }} &middot; {{ $user->email }}</p>
    </div>

</body>

</html>
