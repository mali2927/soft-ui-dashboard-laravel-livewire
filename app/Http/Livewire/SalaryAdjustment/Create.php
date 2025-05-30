<?php

namespace App\Http\Livewire\SalaryAdjustment;

use Livewire\Component;
use App\Models\SalaryAdjustment;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $employee_id;
    public $type = '';
    public $amount;
    public $reason;
    public $effective_date;

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'type' => 'required|in:bonus,deduction',
        'amount' => 'required|numeric|min:0.01',
        'reason' => 'required|string|max:500',
        'effective_date' => 'required|date|after_or_equal:today',
    ];

    public function save()
    {
        $this->validate();

        // Automatically handle positive/negative values
        $amount = $this->amount;
        if (in_array($this->type, ['decrease', 'deduction'])) {
            $amount = -abs($amount);
        } else {
            $amount = abs($amount);
        }

        SalaryAdjustment::create([
            'employee_id' => $this->employee_id,
            'type' => $this->type,
            'amount' => $amount, // Use the processed value
            'reason' => $this->reason,
            'effective_date' => $this->effective_date,
            'created_by' => Auth::id(),
        ]);

        session()->flash('message', 'Salary adjustment created successfully.');
        return redirect()->route('salary-adjustments.index');
    }

    public function render()
    {
        return view('livewire.salary-adjustment.create', [
            'employees' => Employee::orderBy('name')->get()
        ]);
    }
}