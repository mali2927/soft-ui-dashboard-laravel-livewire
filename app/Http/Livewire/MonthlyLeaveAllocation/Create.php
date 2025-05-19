<?php

namespace App\Http\Livewire\MonthlyLeaveAllocation;

use App\Models\Employee;
use App\Models\MonthlyLeaveAllocation;
use Livewire\Component;

class Create extends Component
{
    public $employee_id;
    public $month_year;
    public $allocated_leaves;
    public $used_leaves = 0;
    public $carry_over_amount = 0;
    public $is_processed = false;

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'month_year' => 'required|date_format:Y-m',
        'allocated_leaves' => 'required|numeric|min:0',
        'used_leaves' => 'required|numeric|min:0',
        'carry_over_amount' => 'required|numeric|min:0',
        'is_processed' => 'boolean'
    ];

    public function render()
    {
        $employees = Employee::orderBy('name')->get();
        return view('livewire.monthly-leave-allocation.create', [
            'employees' => $employees
        ]);
    }

    public function store()
    {
        $this->validate();

        MonthlyLeaveAllocation::create([
            'employee_id' => $this->employee_id,
            'month_year' => $this->month_year. '-01',
            'allocated_leaves' => $this->allocated_leaves,
            'used_leaves' => $this->used_leaves,
            'carry_over_amount' => $this->carry_over_amount,
            'is_processed' => $this->is_processed,
        ]);

        session()->flash('message', 'Leave allocation created successfully.');
        return redirect()->route('leave-allocations.index');
    }
}