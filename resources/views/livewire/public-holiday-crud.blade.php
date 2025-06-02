<div class="container mt-4">
    <h3 class="mb-4">Public Holidays</h3>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Holiday Name" wire:model="name">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" wire:model="date">
                @error('date') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" wire:model="is_recurring" id="recurringCheck">
                    <label class="form-check-label" for="recurringCheck">Recurring</label>
                </div>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" placeholder="Description" wire:model="description">
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">{{ $isEditMode ? 'Update' : 'Add' }}</button>
                @if($isEditMode)
                    <button type="button" class="btn btn-secondary" wire:click="resetFields">Cancel</button>
                @endif
            </div>
        </div>
    </form>

    <hr class="my-4">

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Recurring</th>
                <th>Description</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($publicHolidays as $holiday)
                <tr>
                    <td>{{ $holiday->name }}</td>
                    <td>{{ $holiday->date->format('Y-m-d') }}</td>
                    <td>{{ $holiday->is_recurring ? 'Yes' : 'No' }}</td>
                    <td>{{ $holiday->description }}</td>
                    <td>
                        <button class="btn btn-sm btn-info" wire:click="edit({{ $holiday->id }})">Edit</button>
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $holiday->id }})"
                            onclick="return confirm('Are you sure?')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
