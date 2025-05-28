<div class="salary-details">
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2"><strong>Base Salary:</strong></p>
                            <p class="mb-2"><strong>Daily Rate:</strong></p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-2">{{ number_format($baseSalary, 2) }}</p>
                            <p class="mb-2">{{ number_format($dailyRate, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Leave Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2"><strong>Allowed Leaves:</strong></p>
                            <p class="mb-2"><strong>Used Leaves:</strong></p>
                            <p class="mb-2"><strong>Excess Leaves:</strong></p>
                            <p class="mb-0"><strong>Deductions:</strong></p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-2">{{ $allowedLeaves }}</p>
                            <p class="mb-2">{{ $usedLeaves }}</p>
                            <p class="mb-2 text-danger">{{ $excessLeaves }}</p>
                            <p class="mb-0 text-danger">-{{ number_format($leaveDeductions, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Current Salary Calculation</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="mb-2"><strong>Base Salary:</strong></p>
                    <p class="mb-2"><strong>Adjustments:</strong></p>
                    <p class="mb-2"><strong>Leave Deductions:</strong></p>
                    <p class="mb-0"><strong>Current Salary:</strong></p>
                </div>
                <div class="col-md-8 text-end">
                    <p class="mb-2">+ {{ number_format($baseSalary, 2) }}</p>
                    <p class="mb-2">+ {{ number_format($adjustments->sum('amount'), 2) }}</p>
                    <p class="mb-2">- {{ number_format($leaveDeductions, 2) }}</p>
                    <p class="mb-0 h4 text-primary">{{ number_format($currentSalary, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    @if ($adjustments->count() > 0)
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Salary Adjustments</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Effective Date</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adjustments as $adjustment)
                                <tr>
                                    <td>{{ $adjustment->type }}</td>
                                    <td class="{{ $adjustment->amount >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $adjustment->amount >= 0 ? '+' : '' }}{{ number_format($adjustment->amount, 2) }}
                                    </td>
                                    <td>{{ $adjustment->effective_date->format('M d, Y') }}</td>
                                    <td>{{ $adjustment->reason }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
