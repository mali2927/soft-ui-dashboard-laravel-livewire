<?php

namespace App\Http\Livewire\MonthlyLeaveAllocation;

use App\Models\Employee;
use App\Models\MonthlyLeaveAllocation;
use Livewire\Component;

class Edit extends Component
{
    public $allocation;
    public $employee_id;
    public $month_year;
    public $allocated_leaves;
    public $used_leaves;
    public $carry_over_amount;
    public $is_processed;

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'month_year' => 'required|date_format:Y-m',
        'allocated_leaves' => 'required|numeric|min:0',
        'used_leaves' => 'required|numeric|min:0',
        'carry_over_amount' => 'required|numeric|min:0',
        'is_processed' => 'boolean'
    ];

    public function mount(MonthlyLeaveAllocation $allocation)
    {
        $this->allocation = $allocation;
        $this->employee_id = $allocation->employee_id;
        $this->month_year = $allocation->month_year->format('Y-m');
        $this->allocated_leaves = $allocation->allocated_leaves;
        $this->used_leaves = $allocation->used_leaves;
        $this->carry_over_amount = $allocation->carry_over_amount;
        $this->is_processed = $allocation->is_processed;
    }

    public function render()
    {
        $employees = Employee::orderBy('name')->get();
        return view('livewire.monthly-leave-allocation.edit', [
            'employees' => $employees
        ]);
    }

    public function update()
    {
        $this->validate();

        $this->allocation->update([
            'employee_id' => $this->employee_id,
            'month_year' => $this->month_year,
            'allocated_leaves' => $this->allocated_leaves,
            'used_leaves' => $this->used_leaves,
            'carry_over_amount' => $this->carry_over_amount,
            'is_processed' => $this->is_processed,
        ]);

        session()->flash('message', 'Leave allocation updated successfully.');
        return redirect()->route('leave-allocations.index');
    }
}