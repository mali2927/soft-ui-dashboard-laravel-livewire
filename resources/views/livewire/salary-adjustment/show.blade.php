<div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Salary Adjustment Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Employee</th>
                                        <td>{{ $adjustment->employee->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td>
                                            <span
                                                class="badge-dark badge-{{ $adjustment->type === 'increase' || $adjustment->type === 'bonus' ? 'success' : 'danger' }}">
                                                {{ ucfirst($adjustment->type) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Amount</th>
                                        <td>{{ number_format($adjustment->amount, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Effective Date</th>
                                        <td>{{ $adjustment->effective_date->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created By</th>
                                        <td>{{ $adjustment->creator->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $adjustment->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Reason</h5>
                                    </div>
                                    <div class="card-body">
                                        {{ $adjustment->reason }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('salary-adjustments.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
