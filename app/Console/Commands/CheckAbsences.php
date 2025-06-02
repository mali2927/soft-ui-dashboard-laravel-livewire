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
        // First try to deduct from leave balance
        $leaveDeducted = $this->updateLeaveBalance($employee, $date);
        
        // Only deduct salary if no leaves were available
        if (!$leaveDeducted) {
            $this->createAbsenceAdjustment($employee, $date);
        }
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
        $dailyRate = $employee->base_salary / 30;
        
        $adjustment = SalaryAdjustment::create([
            'employee_id' => $employee->id,
            'type' => 'absence',
            'amount' => -$dailyRate,
            'reason' => 'Salary deduction for absence on ' . $date->format('Y-m-d') . ' (No available leaves)',
            'effective_date' => $date,
            'created_by' => 1
        ]);
        
        $this->info("Created salary deduction of ".number_format($dailyRate, 2)." for employee {$employee->id}");
        return true;
    }
    return false;
}

protected function updateLeaveBalance($employee, $date)
{
    // Get all eligible leave balances (prioritize certain types if needed)
    $leaveBalance = LeaveBalance::where('employee_id', $employee->id)
        ->where('year', $date->year)
        ->where('remaining', '>', 0)
        ->orderBy('leave_type_id') // Optional: prioritize specific leave types
        ->first();

    if ($leaveBalance) {
        $leaveBalance->increment('used');
        $leaveBalance->decrement('remaining');
        $leaveBalance->save();
        
        // Create a record of leave usage
        SalaryAdjustment::create([
            'employee_id' => $employee->id,
            'type' => 'absence',
            'amount' => 0, // Or negative if you want to track leave "cost"
            'reason' => 'Used leave for absence on ' . $date->format('Y-m-d'),
            'effective_date' => $date,
            'created_by' => 1
        ]);
        
        $this->info("Deducted 1 leave from employee {$employee->id}'s balance");
        return true;
    }
    
    return false;
}
}