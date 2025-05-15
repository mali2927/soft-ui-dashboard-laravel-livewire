<div class="container mt-4">
    <h2>Shifts</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('shifts.create') }}" class="btn btn-primary mb-3">Create New Shift</a>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Timing</th>
                    <th>Break</th>
                    <th>Night Shift</th>
                    <th style="width: 25%">Employees</th>
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
                            <div class="d-flex flex-wrap gap-1" style="max-height: 100px; overflow-y: auto;">
                                @foreach ($shift->employees as $emp)
                                    <span class="badge bg-info text-truncate" style="max-width: 100px;" 
                                          data-bs-toggle="tooltip" title="{{ $emp->name }}">
                                        {{ Str::limit($emp->name, 15) }}
                                    </span>
                                @endforeach
                            </div>
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
</div>

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('livewire:load', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
@endpush