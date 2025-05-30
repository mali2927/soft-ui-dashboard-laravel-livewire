<div>
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Salary Adjustments</h2>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('salary-adjustments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Adjustment
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" wire:model="search" class="form-control"
                            placeholder="Search adjustments...">
                    </div>
                    <div class="col-md-3">
                        <select wire:model="perPage" class="form-control">
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Effective Date</th>
                                <th>Reason</th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($adjustments as $adjustment)
                                <tr>
                                    <td>{{ $adjustment->employee->name }}</td>
                                    <td>
                                        <span
                                            class="badge-dark badge-{{ $adjustment->type === 'increase' || $adjustment->type === 'bonus' ? 'success' : 'danger' }}">
                                            {{ ucfirst($adjustment->type) }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($adjustment->amount, 2) }}</td>
                                    <td>{{ $adjustment->effective_date->format('M d, Y') }}</td>
                                    <td>{{ Str::limit($adjustment->reason, 30) }}</td>
                                    <td>{{ $adjustment->creator->name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('salary-adjustments.show', $adjustment) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('salary-adjustments.edit', $adjustment) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('salary-adjustments.delete', $adjustment) }}"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No salary adjustments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $adjustments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
