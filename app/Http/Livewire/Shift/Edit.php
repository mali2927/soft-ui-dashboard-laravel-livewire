<?php

namespace App\Http\Livewire\Shift;

use Livewire\Component;
use App\Models\Shift;
use App\Models\Employee;

class Edit extends Component
{
    public $shiftId;
    public $name, $start_time, $end_time, $break_start, $break_end, $is_night_shift, $description;
    public $selectedEmployees = [];

    public function mount($id)
    {
        $shift = Shift::with('employees')->findOrFail($id);
        $this->shiftId = $shift->id;
        $this->name = $shift->name;
        $this->start_time = $shift->start_time->format('H:i');
        $this->end_time = $shift->end_time->format('H:i');
        $this->break_start = $shift->break_start->format('H:i');
        $this->break_end = $shift->break_end->format('H:i');
        $this->is_night_shift = $shift->is_night_shift;
        $this->description = $shift->description;
        $this->selectedEmployees = $shift->employees->pluck('id')->toArray();
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'start_time' => 'required',
        'end_time' => 'required',
        'break_start' => 'nullable',
        'break_end' => 'nullable',
        'is_night_shift' => 'boolean',
        'description' => 'nullable|string',
        'selectedEmployees' => 'array',
    ];

    public function update()
    {
        $this->validate();

        $shift = Shift::findOrFail($this->shiftId);

        $shift->update([
            'name' => $this->name,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'break_start' => $this->break_start,
            'break_end' => $this->break_end,
            'is_night_shift' => $this->is_night_shift,
            'description' => $this->description,
        ]);

           foreach ($this->selectedEmployees as $employeeId) {
        $shift->employees()->attach($employeeId, [
            'effective_from' => now(),
            'effective_to' => null,
            'is_active' => true,
        ]);
    }

        session()->flash('success', 'Shift updated successfully.');
        return redirect()->route('shifts.index');
    }

    public function render()
    {
        return view('livewire.shift.edit', [
            'employees' => Employee::all(),
        ]);
    }
}
