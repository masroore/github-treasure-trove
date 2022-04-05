<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Dashboard extends Component
{
    public $pagesmode = 0;

    public $hasfocus = 'focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150';

    public function render()
    {
        return view('livewire.dashboard.dashboard');
    }

    public function changePage($id): void
    {
        $this->pagesmode = $id;
    }
}
