<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Authentication;
use Livewire\WithPagination;

class AuthenticationTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Inputs bound to form fields
    public $searchEmpInput = '';
    public $directionFilterInput = '';
    public $dateFilterInput = '';

    // Actual filters used for querying
    public $searchEmp = '';
    public $directionFilter = '';
    public $dateFilter = '';

    public function updated($propertyName)
    {
        // Reset page only when actual filters change, not inputs
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
