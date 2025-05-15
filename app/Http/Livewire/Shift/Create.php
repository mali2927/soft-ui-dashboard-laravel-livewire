<?php

namespace App\Http\Livewire\Shift;

use Livewire\Component;
use App\Models\Shift;
use App\Models\Employee;

class Create extends Component
{
    public $name, $start_time, $end_time, $break_start, $break_end, $is_night_shift = false, $description;
    public $selectedEmployees = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i',
        'break_start' => 'nullable|date_format:H:i',
        'break_end' => 'nullable|date_format:H:i',
        'is_night_shift' => 'boolean',
        'description' => 'nullable|string',
        'selectedEmployees' => 'array',
    ];

    public function save()
    {
        $this->validate();

        $shift = Shift::create([
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



        session()->flash('message', 'Shift created successfully!');
        return redirect()->route('shifts.index');
    }

    public function render()
    {
        return view('livewire.shift.create', [
            'employees' => Employee::all(),
        ]);
    }
}
