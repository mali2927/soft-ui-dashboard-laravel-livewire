<div class="card shadow-lg p-4">
    <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <h4 class="mb-4">Create / Edit Shift</h4>

    <form wire:submit.prevent="save">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Shift Name</label>
                <input type="text" class="form-control" wire:model="name" placeholder="e.g. Morning Shift">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Start Time</label>
                <input type="time" class="form-control" wire:model="start_time">
                @error('start_time') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">End Time</label>
                <input type="time" class="form-control" wire:model="end_time">
                @error('end_time') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Break Start</label>
                <input type="time" class="form-control" wire:model="break_start">
            </div>
            <div class="col-md-3">
                <label class="form-label">Break End</label>
                <input type="time" class="form-control" wire:model="break_end">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" wire:model="is_night_shift" id="nightShift">
                    <label class="form-check-label" for="nightShift">Night Shift?</label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="3" wire:model="description" placeholder="Optional details about this shift..."></textarea>
        </div>
       <div class="mb-3">
    <label class="form-label">Assign Employees</label>
    <select class="form-select" wire:model="selectedEmployees" multiple>
        @foreach($employees as $employee)
            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
        @endforeach
    </select>
    @error('selectedEmployees') <small class="text-danger">{{ $message }}</small> @enderror
</div>



        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Save Shift
        </button>
    </form>
@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        // Initialize Select2
        $('#employeeSelect').select2({
            placeholder: "Select employees",
            allowClear: true
        });

        // Update Livewire when Select2 changes
        $('#employeeSelect').on('change', function (e) {
            let data = $(this).val();
            @this.set('selectedEmployees', data);
        });

        // Refresh Select2 when Livewire updates
        Livewire.hook('message.processed', (message, component) => {
            $('#employeeSelect').select2({
                placeholder: "Select employees",
                allowClear: true
            });
        });
    });
</script>
@endpush

</div>
