<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0 text-center">Employee Management</h2>
        </div>

        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <a href="{{ route('employee.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add Employee
                </a>

                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" wire:model.lazy="search" placeholder="Search employees..."
                            class="form-control" wire:loading.attr="disabled">
                    </div>
                    <div wire:loading wire:target="search" class="text-muted small mt-1">
                        <i class="bi bi-hourglass-split me-1"></i> Searching...
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center align-middle">Name</th>
                            <th class="text-center align-middle">CNIC</th>
                            <th class="text-center align-middle">Department</th>
                            <th class="text-center align-middle">Designation</th>
                            <th class="text-center align-middle">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $emp)
                            <tr>
                                <td class="text-center align-middle">{{ $emp->name }}</td>
                                <td class="text-center align-middle">{{ $emp->cnic }}</td>
                                <td class="text-center align-middle">{{ $emp->department }}</td>
                                <td class="text-center align-middle">{{ $emp->designation }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('employee.edit', $emp->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button wire:click="delete({{ $emp->id }})"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-people display-6 d-block mb-2"></i>
                                    No employees found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</div>
