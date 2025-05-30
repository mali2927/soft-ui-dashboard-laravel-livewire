<?php

namespace App\Http\Livewire\SalaryAdjustment;

use Livewire\Component;
use App\Models\SalaryAdjustment;

class Show extends Component
{
    public $adjustment;

    public function mount(SalaryAdjustment $adjustment)
    {
        $this->adjustment = $adjustment;
    }

    public function render()
    {
        return view('livewire.salary-adjustment.show');
    }
}