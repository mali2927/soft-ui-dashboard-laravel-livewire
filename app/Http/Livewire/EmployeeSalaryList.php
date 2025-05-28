<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;

class EmployeeSalaryList extends Component
{
    public $employees;
    public $selectedEmployee = null;

    public function mount()
    {
        $this->employees = Employee::with('salaryAdjustments')->get();
    }

    public function selectEmployee($id)
    {
        $this->selectedEmployee = Employee::with('salaryAdjustments')->find($id);
    }

    public function render()
    {
        return view('livewire.employee-salary-list');
    }
}