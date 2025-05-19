<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Monthly Leave Allocation</h3>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="update">
                        <div class="form-group">
                            <label for="employee_id">Employee</label>
                            <select wire:model="employee_id" id="employee_id" class="form-control @error('employee_id') is-invalid @enderror">
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $employee->id == $employee_id ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="month_year">Month/Year</label>
                            <input wire:model="month_year" type="month" id="month_year" class="form-control @error('month_year') is-invalid @enderror">
                            @error('month_year') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="allocated_leaves">Allocated Leaves</label>
                            <input wire:model="allocated_leaves" type="number" step="0.5" id="allocated_leaves" class="form-control @error('allocated_leaves') is-invalid @enderror">
                            @error('allocated_leaves') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="used_leaves">Used Leaves</label>
                            <input wire:model="used_leaves" type="number" step="0.5" id="used_leaves" class="form-control @error('used_leaves') is-invalid @enderror">
                            @error('used_leaves') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="carry_over_amount">Carry Over Amount</label>
                            <input wire:model="carry_over_amount" type="number" step="0.01" id="carry_over_amount" class="form-control @error('carry_over_amount') is-invalid @enderror">
                            @error('carry_over_amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group form-check">
                            <input wire:model="is_processed" type="checkbox" id="is_processed" class="form-check-input">
                            <label class="form-check-label" for="is_processed">Is Processed?</label>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('leave-allocations.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>