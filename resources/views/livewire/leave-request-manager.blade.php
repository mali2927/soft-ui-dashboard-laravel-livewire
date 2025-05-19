<div class="container mt-4">
    <h2>Manage Leave Requests</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
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
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" wire:model="start_date" id="start_date" class="form-control">
                        @error('start_date') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" wire:model="end_date" id="end_date" class="form-control">
                        @error('end_date') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="col-12">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea wire:model="reason" id="reason" rows="3" class="form-control"></textarea>
                        @error('reason') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    @if($editMode)
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select wire:model="status" id="status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label for="comments" class="form-label">Comments</label>
                            <textarea wire:model="comments" id="comments" rows="3" class="form-control"></textarea>
                        </div>
                    @endif
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ $editMode ? 'Update' : 'Create' }} Leave Request
                    </button>
                    
                    @if($editMode)
                        <button type="button" wire:click="updateStatus('approved')" class="btn btn-success ms-2">
                            Approve
                        </button>
                        <button type="button" wire:click="updateStatus('rejected')" class="btn btn-danger ms-2">
                            Reject
                        </button>
                        <button type="button" wire:click="resetForm" class="btn btn-secondary ms-2">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="mb-4">
        <label for="statusFilter" class="form-label">Filter by Status</label>
        <select wire:model="statusFilter" id="statusFilter" class="form-select w-auto">
            <option value="all">All Requests</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Dates</th>
                    <th>Days</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaveRequests as $request)
                    <tr>
                        <td>{{ $request->employee->name }}</td>
                        <td>{{ $request->leaveType->name }}</td>
                        <td>
                            {{ $request->start_date->format('M d, Y') }} - {{ $request->end_date->format('M d, Y') }}
                        </td>
                        <td>{{ $request->days }}</td>
                        <td>
                            <span class="badge 
                                {{ $request->status === 'approved' ? 'bg-success' : 
                                   ($request->status === 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                        <td>
                            <button wire:click="edit({{ $request->id }})" class="btn btn-sm btn-primary">View/Edit</button>
                            <button wire:click="delete({{ $request->id }})" class="btn btn-sm btn-danger ms-1" onclick="return confirm('Are you sure?')">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No leave requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>