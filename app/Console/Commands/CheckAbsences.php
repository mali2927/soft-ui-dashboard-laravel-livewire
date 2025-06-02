<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\Shift;
use App\Models\Authentication;
use App\Models\SalaryAdjustment;
use App\Models\LeaveBalance;
use Carbon\Carbon;

class CheckAbsences extends Command
{
    protected $signature = 'absences:check';
    protected $description = 'Check for employee absences and create adjustments';

    public function handle()
    {
        $today = Carbon::today();
        
        // Get all active employees with their shifts
        $employees = Employee::with(['shifts' => function($query) use ($today) {
            $query->where('employee_shifts.is_active', true)
                  ->where('employee_shifts.effective_from', '<=', $today)
                  ->where(function($q) use ($today) {
                      $q->whereNull('employee_shifts.effective_to')
                        ->orWhere('employee_shifts.effective_to', '>=', $today);
                  });
        }])->active()->get();

        foreach ($employees as $employee) {
            foreach ($employee->shifts as $shift) {
                $this->checkEmployeeAbsence($employee, $shift, $today);
            }
        }
        
        $this->info('Absence check completed successfully.');
    }

    protected function checkEmployeeAbsence($employee, $shift, $date)
    {
        // Check if employee has any authentication for this date
        $hasAuthentication = Authentication::where('emp_id', $employee->id)
            ->whereDate('authentication_date', $date)
            ->exists();

        if (!$hasAuthentication) {
            // Employee is absent - create salary adjustment
            $this->createAbsenceAdjustment($employee, $date);
            
            // Deduct from leave balance if available
            $this->updateLeaveBalance($employee, $date);
        }
    }

protected function createAbsenceAdjustment($employee, $date)
{
    // Check if adjustment already exists for this date
    $exists = SalaryAdjustment::where('employee_id', $employee->id)
        ->whereDate('effective_date', $date)
        ->where('type', 'absence')
        ->exists();

    if (!$exists) {
        // Calculate daily rate (basic_salary / 30)
        $dailyRate = $employee->base_salary / 30;
        
        SalaryAdjustment::create([
            'employee_id' => $employee->id,
            'type' => 'absence',
            'amount' => -$dailyRate, // Negative value for deduction
            'reason' => 'Automatic absence deduction for ' . $date->format('Y-m-d'),
            'effective_date' => $date,
            'created_by' => 1 // System user
        ]);
        
        $this->info("Created absence deduction of ".number_format($dailyRate, 2)." for employee {$employee->id}");
    }
}
    protected function updateLeaveBalance($employee, $date)
    {
        // Find annual leave balance for current year
        $leaveBalance = LeaveBalance::where('employee_id', $employee->id)
            //->where('leave_type_id', 1) // Assuming 1 is annual leave
            ->where('year', $date->year)
            ->first();

        if ($leaveBalance && $leaveBalance->remaining > 0) {
            $leaveBalance->increment('used');
            $leaveBalance->decrement('remaining');
            $leaveBalance->save();
        }
    }
}