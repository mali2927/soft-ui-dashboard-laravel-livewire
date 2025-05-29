<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Salary Slips - {{ $company['name'] }}</title>
    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
        }

        .header {
            border-bottom: 2px solid #3b7ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .company-logo {
            height: 60px;
        }

        .slip-container {
            margin-bottom: 30px;
            page-break-after: always;
        }

        .employee-header {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background-color: #3b7ddd;
            color: white;
        }

        .table th,
        .table td {
            padding: 10px;
            border: 1px solid #dee2e6;
        }

        .text-primary {
            color: #3b7ddd;
        }

        .text-right {
            text-align: right;
        }

        .signature-area {
            margin-top: 50px;
        }

        .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    @foreach ($employees as $employee)
        <div class="slip-container">
            <div class="header d-flex justify-content-between">
                <div>
                    <h3 class="text-primary">{{ $company['name'] }}</h3>
                    <p>{{ $company['address'] }}<br>{{ $company['contact'] }}</p>
                </div>
                <div class="text-right">
                    <h4>SALARY SLIP</h4>
                    <p>For: {{ $date }}</p>
                </div>
            </div>

            <div class="employee-header mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Employee ID:</strong> {{ $employee->biometric_id }}</p>
                        <p><strong>Name:</strong> {{ $employee->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Department:</strong> {{ $employee->department }}</p>

                    </div>
                </div>
            </div>

            <table class="table mb-4">
                <thead>
                    <tr>
                        <th>Earnings</th>
                        <th class="text-right">Amount (PKR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Basic Salary</td>
                        <td class="text-right">{{ number_format($employee->base_salary, 2) }}</td>
                    </tr>
                    @foreach ($employee->salaryAdjustments as $adjustment)
                        <tr>
                            <td>{{ $adjustment->description }} ({{ ucfirst($adjustment->type) }})</td>
                            <td class="text-right">{{ number_format($adjustment->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table mb-4">
                <thead>
                    <tr>
                        <th>Deductions</th>
                        <th class="text-right">Amount (PKR)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $dailyRate = $employee->base_salary / 30;
                        $allowedLeaves = $employee->leaveBalances->first()->allocated ?? 4;
                        $usedLeaves = $employee->leaveBalances->first()->used ?? 0;
                        $excessLeaves = max(0, $usedLeaves - $allowedLeaves);
                        $leaveDeductions = $excessLeaves * $dailyRate;
                    @endphp
                    @if ($leaveDeductions > 0)
                        <tr>
                            <td>Leave Deductions ({{ $excessLeaves }} days)</td>
                            <td class="text-right">-{{ number_format($leaveDeductions, 2) }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="text-right mb-4">
                <h4>Net Salary: PKR
                    {{ number_format($employee->base_salary + $employee->salaryAdjustments->sum('amount') - $leaveDeductions, 2) }}
                </h4>
            </div>

            <div class="signature-area">
                <div class="row">
                    <div class="col-md-6">
                        <p>Employee Signature: ________________</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <p>Authorized Signature: ________________</p>
                        <p>Date: ________________</p>
                    </div>
                </div>
            </div>

            <div class="footer">
                <p>This is computer generated document and does not require signature.</p>
            </div>
        </div>
    @endforeach
</body>

</html>
