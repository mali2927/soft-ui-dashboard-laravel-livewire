<div>
    <h2 class="text-lg font-semibold mb-4 text-center">Employees</h2>

    <div class="flex justify-between mb-4">
        <a href="{{ route('employee.create') }}" class="btn btn-primary">Add Employee</a>
        
        <div class="w-64">
            <input 
                type="text" 
                wire:model.lazy="search" 
                placeholder="Search employees..." 
                class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                wire:loading.attr="disabled"
            >
            <div wire:loading wire:target="search" class="text-sm text-gray-500 mt-1">
                Searching...
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success mb-4 p-3 bg-green-100 text-green-700 rounded text-center">
            {{ session('message') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border mx-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border text-center">Name</th>
                    <th class="py-2 px-4 border text-center">CNIC</th>
                    <th class="py-2 px-4 border text-center">Department</th>
                    <th class="py-2 px-4 border text-center">Designation</th>
                    <th class="py-2 px-4 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                    <tr>
                        <td class="py-2 px-4 border text-center">{{ $emp->name }}</td>
                        <td class="py-2 px-4 border text-center">{{ $emp->cnic }}</td>
                        <td class="py-2 px-4 border text-center">{{ $emp->department }}</td>
                        <td class="py-2 px-4 border text-center">{{ $emp->designation }}</td>
                        <td class="py-2 px-4 border text-center">
                            <a href="{{ route('employee.edit', $emp->id) }}" class="btn btn-sm btn-info">Edit</a>
                            <button wire:click="delete({{ $emp->id }})" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 border text-center text-gray-500">
                            No employees found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-center">
        {{ $employees->links() }}
    </div>
</div>