<div class="container mt-4">
    <h2>Manage Leave Types</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" wire:model="name" id="name" class="form-control">
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" wire:model="description" id="description" class="form-control">
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" wire:model="is_paid" id="is_paid" class="form-check-input">
                            <label for="is_paid" class="form-check-label">Paid Leave</label>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" wire:model="requires_approval" id="requires_approval" class="form-check-input">
                            <label for="requires_approval" class="form-check-label">Requires Approval</label>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ $editMode ? 'Update' : 'Create' }} Leave Type
                    </button>
                    @if($editMode)
                        <button type="button" wire:click="resetForm" class="btn btn-secondary ms-2">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Paid</th>
                    <th>Requires Approval</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaveTypes as $type)
                    <tr>
                        <td>{{ $type->name }}</td>
                        <td>{{ $type->description }}</td>
                        <td>{{ $type->is_paid ? 'Yes' : 'No' }}</td>
                        <td>{{ $type->requires_approval ? 'Yes' : 'No' }}</td>
                        <td>
                            <button wire:click="edit({{ $type->id }})" class="btn btn-sm btn-warning">Edit</button>
                            <button wire:click="delete({{ $type->id }})" class="btn btn-sm btn-danger ms-1" onclick="return confirm('Are you sure?')">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No leave types found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>