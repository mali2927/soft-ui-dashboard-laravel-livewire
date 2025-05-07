<div>
    <h2 class="text-lg font-semibold mb-4">Employees</h2>

    <a href="{{ route('employee.create') }}" class="btn btn-primary mb-3">Add Employee</a>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>CNIC</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $emp)
                <tr>
                    <td>{{ $emp->name }}</td>
                    <td>{{ $emp->cnic }}</td>
                    <td>{{ $emp->department }}</td>
                    <td>{{ $emp->designation }}</td>
                    <td>
                        <a href="{{ route('employee.edit', $emp->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <button wire:click="delete({{ $emp->id }})" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
