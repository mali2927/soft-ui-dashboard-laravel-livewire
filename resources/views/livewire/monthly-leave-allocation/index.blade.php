<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Monthly Leave Allocations</h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('leave-allocations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Allocation
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Search employees...">
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Month/Year</th>
                            <th>Allocated</th>
                            <th>Used</th>
                            <th>Carry Over</th>
                            <th>Processed</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allocations as $allocation)
                            <tr>
                                <td>{{ $allocation->employee->name }}</td>
                                <td>{{ $allocation->month_year->format('M Y') }}</td>
                                <td>{{ $allocation->allocated_leaves }}</td>
                                <td>{{ $allocation->used_leaves }}</td>
                                <td>{{ number_format($allocation->carry_over_amount, 2) }}</td>
                                <td>
                                    @if ($allocation->is_processed)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-warning">No</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('leave-allocations.edit', $allocation) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <livewire:monthly-leave-allocation.delete :allocation="$allocation" :key="$allocation->id"/>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No leave allocations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $allocations->links() }}
            </div>
        </div>
    </div>
</div>