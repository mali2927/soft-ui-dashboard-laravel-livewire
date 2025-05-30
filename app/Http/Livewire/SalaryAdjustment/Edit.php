<?php

namespace App\Http\Livewire\SalaryAdjustment;

use Livewire\Component;
use App\Models\SalaryAdjustment;
use App\Models\Employee;

class Edit extends Component
{
    public $adjustment;
    public $employee_id;
    public $type;
    public $amount;
    public $reason;
    public $effective_date;

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'type' => 'required|in:increase,decrease,bonus,deduction',
        'amount' => 'required|numeric|min:0.01',
        'reason' => 'required|string|max:500',
        'effective_date' => 'required|date',
    ];

    public function mount(SalaryAdjustment $adjustment)
    {
        $this->adjustment = $adjustment;
        $this->employee_id = $adjustment->employee_id;
        $this->type = $adjustment->type;
        // Display absolute value in the form
        $this->amount = abs($adjustment->amount);
        $this->reason = $adjustment->reason;
        $this->effective_date = $adjustment->effective_date->format('Y-m-d');
    }

    public function update()
    {
        $this->validate();

        // Automatically handle positive/negative values
        $amount = $this->amount;
        if (in_array($this->type, ['decrease', 'deduction'])) {
            $amount = -abs($amount);
        } else {
            $amount = abs($amount);
        }

        $this->adjustment->update([
            'employee_id' => $this->employee_id,
            'type' => $this->type,
            'amount' => $amount, // Use the processed value
            'reason' => $this->reason,
            'effective_date' => $this->effective_date,
        ]);

        session()->flash('message', 'Salary adjustment updated successfully.');
        return redirect()->route('salary-adjustments.index');
    }

    public function render()
    {
        return view('livewire.salary-adjustment.edit', [
            'employees' => Employee::orderBy('name')->get()
        ]);
    }
}