<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LeaveBalance;
use App\Models\Employee;
use App\Models\LeaveType;

class LeaveBalanceManager extends Component
{
    public $balances;
    public $employees;
    public $leaveTypes;
    public $employee_id, $leave_type_id, $allocated, $year;
    public $editMode = false;
    public $currentId;

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'leave_type_id' => 'required|exists:leave_types,id',
        'allocated' => 'required|numeric|min:0',
        'year' => 'required|numeric|digits:4',
    ];

    public function mount()
    {
        $this->employees = Employee::all();
        $this->leaveTypes = LeaveType::all();
        $this->year = now()->year;
        $this->loadBalances();
    }

    public function loadBalances()
    {
        $this->balances = LeaveBalance::with(['employee', 'leaveType'])
            ->orderBy('year', 'desc')
            ->orderBy('employee_id')
            ->get();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'employee_id' => $this->employee_id,
            'leave_type_id' => $this->leave_type_id,
            'allocated' => $this->allocated,
            'year' => $this->year,
            'remaining' => $this->allocated,
        ];

        if ($this->editMode) {
            $balance = LeaveBalance::find($this->currentId);
            $balance->update($data);
        } else {
            LeaveBalance::create($data);
        }

        $this->resetForm();
        $this->loadBalances();
    }

    public function edit($id)
    {
        $balance = LeaveBalance::find($id);
        $this->currentId = $id;
        $this->employee_id = $balance->employee_id;
        $this->leave_type_id = $balance->leave_type_id;
        $this->allocated = $balance->allocated;
        $this->year = $balance->year;
        $this->editMode = true;
    }

    public function delete($id)
    {
        LeaveBalance::find($id)->delete();
        $this->loadBalances();
    }

    public function resetForm()
    {
        $this->reset(['employee_id', 'leave_type_id', 'allocated', 'year', 'editMode', 'currentId']);
    }

    public function render()
    {
        return view('livewire.leave-balance-manager');
    }
}