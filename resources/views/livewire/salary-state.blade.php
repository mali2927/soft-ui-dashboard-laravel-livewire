<div class="salary-details">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Salary Details for {{ $employee->name }}</h4>
        <button class="btn btn-primary" wire:click="downloadSalarySlip">
            <i class="fas fa-file-pdf me-2"></i>Download Salary Slip
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                    <span class="badge bg-light text-dark">Monthly</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2"><strong><i class="fas fa-money-bill-wave me-2"></i>Base Salary:</strong>
                            </p>
                            <p class="mb-2"><strong><i class="fas fa-calendar-day me-2"></i>Daily Rate:</strong></p>
                            <p class="mb-0"><strong><i class="fas fa-clock me-2"></i>Pay Period:</strong></p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-2">{{ number_format($baseSalary, 2) }}</p>
                            <p class="mb-2">{{ number_format($dailyRate, 2) }}</p>
                            <p class="mb-0">{{ now()->format('F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-umbrella-beach me-2"></i>Leave Information</h5>
                    <span class="badge bg-light text-dark">YTD</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2"><strong><i class="fas fa-check-circle me-2"></i>Allowed Leaves:</strong>
                            </p>
                            <p class="mb-2"><strong><i class="fas fa-calendar-check me-2"></i>Used Leaves:</strong>
                            </p>
                            <p class="mb-2"><strong><i class="fas fa-exclamation-circle me-2"></i>Excess
                                    Leaves:</strong></p>
                            <p class="mb-0"><strong><i class="fas fa-minus-circle me-2"></i>Deductions:</strong></p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-2">{{ $allowedLeaves }} days</p>
                            <p class="mb-2">{{ $usedLeaves }} days</p>
                            <p class="mb-2 text-danger">{{ $excessLeaves }} days</p>
                            <p class="mb-0 text-danger">-{{ number_format($leaveDeductions, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Current Salary Calculation</h5>
            <span class="badge bg-light text-dark">{{ now()->format('M d, Y') }}</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="mb-2"><strong><i class="fas fa-money-bill-wave me-2"></i>Base Salary:</strong></p>
                    <p class="mb-2"><strong><i class="fas fa-adjust me-2"></i>Adjustments:</strong></p>
                    <p class="mb-2"><strong><i class="fas fa-minus-circle me-2"></i>Leave Deductions:</strong></p>
                    <hr>
                    <p class="mb-0"><strong><i class="fas fa-file-invoice-dollar me-2"></i>Current Salary:</strong>
                    </p>
                </div>
                <div class="col-md-8 text-end">
                    <p class="mb-2">+ {{ number_format($baseSalary, 2) }}</p>
                    <p class="mb-2">+ {{ number_format($adjustments->sum('amount'), 2) }}</p>
                    <p class="mb-2">- {{ number_format($leaveDeductions, 2) }}</p>
                    <hr>
                    <p class="mb-0 h4 text-primary">{{ number_format($currentSalary, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    @if ($adjustments->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-sliders-h me-2"></i>Salary Adjustments</h5>
                <span class="badge bg-light text-dark">{{ $adjustments->count() }} records</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-tag me-2"></i>Type</th>
                                <th><i class="fas fa-dollar-sign me-2"></i>Amount</th>
                                <th><i class="fas fa-calendar-alt me-2"></i>Effective Date</th>
                                <th><i class="fas fa-comment me-2"></i>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adjustments as $adjustment)
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ $adjustment->amount >= 0 ? 'success' : 'danger' }}">
                                            {{ $adjustment->type }}
                                        </span>
                                    </td>
                                    <td class="{{ $adjustment->amount >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $adjustment->amount >= 0 ? '+' : '' }}{{ number_format($adjustment->amount, 2) }}
                                    </td>
                                    <td>{{ $adjustment->effective_date->format('M d, Y') }}</td>
                                    <td>{{ $adjustment->reason }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-light">
                                <td colspan="3" class="text-end"><strong>Total Adjustments:</strong></td>
                                <td
                                    class="text-end {{ $adjustments->sum('amount') >= 0 ? 'text-success' : 'text-danger' }}">
                                    <strong>{{ number_format($adjustments->sum('amount'), 2) }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
