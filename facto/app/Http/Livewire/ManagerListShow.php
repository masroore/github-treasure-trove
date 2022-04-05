<?php

namespace App\Http\Livewire;

use App\Models\Allowance;
use App\Models\Manager;
use App\Models\Region;
use Livewire\Component;

class ManagerListShow extends Component
{
    public $upso_type_id;

    public $region_ids;

    public $allowances;

    public $main_region_id;

    public $region_id;

    public $selected = [];

    public $colors;

    public $bg_colors;

    public $upso_id;

    public $perPage = 24;

    protected $listeners = [
        'load-more' => 'loadMore',
    ];

    public function loadMore(): void
    {
        $this->perPage = $this->perPage + 24;
    }

    public function render()
    {
        $managers = $this->get_managers($this->upso_id);
        // $managers = Team::latest()->orderBy('id', 'desc')->paginate($this->perPage);
        $this->emit('userStore');

        return view('livewire.manager-list-show', [
            'managers' => $managers,
            // 'all_allowances'=> $this->get_all_allowances(),
        ]);
    }

    public function mount($upso_id): void
    {
        $this->upso_id = $upso_id;

        $this->colors = [
            'border-red-600',
            'border-green-600',
            'border-blue-600',
            'border-purple-600',
            'border-yellow-600',
        ];
        $this->bg_colors = [
            'bg-red-600',
            'bg-green-600',
            'bg-blue-600',
            'bg-purple-600',
            'bg-yellow-600',
        ];
    }

    public function get_allowances($allowances)
    {
        if ($allowances) {
            return Allowance::whereIn('id', $allowances)->get();
        }

        return null;
    }

    public function get_all_allowances()
    {
        $allowances = Allowance::all();

        return $allowances;
    }

    protected function get_managers($upso_id)
    {
        $managers = Manager::where('upso_id', $this->upso_id)
            ->with('upso')
            ->with('all_images')
            ->with('allowances')
            ->paginate();

        return $managers;
    }

    protected function get_region_ids($main_region_id, $region_id)
    {
        if ($region_id) {
            return [$region_id];
        }
        if (!$main_region_id) {
            return Region::whereNotNull('parent_id')->get()->pluck('id');
        }

        return Region::where('parent_id', $main_region_id)
                            // ->with(['posts'=> function( $q) use( $post_cat_id) {
                            //     $q->where('posts.post_cat_id', '=', $post_cat_id);
                            // }])
            ->get()->pluck('id');
    }
}
