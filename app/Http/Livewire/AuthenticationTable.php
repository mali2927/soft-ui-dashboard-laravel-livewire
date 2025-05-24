<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Authentication;
use Livewire\WithPagination;

class AuthenticationTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; // For Bootstrap-compatible pagination

    public function render()
    {
        $authentications = Authentication::latest('authentication_datetime')->paginate(10);

        return view('livewire.authentication-table', [
            'authentications' => $authentications,
        ]);
    }
}
