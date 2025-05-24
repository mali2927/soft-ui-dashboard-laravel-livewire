<div class="container mt-4">
    <h4 class="mb-3">Authentication Logs</h4>

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
                        <td>{{ $auth->device_name }}</td>
                        <td>{{ $auth->device_serial_no }}</td>
                        <td>{{ $auth->person_name }}</td>
                        <td>{{ $auth->card_no }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">No authentication records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $authentications->links() }}
    </div>
</div>
