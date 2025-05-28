<div class="container mt-4">
    <h4 class="mb-3">Authentication Logs</h4>

    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" wire:model.defer="searchEmpInput" class="form-control"
                placeholder="Search by Employee ID or Name">
        </div>
        <div class="col-md-3">
            <select wire:model.defer="directionFilterInput" class="form-select">
                <option value="">All Directions</option>
                <option value="In">In</option>
                <option value="Out">Out</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" wire:model.defer="dateFilterInput" class="form-control" />
        </div>
        <div class="col-md-2 d-flex gap-2 flex-wrap justify-content-end">
            <button wire:click="applyFilters" class="btn btn-primary">Find</button>
            <button wire:click="clearFilters" class="btn btn-secondary">Clear</button>
            <button wire:click="exportCsv" class="btn btn-success">Export CSV</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Emp ID</th>
                    <th>DateTime</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Direction</th>
                    <th>Status</th>
                    <th>Device Name</th>
                    <th>Device Serial</th>
                    <th>Person Name</th>
                    <th>Card No</th>
                </tr>
            </thead>
            <tbody>
                @forelse($authentications as $auth)
                    <tr>
                        <td>{{ $auth->id }}</td>
                        <td>{{ $auth->emp_id }}</td>
                        <td>{{ $auth->authentication_datetime }}</td>
                        <td>{{ $auth->authentication_date }}</td>
                        <td>{{ $auth->authentication_time }}</td>
                        <td>{{ $auth->direction }}</td>
                        <td>
                            @if ($auth->status === 'Late')
                                <span class="badge bg-warning text-dark">
                                    Late ({{ $auth->late_minutes }} mins)
                                </span>
                            @elseif($auth->status === 'Overtime')
                                <span class="badge bg-success">
                                    Overtime ({{ $auth->overtime_minutes }} mins)
                                </span>
                            @else
                                <span class="badge bg-primary">Normal</span>
                            @endif
                        </td>
                        <td>{{ $auth->device_name }}</td>
                        <td>{{ $auth->device_serial_no }}</td>
                        <td>{{ $auth->person_name }}</td>
                        <td>{{ $auth->card_no }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No authentication records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $authentications->links() }}
    </div>
</div>
