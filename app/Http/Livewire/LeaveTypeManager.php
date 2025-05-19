<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LeaveType;

class LeaveTypeManager extends Component
{
    public $leaveTypes;
    public $name, $description, $is_paid = true, $requires_approval = true;
    public $editMode = false;
    public $currentId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'is_paid' => 'boolean',
        'requires_approval' => 'boolean',
    ];

    public function mount()
    {
        $this->leaveTypes = LeaveType::all();
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $leaveType = LeaveType::find($this->currentId);
            $leaveType->update([
                'name' => $this->name,
                'description' => $this->description,
                'is_paid' => $this->is_paid,
                'requires_approval' => $this->requires_approval,
            ]);
        } else {
            LeaveType::create([
                'name' => $this->name,
                'description' => $this->description,
                'is_paid' => $this->is_paid,
                'requires_approval' => $this->requires_approval,
            ]);
        }

        $this->resetForm();
        $this->leaveTypes = LeaveType::all();
    }

    public function edit($id)
    {
        $leaveType = LeaveType::find($id);
        $this->currentId = $id;
        $this->name = $leaveType->name;
        $this->description = $leaveType->description;
        $this->is_paid = $leaveType->is_paid;
        $this->requires_approval = $leaveType->requires_approval;
        $this->editMode = true;
    }

    public function delete($id)
    {
        LeaveType::find($id)->delete();
        $this->leaveTypes = LeaveType::all();
    }

    public function resetForm()
    {
        $this->reset(['name', 'description', 'is_paid', 'requires_approval', 'editMode', 'currentId']);
    }

    public function render()
    {
        return view('livewire.leave-type-manager');
    }
}