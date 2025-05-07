<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;

class EmployeeIndex extends Component
{
    public $employees;

    public function mount()
    {
        $this->employees = Employee::latest()->get();
    }

    public function delete($id)
    {
        Employee::findOrFail($id)->delete();
        $this->employees = Employee::latest()->get(); // Refresh list
        session()->flash('message', 'Employee deleted successfully.');
    }

    public function render()
    {
        return view('livewire.employee-index');
    }
}

