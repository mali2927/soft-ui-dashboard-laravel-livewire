<div class="container-fluid py-4">

    <style>
        .form-floating label {
            padding-left: 2.5rem;
        }

        .form-control,
        .form-select {
            padding-left: 3rem;
        }

        .form-floating>.bi,
        .form-control~.bi {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
        }

        .form-select {
            background-image: none;
            padding-left: 1rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.05);
        }

        .badge {
            font-weight: 500;
        }
    </style>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0 fw-bold text-primary">
            <i class="bi bi-calendar2-event me-2"></i>Manage Leave Requests
        </h2>

        <div class="d-flex align-items-center">
            <label for="statusFilter" class="form-label mb-0 me-2 fw-semibold">Filter:</label>
            <select wire:model="statusFilter" id="statusFilter" class="form-select form-select-sm w-auto">
                <option value="all">All Requests</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Leave Request Form -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-plus-circle me-2"></i>
                {{ $editMode ? 'Edit Leave Request' : 'Create New Leave Request' }}
            </h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row g-3">
                    <!-- Employee Selection -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select wire:model="employee_id" id="employee_id"
                                class="form-select @error('employee_id') is-invalid @enderror">
                                <option value="">Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                            <label for="employee_id"><i class="bi bi-person-badge me-2"></i>Employee</label>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Leave Type Selection -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select wire:model="leave_type_id" id="leave_type_id"
                                class="form-select @error('leave_type_id') is-invalid @enderror">
                                <option value="">Select Leave Type</option>
                                @foreach ($leaveTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <label for="leave_type_id"><i class="bi bi-tag me-2"></i>Leave Type</label>
                            @error('leave_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" wire:model="start_date" id="start_date"
                                class="form-control @error('start_date') is-invalid @enderror">
                            <label for="start_date"><i class="bi bi-calendar3 me-2"></i>Start Date</label>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" wire:model="end_date" id="end_date"
                                class="form-control @error('end_date') is-invalid @enderror">
                            <label for="end_date"><i class="bi bi-calendar3 me-2"></i>End Date</label>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Reason -->
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea wire:model="reason" id="reason" rows="3" class="form-control @error('reason') is-invalid @enderror"
                                style="height: 100px"></textarea>
                            <label for="reason"><i class="bi bi-chat-left-text me-2"></i>Reason</label>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if ($editMode)
                        <!-- Status and Comments (Edit Mode Only) -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select wire:model="status" id="status" class="form-select">
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                <label for="status"><i class="bi bi-check-circle me-2"></i>Status</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea wire:model="comments" id="comments" rows="3" class="form-control" style="height: 100px"></textarea>
                                <label for="comments"><i class="bi bi-chat-square-text me-2"></i>Comments</label>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    @if ($editMode)
                        <button type="button" wire:click="resetForm" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <button type="button" wire:click="updateStatus('approved')" class="btn btn-success me-2">
                            <i class="bi bi-check-circle me-2"></i>Approve
                        </button>
                        <button type="button" wire:click="updateStatus('rejected')" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle me-2"></i>Reject
                        </button>
                    @endif
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.class="d-none">
                            <i class="bi bi-save me-2"></i>{{ $editMode ? 'Update' : 'Create' }}
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Processing...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Leave Requests Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Employee</th>
                            <th>Leave Type</th>
                            <th>Dates</th>
                            <th>Days</th>
                            <th>Status</th>
                            <th class="pe-4 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaveRequests as $request)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $request->employee->name }}</td>
                                <td>{{ $request->leaveType->name }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $request->start_date->format('M d') }} -
                                        {{ $request->end_date->format('M d, Y') }}
                                    </span>
                                </td>
                                <td class="fw-semibold">{{ $request->days }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill py-2 px-3 
        {{ $request->status === 'approved'
            ? 'bg-success bg-opacity-10 text-success-emphasis'
            : ($request->status === 'rejected'
                ? 'bg-danger bg-opacity-10 text-danger-emphasis'
                : 'bg-warning bg-opacity-10 text-warning-emphasis') }}">
                                        <i
                                            class="bi 
            {{ $request->status === 'approved'
                ? 'bi-check-circle'
                : ($request->status === 'rejected'
                    ? 'bi-x-circle'
                    : 'bi-hourglass') }} me-1"></i>
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group" role="group">
                                        <button wire:click="edit({{ $request->id }})"
                                            class="btn btn-sm btn-outline-primary rounded-start-pill"
                                            data-bs-toggle="tooltip" title="View/Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button wire:click="delete({{ $request->id }})"
                                            class="btn btn-sm btn-outline-danger rounded-end-pill"
                                            onclick="return confirm('Are you sure you want to delete this leave request?')"
                                            data-bs-toggle="tooltip" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-calendar-x me-2"></i>No leave requests found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





<script>
    document.addEventListener('livewire:load', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
