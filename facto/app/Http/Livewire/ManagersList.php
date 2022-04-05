<?php

namespace App\Http\Livewire;

use App\Models\UpsoType;
use Livewire\Component;

class ManagersList extends Component
{
    public $upso_type_id;

    public $main_region_id;

    public $region_id;

    public $upso_types;

    public function render()
    {
        return view('livewire.managers-list', [
            'upso_types' => $this->upso_types,
            'upso_type' => $this->upso_type,

        ]);
    }

//     http://facto.test/managers?upso_type_id=1&main_region_id=2&region_id=11
//      http://facto.test/managers/466?upso_type_id=1&main_region_id=2&region_id=11

    public function mount($upso_type_id, $main_region_id, $region_id): void
    {
        $this->upso_type_id = $upso_type_id;
        $this->main_region_id = $main_region_id;
        $this->region_id = $region_id;

        $this->upso_types = UpsoType::all();
        $this->upso_type = upsoType::find($upso_type_id);
    }
}
