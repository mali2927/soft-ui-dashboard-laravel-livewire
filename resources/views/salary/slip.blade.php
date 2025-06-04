<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Salary Slip - {{ $employee->name }}</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/DejaVuSans.ttf') }}) format('truetype');
        }

        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
        }

        .document-title {
            font-size: 18px;
            margin: 10px 0;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .details-table th,
        .details-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .details-table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
        }

        .signature {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-name">AQ Bakers & Sweets</div>
        <div class="document-title">Salary Slip for {{ $date }}</div>
    </div>

    <table class="details-table">
        <tr>
            <th colspan="2">Employee Information</th>
        </tr>
        <tr>
            <td width="50%"><strong>Employee Name:</strong> {{ $employee->name }}</td>
            <td width="50%"><strong>Employee ID:</strong> {{ $employee->biometric_id ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Designation:</strong> {{ $employee->position }}</td>
            <td><strong>Department:</strong> {{ $employee->department }}</td>
        </tr>
    </table>

    <table class="details-table">
        <tr>
            <th>Earnings</th>
            <th class="text-right">Amount</th>
        </tr>
        <tr>
            <td>Basic Salary</td>
            <td class="text-right">{{ number_format($baseSalary, 2) }}</td>
        </tr>
        @foreach ($adjustments->where('amount', '>', 0) as $adjustment)
            <tr>
                <td>{{ $adjustment->type }} ({{ $adjustment->effective_date->format('M Y') }})</td>
                <td class="text-right">+ {{ number_format($adjustment->amount, 2) }}</td>
            </tr>
        @endforeach
    </table>

    <table class="details-table">
        <tr>
            <th>Deductions</th>
            <th class="text-right">Amount</th>
        </tr>
        @if ($leaveDeductions > 0)
            <tr>
                <td>Leave Deductions ({{ $excessLeaves }} days)</td>
                <td class="text-right">- {{ number_format($leaveDeductions, 2) }}</td>
            </tr>
        @endif
        @foreach ($adjustments->where('amount', '<', 0) as $adjustment)
            <tr>
                <td>{{ $adjustment->type }} ({{ $adjustment->effective_date->format('M Y') }})</td>
                <td class="text-right">- {{ number_format(abs($adjustment->amount), 2) }}</td>
            </tr>
        @endforeach
    </table>

    <table class="details-table">
        <tr class="total-row">
            <td><strong>Net Salary</strong></td>
            <td class="text-right">{{ number_format($currentSalary, 2) }}</td>
        </tr>
    </table>

    <div class="signature">
        <table width="100%">
            <tr>
                <td width="50%" class="text-center">
                    <hr>
                    <p>Employee Signature</p>
                </td>
                <td width="50%" class="text-center">
                    <hr>
                    <p>Authorized Signature</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>This is computer generated document and does not require signature.</p>
        <p>Generated on: {{ now()->setTimezone('Asia/Karachi')->format('Y-m-d H:i:s') }} (GMT+5)</p>
    </div>
</body>

</html>
