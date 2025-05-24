<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Authentication;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        ]);

        $query->orderBy('authentication_datetime', 'desc')
            ->chunk(1000, function ($authentications) use ($handle) {
                foreach ($authentications as $auth) {
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



    public function render()
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

        $authentications = $query->latest('authentication_datetime')->paginate(10);

        return view('livewire.authentication-table', [
            'authentications' => $authentications,
        ]);
    }
}
