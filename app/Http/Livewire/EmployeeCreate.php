<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;

class EmployeeCreate extends Component
{
    public $biometric_id, $name, $cnic, $date_of_birth, $gender = 'Male',
           $contact_number, $address, $emergency_contact,
           $department, $designation, $joining_date,
           $employment_status = 'Active', $employment_type,
           $base_salary, $bank_account_number, $bank_name;

    protected $rules = [
        'biometric_id' => 'required|unique:employees',
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

    public function save()
    {
        $this->validate();

        Employee::create([
            'biometric_id' => $this->biometric_id,
            'name' => $this->name,
            'cnic' => $this->cnic,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'contact_number' => $this->contact_number,
            'address' => $this->address,
            'emergency_contact' => $this->emergency_contact,
            'department' => $this->department,
            'designation' => $this->designation,
            'joining_date' => $this->joining_date,
            'employment_status' => $this->employment_status,
            'employment_type' => $this->employment_type,
            'base_salary' => $this->base_salary,
            'bank_account_number' => $this->bank_account_number,
            'bank_name' => $this->bank_name,
        ]);

        session()->flash('message', 'Employee added successfully!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.employee-create');
    }
}
