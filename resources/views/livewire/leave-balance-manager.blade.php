<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold">Leave Balances Management</h2>
        <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#balanceForm">
            <i class="bi bi-plus-lg me-2"></i>Add Balance
        </button>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body collapse {{ $editMode ? 'show' : '' }}" id="balanceForm">
            <h5 class="card-title">{{ $editMode ? 'Edit' : 'Add New' }} Leave Balance</h5>
            <form wire:submit.prevent="save">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="employee_id" class="form-label fw-medium">Employee <span
                                class="text-danger">*</span></label>
                        <select wire:model="employee_id" id="employee_id" class="form-select">
                            <option value="">Select Employee</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="text-danger small mt-1"><i
                                    class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="leave_type_id" class="form-label fw-medium">Leave Type <span
                                class="text-danger">*</span></label>
                        <select wire:model="leave_type_id" id="leave_type_id" class="form-select">
                            <option value="">Select Leave Type</option>
                            @foreach ($leaveTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('leave_type_id')
                            <div class="text-danger small mt-1"><i
                                    class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="allocated" class="form-label fw-medium">Days Allocated <span
                                class="text-danger">*</span></label>
                        <input type="number" wire:model="allocated" id="allocated" class="form-control"
                            placeholder="Enter days">
                        @error('allocated')
                            <div class="text-danger small mt-1"><i
                                    class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="year" class="form-label fw-medium">Year <span
                                class="text-danger">*</span></label>
                        <input type="number" wire:model="year" id="year" class="form-control" placeholder="YYYY"
                            min="2000" max="2100">
                        @error('year')
                            <div class="text-danger small mt-1"><i
                                    class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-medium">Status</label>
                        <div class="form-control bg-light">
                            @if ($editMode)
                                <span class="badge bg-info">{{ $balance->remaining ?? 'N/A' }} days remaining</span>
                            @else
                                <span class="text-muted">Will be calculated</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i>{{ $editMode ? 'Update' : 'Create' }} Balance
                    </button>
                    @if ($editMode)
                        <button type="button" wire:click="resetForm" class="btn btn-outline-secondary ms-3 px-4">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Employee</th>
                            <th>Leave Type</th>
                            <th>Year</th>
                            <th class="text-end">Allocated</th>
                            <th class="text-end">Used</th>
                            <th class="text-end pe-4">Remaining</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($balances as $balance)
                            <tr>
                                <td class="ps-4 fw-medium">{{ $balance->employee->name }}</td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        {{ $balance->leaveType->name ?? 'N/A' }}

                                    </span>
                                </td>
                                <td>{{ $balance->year }}</td>
                                <td class="text-end">{{ $balance->allocated }}</td>
                                <td class="text-end">{{ $balance->used }}</td>
                                <td class="text-end pe-4">
                                    <span
                                        class="badge bg-{{ $balance->remaining > 0 ? 'success' : 'danger' }}-subtle text-{{ $balance->remaining > 0 ? 'success' : 'danger' }}">
                                        {{ $balance->remaining }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button wire:click="edit({{ $balance->id }})"
                                        class="btn btn-sm btn-outline-primary me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button wire:click="delete({{ $balance->id }})"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this leave balance?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox me-2"></i>No leave balances found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
