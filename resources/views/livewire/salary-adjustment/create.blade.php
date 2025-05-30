<div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Salary Adjustment</h4>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="save">
                            <div class="form-group">
                                <label for="employee_id">Employee</label>
                                <select wire:model="employee_id" id="employee_id"
                                    class="form-control @error('employee_id') is-invalid @enderror" required>
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="type">Adjustment Type</label>
                                <select wire:model="type" id="type"
                                    class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="bonus">Bonus (+)</option>
                                    <option value="deduction">Deduction (-)</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" wire:model="amount" id="amount" step="0.01" min="0.01"
                                    class="form-control @error('amount') is-invalid @enderror" required>
                                @error('amount')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="effective_date">Effective Date</label>
                                <input type="date" wire:model="effective_date" id="effective_date"
                                    class="form-control @error('effective_date') is-invalid @enderror" required>
                                @error('effective_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="reason">Reason</label>
                                <textarea wire:model="reason" id="reason" rows="3" class="form-control @error('reason') is-invalid @enderror"
                                    required></textarea>
                                @error('reason')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save
                                </button>
                                <a href="{{ route('salary-adjustments.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
