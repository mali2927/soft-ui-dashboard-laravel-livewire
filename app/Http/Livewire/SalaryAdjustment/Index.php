<?php

namespace App\Http\Livewire\SalaryAdjustment;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SalaryAdjustment;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        return view('livewire.salary-adjustment.index', [
            'adjustments' => SalaryAdjustment::with(['employee', 'creator'])
                ->when($this->search, function($query) {
                    $query->whereHas('employee', function($q) {
                        $q->where('name', 'like', '%'.$this->search.'%');
                    })
                    ->orWhere('type', 'like', '%'.$this->search.'%')
                    ->orWhere('reason', 'like', '%'.$this->search.'%');
                })
                ->orderBy('effective_date', 'desc')
                ->paginate($this->perPage)
        ]);
    }
}