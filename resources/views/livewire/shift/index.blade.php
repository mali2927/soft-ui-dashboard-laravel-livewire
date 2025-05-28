<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0 fw-bold text-primary">Shift Management</h2>
            <a href="{{ route('shifts.create') }}" class="btn btn-primary rounded-pill">
                <i class="bi bi-plus-circle me-2"></i>Create New Shift
            </a>
        </div>

        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive rounded-3 border">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Shift Name</th>
                            <th>Timing</th>
                            <th>Break</th>
                            <th>Type</th>
                            <th>Employees</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shifts as $shift)
                            <tr class="align-middle">
                                <td class="ps-4 fw-semibold">{{ $shift->name }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $shift->start_time->format('H:i') }} - {{ $shift->end_time->format('H:i') }}
                                    </span>
                                </td>
                                <td>
                                    @if ($shift->break_start)
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-cup-hot me-1"></i>
                                            {{ $shift->break_start?->format('H:i') }} -
                                            {{ $shift->break_end?->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="text-muted small">No break</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($shift->is_night_shift)
                                        <span class="badge bg-dark text-white">
                                            <i class="bi bi-moon-stars me-1"></i>Night Shift
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-sun me-1"></i>Day Shift
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2" style="max-height: 100px; overflow-y: auto;">
                                        @forelse ($shift->employees as $emp)
                                            <span class="badge bg-primary text-white text-truncate"
                                                style="max-width: 120px;" data-bs-toggle="tooltip"
                                                title="{{ $emp->name }}">
                                                <i class="bi bi-person-fill me-1"></i>
                                                {{ Str::limit($emp->name, 15) }}
                                            </span>
                                        @empty
                                            <span class="text-muted small">No employees assigned</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('shifts.edit', $shift->id) }}"
                                            class="btn btn-sm btn-outline-primary rounded-start-pill">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button wire:click="delete({{ $shift->id }})"
                                            class="btn btn-sm btn-outline-danger rounded-end-pill"
                                            onclick="return confirm('Are you sure you want to delete this shift?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
