<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h2 class="h4 mb-0 fw-bold text-primary">
                <i class="bi bi-clock-history me-2"></i>
                {{ isset($shiftId) ? 'Edit Shift' : 'Create New Shift' }}
            </h2>
        </div>

        <div class="card-body">
            <form wire:submit.prevent="{{ isset($shiftId) ? 'update' : 'store' }}" class="needs-validation" novalidate>
                <div class="row g-3">
                    <!-- Shift Name -->
                    <div class="col-md-12">
                        <label for="shiftName" class="form-label fw-semibold">Shift Name</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-card-heading"></i>
                            </span>
                            <input wire:model="name" type="text" class="form-control rounded-end" id="shiftName"
                                required>
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Shift Timing -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Start Time</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-play-circle"></i>
                            </span>
                            <input wire:model="start_time" type="time" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">End Time</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-stop-circle"></i>
                            </span>
                            <input wire:model="end_time" type="time" class="form-control">
                        </div>
                    </div>

                    <!-- Break Timing -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Break Start</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-cup-hot"></i>
                            </span>
                            <input wire:model="break_start" type="time" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Break End</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-cup-hot-fill"></i>
                            </span>
                            <input wire:model="break_end" type="time" class="form-control">
                        </div>
                    </div>

                    <!-- Night Shift Toggle -->
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input wire:model="is_night_shift" class="form-check-input" type="checkbox" role="switch"
                                id="nightShift" style="width: 3em; height: 1.5em;">
                            <label class="form-check-label fw-semibold" for="nightShift">
                                <i class="bi bi-moon-stars me-1"></i> Night Shift
                            </label>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-text-paragraph"></i>
                            </span>
                            <textarea wire:model="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Assign Employees -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Assign Employees</label>
                        <select wire:model="selectedEmployees" multiple class="form-select" style="height: auto;"
                            size="5">
                            @foreach ($employees as $emp)
                                <option value="{{ $emp->id }}" class="py-2">
                                    <i class="bi bi-person-fill me-2"></i>{{ $emp->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold CTRL/CMD to select multiple employees</small>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="{{ route('shifts.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        @if (isset($shiftId))
                            <i class="bi bi-check-circle me-2"></i>Update Shift
                        @else
                            <i class="bi bi-plus-circle me-2"></i>Create Shift
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .form-switch .form-check-input {
            width: 3em;
            margin-left: -2.5em;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%2386b7fe'/%3e%3c/svg%3e");
        }

        .form-switch .form-check-input:checked {
            background-position: right center;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
        }

        .form-control,
        .form-select,
        .input-group-text {
            border-radius: 0.375rem !important;
        }

        option:hover {
            background-color: var(--bs-primary);
            color: white;
        }
    </style>
@endpush
