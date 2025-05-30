<?php

namespace App\Http\Livewire\SalaryAdjustment;

use Livewire\Component;
use App\Models\SalaryAdjustment;

class Delete extends Component
{
    public $adjustment;
    public $confirmingDeletion = false;

    public function mount(SalaryAdjustment $adjustment)
    {
        $this->adjustment = $adjustment;
    }

    public function confirmDelete()
    {
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        $this->adjustment->delete();
        session()->flash('message', 'Salary adjustment deleted successfully.');
        return redirect()->route('salary-adjustments.index');
    }

    public function render()
    {
        return view('livewire.salary-adjustment.delete');
    }
}