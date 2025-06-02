<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'biometric_id',
        'name',
        'cnic',
        'date_of_birth',
        'gender',
        'contact_number',
        'address',
        'emergency_contact',
        'department',
        'designation',
        'joining_date',
        'employment_status',
        'employment_type',
        'base_salary',
        'bank_account_number',
        'bank_name',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
        'base_salary' => 'decimal:2',
    ];

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
    public function scopeActive($query)
    {
        return $query->where('employment_status', 'active'); // Adjust based on your status field
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'employee_shifts')
            ->withPivot(['effective_from', 'effective_to', 'is_active'])
            ->withTimestamps();
    }

    public function salaryAdjustments()
    {
        return $this->hasMany(SalaryAdjustment::class);
    }

    public function monthlyLeaveAllocations()
    {
        return $this->hasMany(MonthlyLeaveAllocation::class);
    }

    public function currentShift()
    {
        return $this->shifts()
            ->where('is_active', true)
            ->where('effective_from', '<=', now())
            ->where(function($query) {
                $query->whereNull('effective_to')
                    ->orWhere('effective_to', '>=', now());
            })
            ->orderBy('effective_from', 'desc')
            ->first();
    }
}