<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\SalaryAdjustment;
use App\Models\LeaveBalance;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SalaryState extends Component
{
    public $employee;
    public $currentSalary;
    public $baseSalary;
    public $adjustments = [];
    public $leaveDeductions = 0;
    public $allowedLeaves = 4;
    public $usedLeaves = 0;
    public $excessLeaves = 0;
    public $dailyRate = 0;

    public function mount(Employee $employee)
    {
        $this->employee = $employee;
        $this->calculateSalary();
    }

    public function calculateSalary()
    {
        // Get base salary
        $this->baseSalary = $this->employee->base_salary;
        
        // Calculate daily rate (assuming 30 days in a month)
        $this->dailyRate = $this->baseSalary / 30;
        
        // Get current month's used leaves
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $leaveBalance = LeaveBalance::where('employee_id', $this->employee->id)
            ->whereYear('created_at', $currentYear)
            ->first();
            
        $this->allowedLeaves = $leaveBalance ? $leaveBalance->allocated : 4;
        $this->usedLeaves = $leaveBalance ? $leaveBalance->used : 0;
        $this->excessLeaves = max(0, $this->usedLeaves - $this->allowedLeaves);
        $this->leaveDeductions = $this->excessLeaves * $this->dailyRate;
        
        // Get all salary adjustments
        $this->adjustments = SalaryAdjustment::where('employee_id', $this->employee->id)
            ->where('effective_date', '<=', now())
            ->orderBy('effective_date', 'desc')
            ->get();
            
        // Calculate current salary
        $adjustmentsTotal = $this->adjustments->sum('amount');
        $this->currentSalary = $this->baseSalary + $adjustmentsTotal - $this->leaveDeductions;
    }

    public function downloadSalarySlip()
    {
        $data = [
            'employee' => $this->employee,
            'currentSalary' => $this->currentSalary,
            'baseSalary' => $this->baseSalary,
            'adjustments' => $this->adjustments,
            'leaveDeductions' => $this->leaveDeductions,
            'allowedLeaves' => $this->allowedLeaves,
            'usedLeaves' => $this->usedLeaves,
            'excessLeaves' => $this->excessLeaves,
            'dailyRate' => $this->dailyRate,
            'date' => now()->format('F d, Y'),
            'companyName' => config('app.name'), // Add company name from config
        ];

        // Ensure all strings are properly encoded
        array_walk_recursive($data, function (&$value) {
            if (is_string($value)) {
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
        });

        $pdf = Pdf::loadView('salary.slip', $data);
        
        // Set PDF encoding explicitly
        return response()->streamDownload(
            fn () => print($pdf->output()),
            'salary-slip-'.$this->employee->id.'-'.now()->format('Y-m').'.pdf',
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="salary-slip-'.$this->employee->id.'-'.now()->format('Y-m').'.pdf"',
            ]
        );
    }

    public function render()
    {
        return view('livewire.salary-state');
    }
}