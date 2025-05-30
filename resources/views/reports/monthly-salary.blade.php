<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Monthly Salary Report - {{ $date }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
        }

        .report-title {
            font-size: 16px;
            margin: 10px 0;
        }

        .report-date {
            font-size: 14px;
        }

        .company-info {
            font-size: 12px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .totals-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .page-break {
            page-break-after: always;
        }

        .deduction-details {
            font-size: 11px;
            color: #666;
        }

        .leave-details {
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-name">{{ $company['name'] }}</div>
        <div class="report-title">Monthly Salary Report</div>
        <div class="report-date">{{ $date }}</div>
        <div class="company-info">
            {{ $company['address'] }} | {{ $company['contact'] }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th class="text-right">Base Salary</th>
                <th class="text-right">Bonus</th>
                <th class="text-right">Total Deductions</th>
                <th class="text-right">Net Salary</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $item)
                <tr>
                    <td>{{ $item['employee']->biometric_id }}</td>
                    <td>{{ $item['employee']->name }}</td>
                    <td class="text-right">PKR {{ number_format($item['base_salary'], 2) }}</td>
                    <td class="text-right">PKR {{ number_format($item['bonus'], 2) }}</td>
                    <td class="text-right">
                        PKR {{ number_format($item['deduction'], 2) }}
                        @if ($item['leave_deduction'] > 0 || $item['other_deduction'] > 0)
                            <div class="deduction-details">
                                @if ($item['leave_deduction'] > 0)
                                    <span class="leave-details">(Leave: PKR
                                        {{ number_format($item['leave_deduction'], 2) }} for
                                        {{ $item['excess_leaves'] }} days)</span>
                                @endif
                                @if ($item['other_deduction'] > 0)
                                    <span>, Other: PKR {{ number_format($item['other_deduction'], 2) }}</span>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td class="text-right">PKR {{ number_format($item['net_salary'], 2) }}</td>
                </tr>
            @endforeach
            <tr class="totals-row">
                <td colspan="2">TOTAL</td>
                <td class="text-right">PKR {{ number_format($totals['base_salary'], 2) }}</td>
                <td class="text-right">PKR {{ number_format($totals['bonus'], 2) }}</td>
                <td class="text-right">
                    PKR {{ number_format($totals['deduction'], 2) }}
                    <div class="deduction-details">
                        @if ($totals['leave_deduction'] > 0)
                            <span class="leave-details">(Leave: PKR {{ number_format($totals['leave_deduction'], 2) }}
                                for {{ $totals['excess_leaves'] }} days)</span>
                        @endif
                        @if ($totals['other_deduction'] > 0)
                            <span>, Other: PKR {{ number_format($totals['other_deduction'], 2) }}</span>
                        @endif
                    </div>
                </td>
                <td class="text-right">PKR {{ number_format($totals['net_salary'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 12px; text-align: right;">
        <p>Generated on: {{ now()->setTimezone('Asia/Karachi')->format('Y-m-d H:i:s') }} (GMT+5)</p>
    </div>
</body>

</html>
