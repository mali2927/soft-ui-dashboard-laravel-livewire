<?php

namespace App\Http\Livewire\MonthlyLeaveAllocation;

use App\Models\MonthlyLeaveAllocation;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10]
    ];

    public function render()
    {
        $allocations = MonthlyLeaveAllocation::with('employee')
            ->when($this->search, function($query) {
                return $query->whereHas('employee', function($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('month_year', 'desc')
            ->paginate($this->perPage);

        return view('livewire.monthly-leave-allocation.index', [
            'allocations' => $allocations
        ]);
    }
}