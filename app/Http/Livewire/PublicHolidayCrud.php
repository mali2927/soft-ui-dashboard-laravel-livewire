<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PublicHoliday;

class PublicHolidayCrud extends Component
{
    public $publicHolidays, $name, $date, $is_recurring, $description, $publicHolidayId;
    public $isEditMode = false;

    protected $rules = [
        'name' => 'required|string',
        'date' => 'required|date',
        'is_recurring' => 'boolean',
        'description' => 'nullable|string',
    ];

    public function render()
    {
        $this->publicHolidays = PublicHoliday::latest()->get();
        return view('livewire.public-holiday-crud');
    }

    public function resetFields()
    {
        $this->name = '';
        $this->date = '';
        $this->is_recurring = false;
        $this->description = '';
        $this->publicHolidayId = null;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate();
        PublicHoliday::create([
            'name' => $this->name,
            'date' => $this->date,
            'is_recurring' => $this->is_recurring,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Public holiday added successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $holiday = PublicHoliday::findOrFail($id);
        $this->publicHolidayId = $holiday->id;
        $this->name = $holiday->name;
        $this->date = $holiday->date->format('Y-m-d');
        $this->is_recurring = $holiday->is_recurring;
        $this->description = $holiday->description;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate();
        $holiday = PublicHoliday::findOrFail($this->publicHolidayId);
        $holiday->update([
            'name' => $this->name,
            'date' => $this->date,
            'is_recurring' => $this->is_recurring,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Public holiday updated successfully!');
        $this->resetFields();
    }

    public function delete($id)
    {
        PublicHoliday::destroy($id);
        session()->flash('message', 'Public holiday deleted.');
    }
}
