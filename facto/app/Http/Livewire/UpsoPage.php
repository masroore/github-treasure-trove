<?php

namespace App\Http\Livewire;

use App\Models\Premium;
use App\Models\Region;
use App\Models\Upso;
use App\Models\UpsoType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpsoPage extends Component
{
    public $upso_type_id;

    public $search;

    public $main_region_id;

    public $region_id;

    public $count;

    public function render()
    {
        $main_regions = Region::whereNull('parent_id')->get();
        $upsos = Upso::when($this->upso_type_id, function ($query, $upso_type_id) {
            return $query->where('upso_type_id', $upso_type_id);
        });

        $upsos_best = Upso::when($this->upso_type_id, function ($query, $upso_type_id) {
            return $query->where('upso_type_id', $upso_type_id);
        })
            ->where('show_order', 2);

        if (!$this->main_region_id) {
            // all
            $sub_regions = null;

            $posts_count_in_region = Upso::where('upso_type_id', $this->upso_type_id)
                ->whereIn('show_order', [2, 3])
                ->count();
        } else {
            $upso_type_id = $this->upso_type_id;
            $sub_regions = Region::where('parent_id', $this->main_region_id)
                ->with(['upsos' => function ($q) use ($upso_type_id): void {
                                $q->where('upsos.upso_type_id', '=', $upso_type_id);
                            }])
                ->get();

            if (!$this->region_id) {
                // main all
                $children_ids = $sub_regions->pluck('id');
                $upsos = $upsos->whereIn('region_id', $children_ids);

                $upsos_best = $upsos_best->whereIn('region_id', $children_ids);

                $posts_count_in_region = Upso::where('upso_type_id', $this->upso_type_id)
                    ->whereIn('region_id', $children_ids)
                    ->whereIn('show_order', [2, 3])
                    ->count();
            } else {
                $upsos = $upsos->where('region_id', $this->region_id);
                $upsos_best = $upsos_best->where('region_id', $this->region_id);

                $posts_count_in_region = Upso::where('upso_type_id', $this->upso_type_id)
                    ->where('region_id', $this->region_id)
                    ->whereIn('show_order', [2, 3])
                    ->count();
            }
        }

        if ($this->search) {
            $upsos_best = $upsos_best->where(function ($q): void {
                $q->where('site_name', 'like', '%' . $this->search . '%')
                    ->orWhere('title', 'like', '%' . $this->search . '%');
            });
            $upsos = $upsos->where(function ($q): void {
                $q->where('site_name', 'like', '%' . $this->search . '%')
                    ->orWhere('title', 'like', '%' . $this->search . '%');
            });
        }

        $upsos_best = $upsos_best->orderBy('created_at', 'desc')
            ->get();
        $upsos = $upsos->whereIn('show_order', [3])
            ->with('region')
            ->orderBy('created_at', 'desc')
            ->get();

        $myupso = null;
        if (Auth::check()) {
            $myupso = Upso::where('upso_type_id', $this->upso_type_id)
                ->where('user_id', Auth::user()->id)
                ->first();
        }

        $upso_types = UpsoType::all();

        $upso_type = UpsoType::find($this->upso_type_id);
        if ($this->region_id) {
            $region = Region::find($this->region_id);
        } elseif ($this->main_region_id) {
            $region = Region::find($this->main_region_id);
        } else {
            $region = null;
        }

        $premia = Premium::with('upso')->get();

        return view('livewire.upso-page', [
            'upsos' => $upsos,
            'upso_types' => $upso_types,
            'upso_type' => $upso_type,
            'upsos_best' => $upsos_best,
            // 'post_premium'=> $post_premium,
            'main_regions' => $main_regions,
            'sub_regions' => $sub_regions,
            'myupso' => $myupso,
            'region' => $region,
            'premia' => $premia,
        ]);
    }

    // function mount($postcatid, Request $request ){
    public function mount($upso_type_id, $main_region_id, $region_id, Request $request): void
    {
        // dd($upso_type_id);

        $this->upso_type_id = $upso_type_id;

        $this->main_region_id = $main_region_id;
        $this->region_id = $region_id;
    }

    public function setMainRegion($id): void
    {
        if ($id == -1) {
            $this->main_region_id = null;
        } else {
            $this->main_region_id = $id;
        }
        $this->region_id = null;
    }

    public function setSubRegion($id): void
    {
        $this->region_id = $id;
    }

    public function search(): void
    {
    }
}
