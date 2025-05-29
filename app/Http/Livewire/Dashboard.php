<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\Shift;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class Dashboard extends Component
{
    public $totalEmployees;
    public $activeEmployees;
    public $onLeaveToday;
    public $lateEmployees;
    public $leaveRequestsPending;
    public $departmentDistribution = [];
    public $recentLeaveRequests = [];
    public $shiftDistribution = [];
    public $attendanceStats = [];
    public $salaryStats = [];

    public function mount()
    {
        $this->loadEmployeeStats();
        $this->loadLeaveData();
        $this->loadShiftData();
        $this->loadAttendanceData();
        $this->loadSalaryData();
    }

    protected function loadEmployeeStats()
    {
        $this->totalEmployees = Employee::count();
        $this->activeEmployees = Employee::where('employment_status', 'active')->count();
    }
// In your Dashboard.php component
public function downloadAllSalarySlips()
{
    $employees = Employee::with(['salaryAdjustments', 'leaveBalances'])
                ->where('employment_status', 'active')
                ->get();

   

    $data = [
        'employees' => $employees,
        'date' => now()->format('F Y'),
        'company' => [
            'name' => config('app.name'),
            'address' => "123 Business Rd, City, Country",
            'contact' => "contact@company.com | (123) 456-7890"
        ]
    ];

    $pdf = Pdf::loadView('salary.all-slips', $data)
              ->setPaper('a4', 'portrait');

    // Store the PDF temporarily and return a redirect or link to download
    $filename = 'All_Salary_Slips_' . now()->format('F_Y') . '.pdf';
    $path = storage_path('app/public/' . $filename);
    file_put_contents($path, $pdf->output());

    return response()->download($path)->deleteFileAfterSend();
}


    protected function loadLeaveData()
    {
        $today = Carbon::today();
        
        // Employees on leave today
        $this->onLeaveToday = LeaveRequest::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->where('status', 'approved')
            ->count();

        // Pending leave requests
        $this->leaveRequestsPending = LeaveRequest::where('status', 'pending')->count();

        // Recent leave requests
        $this->recentLeaveRequests = LeaveRequest::with(['employee', 'leaveType'])
            ->latest()
            ->take(5)
            ->get();
    }

    protected function loadShiftData()
    {
        // Department distribution
        $this->departmentDistribution = Employee::select('department')
            ->selectRaw('count(*) as count')
            ->groupBy('department')
            ->get()
            ->pluck('count', 'department')
            ->toArray();

        // Shift distribution
        $this->shiftDistribution = Shift::withCount('employees')
            ->get()
            ->pluck('employees_count', 'name')
            ->toArray();
    }

    protected function loadAttendanceData()
    {
        $today = Carbon::today();
        
        // Late employees (you'll need to implement your own logic based on shift timing)
        $this->lateEmployees = 0; // Placeholder - implement your actual late attendance logic
        
        // Attendance stats
        $this->attendanceStats = [
            'present' => Employee::has('attendanceLogs', '>=', 1)->whereDate('created_at', $today)->count(),
            'absent' => $this->activeEmployees - $this->onLeaveToday - $this->lateEmployees,
            'late' => $this->lateEmployees
        ];
    }

    protected function loadSalaryData()
    {
        // Salary statistics
        $this->salaryStats = [
            'total_monthly' => Employee::sum('base_salary'),
            'average' => Employee::avg('base_salary'),
            'highest' => Employee::max('base_salary'),
            'lowest' => Employee::min('base_salary')
        ];
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}