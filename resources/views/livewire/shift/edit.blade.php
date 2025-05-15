<div class="container mt-4">
    <h2>{{ isset($shiftId) ? 'Edit' : 'Create' }} Shift</h2>

    <form wire:submit.prevent="{{ isset($shiftId) ? 'update' : 'store' }}">
        <div class="mb-3">
            <label class="form-label">Shift Name</label>
            <input wire:model="name" type="text" class="form-control">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="row">
            <div class="col">
                <label>Start Time</label>
                <input wire:model="start_time" type="time" class="form-control">
            </div>
            <div class="col">
                <label>End Time</label>
                <input wire:model="end_time" type="time" class="form-control">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <label>Break Start</label>
                <input wire:model="break_start" type="time" class="form-control">
            </div>
            <div class="col">
                <label>Break End</label>
                <input wire:model="break_end" type="time" class="form-control">
            </div>
        </div>

        <div class="form-check mt-3">
            <input wire:model="is_night_shift" type="checkbox" class="form-check-input" id="nightShift">
            <label class="form-check-label" for="nightShift">Night Shift</label>
        </div>

        <div class="mb-3 mt-3">
            <label>Description</label>
            <textarea wire:model="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Assign Employees</label>
            <select wire:model="selectedEmployees" multiple class="form-control">
                @foreach ($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">{{ isset($shiftId) ? 'Update' : 'Create' }}</button>
        <a href="{{ route('shifts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
