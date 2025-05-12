<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyLeaveAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month_year',
        'allocated_leaves',
        'used_leaves',
        'carry_over_amount',
        'is_processed',
    ];

    protected $casts = [
        'month_year' => 'date:Y-m',
        'carry_over_amount' => 'decimal:2',
        'is_processed' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}