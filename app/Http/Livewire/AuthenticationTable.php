<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Authentication;
use App\Models\Employee;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

class AuthenticationTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $searchEmpInput = '';
    public $directionFilterInput = '';
    public $dateFilterInput = '';

    public $searchEmp = '';
    public $directionFilter = '';
    public $dateFilter = '';

    // Add these properties for late/overtime settings
    public $lateThresholdMinutes = 15; // Minutes after which employee is marked late
    public $overtimeThresholdMinutes = 30; // Minutes after which employee gets overtime

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['searchEmp', 'directionFilter', 'dateFilter'])) {
            $this->resetPage();
        }
    }

    public function applyFilters()
    {
        $this->searchEmp = $this->searchEmpInput;
        $this->directionFilter = $this->directionFilterInput;
        $this->dateFilter = $this->dateFilterInput;

        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->searchEmpInput = '';
        $this->directionFilterInput = '';
        $this->dateFilterInput = '';

        $this->searchEmp = '';
        $this->directionFilter = '';
        $this->dateFilter = '';

        $this->resetPage();
    }

    public function exportCsv()
    {
        $query = $this->getFilteredQuery();

        // Set filename with timezone GMT+5 (Asia/Karachi)
        $filename = now('Asia/Karachi')->format('Y-m-d_H-i-s') . '-authentication-logs.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID',
                'Emp ID',
                'DateTime',
                'Date',
                'Time',
                'Direction',
                'Device Name',
                'Device Serial',
                'Person Name',
                'Card No',
                'Status', // Added status column
                'Late Minutes', // Added late minutes
                'Overtime Minutes', // Added overtime minutes
            ]);

            $query->orderBy('authentication_datetime', 'desc')
                ->chunk(1000, function ($authentications) use ($handle) {
                    foreach ($authentications as $auth) {
                        $statusInfo = $this->getStatusInfo($auth);
                        
                        fputcsv($handle, [
                            $auth->id,
                            $auth->emp_id,
                            $auth->authentication_datetime,
                            $auth->authentication_date,
                            $auth->authentication_time,
                            $auth->direction,
                            $auth->device_name,
                            $auth->device_serial_no,
                            $auth->person_name,
                            $auth->card_no,
                            $statusInfo['status'],
                            $statusInfo['late_minutes'],
                            $statusInfo['overtime_minutes'],
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Cache-Control' => 'no-store, no-cache',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    protected function getFilteredQuery()
    {
        $query = Authentication::query();

        if ($this->searchEmp) {
            $query->where(function ($q) {
                $q->where('emp_id', 'like', '%' . $this->searchEmp . '%')
                  ->orWhere('person_name', 'like', '%' . $this->searchEmp . '%');
            });
        }

        if ($this->directionFilter) {
            $query->where('direction', $this->directionFilter);
        }

        if ($this->dateFilter) {
            $query->whereDate('authentication_date', $this->dateFilter);
        }

        return $query;
    }

    protected function getStatusInfo($authentication)
    {
        $status = 'Normal';
        $lateMinutes = 0;
        $overtimeMinutes = 0;

        // Only check for "In" direction
        if ($authentication->direction === 'In') {
            $employee = Employee::where('biometric_id', $authentication->emp_id)->first();
            
            if ($employee) {
                $shift = $employee->currentShift();
                
                if ($shift) {
                    $authTime = Carbon::parse($authentication->authentication_datetime);
                    $shiftStart = Carbon::parse($authentication->authentication_date . ' ' . $shift->start_time->format('H:i:s'));
                    
                    // For night shifts, if auth time is next day, adjust shift start
                    if ($shift->is_night_shift && $authTime->format('H:i:s') < $shiftStart->format('H:i:s')) {
                        $shiftStart->subDay();
                    }
                    
                    // Calculate late minutes
                    if ($authTime > $shiftStart) {
                        $lateMinutes = $authTime->diffInMinutes($shiftStart);
                        
                        if ($lateMinutes > $this->lateThresholdMinutes) {
                            $status = 'Late';
                        }
                    }
                }
            }
        }
        // Only check for "Out" direction
        elseif ($authentication->direction === 'Out') {
            $employee = Employee::where('biometric_id', $authentication->emp_id)->first();
            
            if ($employee) {
                $shift = $employee->currentShift();
                
                if ($shift) {
                    $authTime = Carbon::parse($authentication->authentication_datetime);
                    $shiftEnd = Carbon::parse($authentication->authentication_date . ' ' . $shift->end_time->format('H:i:s'));
                    
                    // For night shifts, if auth time is next day, adjust shift end
                    if ($shift->is_night_shift && $authTime->format('H:i:s') > $shiftEnd->format('H:i:s')) {
                        $shiftEnd->addDay();
                    }
                    
                    // Calculate overtime minutes
                    if ($authTime > $shiftEnd) {
                        $overtimeMinutes = $authTime->diffInMinutes($shiftEnd);
                        
                        if ($overtimeMinutes > $this->overtimeThresholdMinutes) {
                            $status = 'Overtime';
                        }
                    }
                }
            }
        }

        return [
            'status' => $status,
            'late_minutes' => $lateMinutes,
            'overtime_minutes' => $overtimeMinutes,
        ];
    }

    public function render()
    {
        $query = $this->getFilteredQuery();
        $authentications = $query->latest('authentication_datetime')->paginate(10);

        // Add status info to each authentication
        $authentications->each(function ($auth) {
            $statusInfo = $this->getStatusInfo($auth);
            $auth->status = $statusInfo['status'];
            $auth->late_minutes = $statusInfo['late_minutes'];
            $auth->overtime_minutes = $statusInfo['overtime_minutes'];
        });

        return view('livewire.authentication-table', [
            'authentications' => $authentications,
        ]);
    }
}