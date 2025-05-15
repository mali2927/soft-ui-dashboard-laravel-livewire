<?php

namespace App\Http\Livewire\Shift;

use Livewire\Component;
use App\Models\Shift;

class Index extends Component
{
    public $shifts;

    public function mount()
    {
        $this->shifts = Shift::with('employees')->get();
    }

    public function delete($id)
    {
        $shift = Shift::findOrFail($id);
        $shift->employees()->detach(); // detach relationships
        $shift->delete();

        session()->flash('success', 'Shift deleted successfully.');
        $this->mount(); // Refresh list
    }

    public function render()
    {
        return view('livewire.shift.index');
    }
}
