<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold">Leave Types Management</h2>
        <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#leaveTypeForm">
            <i class="bi bi-plus-lg me-2"></i>Add Leave Type
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
        <div class="card-body collapse {{ $editMode ? 'show' : '' }}" id="leaveTypeForm">
            <h5 class="card-title">{{ $editMode ? 'Edit' : 'Add New' }} Leave Type</h5>
            <form wire:submit.prevent="save">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-medium">Name <span
                                class="text-danger">*</span></label>
                        <input type="text" wire:model="name" id="name" class="form-control"
                            placeholder="Enter leave type name">
                        @error('name')
                            <div class="text-danger small mt-1"><i
                                    class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="description" class="form-label fw-medium">Description</label>
                        <input type="text" wire:model="description" id="description" class="form-control"
                            placeholder="Enter description">
                    </div>

                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input type="checkbox" wire:model="is_paid" id="is_paid" class="form-check-input"
                                role="switch">
                            <label for="is_paid" class="form-check-label fw-medium">Paid Leave</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input type="checkbox" wire:model="requires_approval" id="requires_approval"
                                class="form-check-input" role="switch">
                            <label for="requires_approval" class="form-check-label fw-medium">Requires Approval</label>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i>{{ $editMode ? 'Update' : 'Create' }} Leave Type
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
                            <th class="ps-4">Name</th>
                            <th>Description</th>
                            <th>Paid</th>
                            <th>Requires Approval</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaveTypes as $type)
                            <tr>
                                <td class="ps-4 fw-medium">{{ $type->name }}</td>
                                <td>{{ $type->description ?: '-' }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $type->is_paid ? 'success' : 'secondary' }}-subtle text-{{ $type->is_paid ? 'success' : 'secondary' }}">
                                        {{ $type->is_paid ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $type->requires_approval ? 'warning' : 'secondary' }}-subtle text-{{ $type->requires_approval ? 'warning' : 'secondary' }}">
                                        {{ $type->requires_approval ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button wire:click="edit({{ $type->id }})"
                                        class="btn btn-sm btn-outline-primary me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button wire:click="delete({{ $type->id }})"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this leave type?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox me-2"></i>No leave types found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
