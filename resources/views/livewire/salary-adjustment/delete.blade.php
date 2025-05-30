<div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Delete Salary Adjustment</h4>
                    </div>
                    <div class="card-body">
                        @if (!$confirmingDeletion)
                            <div class="alert alert-warning">
                                <p>Are you sure you want to delete this salary adjustment?</p>
                                <p><strong>Employee:</strong> {{ $adjustment->employee->name }}</p>
                                <p><strong>Type:</strong> {{ ucfirst($adjustment->type) }}</p>
                                <p><strong>Amount:</strong> {{ number_format($adjustment->amount, 2) }}</p>
                                <p><strong>Effective Date:</strong> {{ $adjustment->effective_date->format('M d, Y') }}
                                </p>

                                <button wire:click="confirmDelete" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Confirm Delete
                                </button>
                                <a href="{{ route('salary-adjustments.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <p>Are you absolutely sure? This action cannot be undone.</p>

                                <button wire:click="delete" class="btn btn-danger">
                                    <i class="fas fa-exclamation-triangle"></i> Yes, Delete Permanently
                                </button>
                                <button wire:click="$set('confirmingDeletion', false)" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
