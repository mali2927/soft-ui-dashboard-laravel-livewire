<div class="container mt-4">
    <h2>Shifts</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('shifts.create') }}" class="btn btn-primary mb-3">Create New Shift</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Timing</th>
                <th>Break</th>
                <th>Night Shift</th>
                <th>Employees</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shifts as $shift)
                <tr>
                    <td>{{ $shift->name }}</td>
                    <td>{{ $shift->start_time->format('H:i') }} - {{ $shift->end_time->format('H:i') }}</td>
                    <td>{{ $shift->break_start?->format('H:i') }} - {{ $shift->break_end?->format('H:i') }}</td>
                    <td>{{ $shift->is_night_shift ? 'Yes' : 'No' }}</td>
                    <td>
                        @foreach ($shift->employees as $emp)
                            <span class="badge bg-info">{{ $emp->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('shifts.edit', $shift->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <button wire:click="delete({{ $shift->id }})" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
