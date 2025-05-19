<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\Employee;
use App\Models\LeaveType;
use Carbon\Carbon;

class LeaveRequestManager extends Component
{
    public $leaveRequests;
    public $employees;
    public $leaveTypes;
    
    public $employee_id, $leave_type_id, $start_date, $end_date, $reason;
    public $editMode = false;
    public $currentId;
    public $statusFilter = 'all';
    public $comments, $status;

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'leave_type_id' => 'required|exists:leave_types,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|max:500',
    ];

    public function mount()
    {
        $this->employees = Employee::all();
        $this->leaveTypes = LeaveType::all();
        $this->loadLeaveRequests();
    }

    public function loadLeaveRequests()
    {
        $query = LeaveRequest::with(['employee', 'leaveType'])
            ->orderBy('created_at', 'desc');

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $this->leaveRequests = $query->get();
    }

    public function updatedStatusFilter()
    {
        $this->loadLeaveRequests();
    }

    public function save()
    {
        $this->validate();

        $days = Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)) + 1;

        if ($this->editMode) {
            $leaveRequest = LeaveRequest::find($this->currentId);
            $leaveRequest->update([
                'employee_id' => $this->employee_id,
                'leave_type_id' => $this->leave_type_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'days' => $days,
                'reason' => $this->reason,
            ]);
        } else {
            LeaveRequest::create([
                'employee_id' => $this->employee_id,
                'leave_type_id' => $this->leave_type_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'days' => $days,
                'reason' => $this->reason,
                'status' => 'pending',
            ]);
        }

        $this->resetForm();
        $this->loadLeaveRequests();
    }

    public function edit($id)
    {
        $leaveRequest = LeaveRequest::find($id);
        $this->currentId = $id;
        $this->employee_id = $leaveRequest->employee_id;
        $this->leave_type_id = $leaveRequest->leave_type_id;
        $this->start_date = $leaveRequest->start_date->format('Y-m-d');
        $this->end_date = $leaveRequest->end_date->format('Y-m-d');
        $this->reason = $leaveRequest->reason;
        $this->status = $leaveRequest->status;
        $this->comments = $leaveRequest->comments;
        $this->editMode = true;
    }

public function updateStatus($status)
{
    $leaveRequest = LeaveRequest::find($this->currentId);
    
    if ($status === 'approved') {
        // Check leave balance before approving
        $balance = LeaveBalance::firstOrCreate(
            [
                'employee_id' => $leaveRequest->employee_id,
                'leave_type_id' => $leaveRequest->leave_type_id,
                'year' => now()->year,
            ],
            [
                'allocated' => 0,
                'used' => 0,
                'remaining' => 0,
            ]
        );
        
        // Check if remaining leaves are sufficient
        if ($balance->remaining < $leaveRequest->days) {
            session()->flash('error', 'Cannot approve request. Remaining leaves ('.$balance->remaining.') are less than requested days ('.$leaveRequest->days.')');
            return;
        }
    }

    $leaveRequest->update([
        'status' => $status,
        'comments' => $this->comments,
        'approved_by' => auth()->id(),
        'approved_at' => now(),
    ]);

    if ($status === 'approved') {
        // Update leave balance
        $this->updateLeaveBalance($leaveRequest);
    }

    $this->resetForm();
    $this->loadLeaveRequests();
}

    protected function updateLeaveBalance($leaveRequest)
    {
        $balance = LeaveBalance::firstOrCreate(
            [
                'employee_id' => $leaveRequest->employee_id,
                'leave_type_id' => $leaveRequest->leave_type_id,
                'year' => now()->year,
            ],
            [
                'allocated' => 0,
                'used' => 0,
                'remaining' => 0,
            ]
        );

        $balance->update([
            'used' => $balance->used + $leaveRequest->days,
            'remaining' => $balance->allocated - ($balance->used + $leaveRequest->days),
        ]);
    }

    public function delete($id)
    {
        LeaveRequest::find($id)->delete();
        $this->loadLeaveRequests();
    }

    public function resetForm()
    {
        $this->reset([
            'employee_id', 'leave_type_id', 'start_date', 'end_date', 
            'reason', 'editMode', 'currentId', 'comments', 'status'
        ]);
    }

    public function render()
    {
        return view('livewire.leave-request-manager');
    }
}