<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;

class EmployeeIndex extends Component
{
    use WithPagination;
    
    public $search = '';
    
    protected $paginationTheme = 'bootstrap'; // For Bootstrap styling

    protected $queryString = ['search']; // This maintains search in URL

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when searching
    }

    public function delete($id)
    {
        Employee::findOrFail($id)->delete();
        session()->flash('message', 'Employee deleted successfully.');
    }

    public function render()
    {
        $searchTerm = '%'.$this->search.'%';
        
        return view('livewire.employee-index', [
            'employees' => Employee::where(function($query) use ($searchTerm) {
                                $query->where('name', 'like', $searchTerm)
                                      ->orWhere('cnic', 'like', $searchTerm)
                                      ->orWhere('department', 'like', $searchTerm)
                                      ->orWhere('designation', 'like', $searchTerm);
                            })
                            ->latest()
                            ->paginate(10)
        ]);
    }
}