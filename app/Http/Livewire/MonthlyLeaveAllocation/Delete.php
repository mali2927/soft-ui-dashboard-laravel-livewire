<?php

namespace App\Http\Livewire\MonthlyLeaveAllocation;

use App\Models\MonthlyLeaveAllocation;
use Livewire\Component;

class Delete extends Component
{
    public $allocation;
    public $confirmingDeletion = false;

    public function mount(MonthlyLeaveAllocation $allocation)
    {
        $this->allocation = $allocation;
    }

    public function confirmDelete()
    {
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        $this->allocation->delete();
        session()->flash('message', 'Leave allocation deleted successfully.');
        return redirect()->route('leave-allocations.index');
    }

    public function render()
    {
        return view('livewire.monthly-leave-allocation.delete');
    }
}