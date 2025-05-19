<div class="container mt-4">
    <h2>Manage Leave Balances</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select wire:model="employee_id" id="employee_id" class="form-select">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                        @error('employee_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="leave_type_id" class="form-label">Leave Type</label>
                        <select wire:model="leave_type_id" id="leave_type_id" class="form-select">
                            <option value="">Select Leave Type</option>
                            @foreach($leaveTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('leave_type_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="allocated" class="form-label">Days Allocated</label>
                        <input type="number" wire:model="allocated" id="allocated" class="form-control">
                        @error('allocated') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" wire:model="year" id="year" class="form-control">
                        @error('year') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ $editMode ? 'Update' : 'Create' }} Balance
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
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Year</th>
                    <th>Allocated</th>
                    <th>Used</th>
                    <th>Remaining</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($balances as $balance)
                    <tr>
                        <td>{{ $balance->employee->name }}</td>
                        <td>{{ $balance->leaveType->name }}</td>
                        <td>{{ $balance->year }}</td>
                        <td>{{ $balance->allocated }}</td>
                        <td>{{ $balance->used }}</td>
                        <td>{{ $balance->remaining }}</td>
                        <td>
                            <button wire:click="edit({{ $balance->id }})" class="btn btn-sm btn-warning">Edit</button>
                            <button wire:click="delete({{ $balance->id }})" class="btn btn-sm btn-danger ms-1" onclick="return confirm('Are you sure?')">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No leave balances found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>