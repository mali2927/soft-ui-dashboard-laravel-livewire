<div class="container-fluid py-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0"><i class="bi bi-clock me-2"></i>{{ isset($shiftId) ? 'Edit Shift' : 'Create New Shift' }}
            </h4>
        </div>

        <div class="card-body p-4">
            <form wire:submit.prevent="{{ isset($shiftId) ? 'update' : 'save' }}">
                <!-- Shift Basic Information -->
                <div class="row mb-4 g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="shiftName" wire:model="name" placeholder=" " required>
                            <label for="shiftName"><i class="bi bi-card-heading me-2"></i>Shift Name</label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                                id="startTime" wire:model="start_time" required>
                            <label for="startTime"><i class="bi bi-play-circle me-2"></i>Start Time</label>
                            @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                                id="endTime" wire:model="end_time" required>
                            <label for="endTime"><i class="bi bi-stop-circle me-2"></i>End Time</label>
                            @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Break Time & Options -->
                <div class="row mb-4 g-3">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="time" class="form-control" id="breakStart" wire:model="break_start"
                                placeholder=" ">
                            <label for="breakStart"><i class="bi bi-cup-hot me-2"></i>Break Start</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="time" class="form-control" id="breakEnd" wire:model="break_end"
                                placeholder=" ">
                            <label for="breakEnd"><i class="bi bi-cup-hot-fill me-2"></i>Break End</label>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex align-items-center">
                        <div class="form-check form-switch ps-0">
                            <input class="form-check-input ms-0" type="checkbox" role="switch" id="nightShift"
                                wire:model="is_night_shift" style="width: 3em; height: 1.5em;">
                            <label class="form-check-label ms-3 fw-semibold" for="nightShift">
                                <i class="bi bi-moon-stars me-2"></i>Night Shift
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <div class="form-floating">
                        <textarea class="form-control" id="shiftDescription" wire:model="description" placeholder=" " style="height: 100px"></textarea>
                        <label for="shiftDescription"><i class="bi bi-text-paragraph me-2"></i>Description
                            (Optional)</label>
                    </div>
                </div>

                <!-- Employee Assignment -->
                <div class="mb-4">
                    <label class="form-label mb-2 fw-semibold"><i class="bi bi-people-fill me-2"></i>Assign
                        Employees</label>
                    <select class="form-select @error('selectedEmployees') is-invalid @enderror" id="employeeSelect"
                        wire:model="selectedEmployees" multiple>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">
                                <i class="bi bi-person-fill me-2"></i>{{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('selectedEmployees')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted mt-1 d-block"><i class="bi bi-info-circle me-1"></i>Hold Ctrl/Cmd to select
                        multiple employees</small>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between border-top pt-4">
                    <a href="{{ route('shifts.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary px-4" wire:loading.attr="disabled">
                        <span wire:loading.class="d-none">
                            <i class="bi bi-save-fill me-2"></i> {{ isset($shiftId) ? 'Update' : 'Create' }} Shift
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status"
                                aria-hidden="true"></span>
                            Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <style>
        .form-switch .form-check-input {
            width: 3em;
            height: 1.5em;
        }

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

        option:hover {
            background-color: var(--bs-primary) !important;
            color: white !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            // Initialize Select2 with theme
            $('#employeeSelect').select2({
                theme: 'bootstrap-5',
                placeholder: "Select employees",
                allowClear: true,
                width: '100%',
                closeOnSelect: false
            });

            // Update Livewire when Select2 changes
            $('#employeeSelect').on('change', function(e) {
                let data = $(this).val();
                @this.set('selectedEmployees', data);
            });

            // Refresh Select2 when Livewire updates
            Livewire.hook('message.processed', (message, component) => {
                $('#employeeSelect').select2({
                    theme: 'bootstrap-5',
                    placeholder: "Select employees",
                    allowClear: true,
                    width: '100%',
                    closeOnSelect: false
                });
            });
        });
    </script>
@endpush
