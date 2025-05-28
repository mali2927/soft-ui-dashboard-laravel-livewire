<div class="container mt-4">
    @if (!$selectedEmployee)
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Employee List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Base Salary</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->biometric_id }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->department }}</td>
                                    <td>{{ number_format($employee->base_salary, 2) }}</td>
                                    <td>
                                        <button wire:click="selectEmployee({{ $employee->id }})"
                                            class="btn btn-sm btn-info">
                                            View Salary
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h4 class="mb-0">Salary Details for {{ $selectedEmployee->name }}</h4>
                <button wire:click="$set('selectedEmployee', null)" class="btn btn-sm btn-light">
                    Back to List
                </button>
            </div>
            <div class="card-body">
                <livewire:salary-state :employee="$selectedEmployee" />
            </div>
        </div>
    @endif
</div>
