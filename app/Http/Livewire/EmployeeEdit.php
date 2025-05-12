<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;

class EmployeeEdit extends Component
{
    public $employeeId;
    public $biometric_id, $name, $cnic, $date_of_birth, $gender,
           $contact_number, $address, $emergency_contact,
           $department, $designation, $joining_date,
           $employment_status, $employment_type,
           $base_salary, $bank_account_number, $bank_name;

    public function mount($id)
    {
        $employee = Employee::findOrFail($id);
        $this->employeeId = $employee->id;
    
        $this->fill($employee->toArray());
        $this->date_of_birth = $employee->date_of_birth->format('Y-m-d');
        $this->joining_date = $employee->joining_date->format('Y-m-d');
    }

    protected $rules = [
        'biometric_id' => 'required',
        'name' => 'required',
        'cnic' => 'required',
        'date_of_birth' => 'required|date',
        'gender' => 'required|in:Male,Female',
        'contact_number' => 'required|numeric',
        'address' => 'required',
        'emergency_contact' => 'required|numeric',
        'department' => 'required',
        'designation' => 'required',
        'joining_date' => 'required|date',
        'employment_status' => 'required|in:Active,Inactive,Suspended',
        'employment_type' => 'required',
        'base_salary' => 'required|numeric',
        'bank_account_number' => 'required|numeric',
        'bank_name' => 'required',
    ];

    public function update()
    {
        $validatedData = $this->validate();

        try {
            $employee = Employee::findOrFail($this->employeeId);
            $employee->update($validatedData);
            
            session()->flash('message', 'Employee updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating employee: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.employee-edit')
            ->layout('layouts.app');
    }
}