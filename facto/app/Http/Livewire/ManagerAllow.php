<?php

namespace App\Http\Livewire;

use App\Model\Team;
use App\Models\Allowance;
use App\Models\Manager;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ManagerAllow extends Component
{
    public $upso_type_id;

    public $region_ids;

    public $main_region_id;

    public $region_id;

    public $allowances = [];

    public $colors;

    public $bg_colors;

    public $search;

    private $manager;

    public $step;

    public $cache_key;

    public $perPage = 24;

    protected $listeners = [
        'load-more' => 'loadMore',
    ];

    public function loadMore(): void
    {
        ++$this->step;
        $this->perPage = $this->perPage + 24;
    }

    public function render()
    {
        $this->region_ids = $this->get_region_ids($this->main_region_id, $this->region_id);

        // dd('render');
        // dd($this->allowances);
        $managers = $this->get_managers($this->upso_type_id, $this->region_ids, $this->allowances, $this->search);
        // $managers = Team::latest()->orderBy('id', 'desc')->paginate($this->perPage);

        $this->emit('userStore');
        // dd($managers->count());

        return view('livewire.manager-allow', [
            'upso_type_id' => $this->upso_type_id,
            'main_region_id' => $this->main_region_id,
            'region_id' => $this->region_id,
            'managers' => $managers,
            'manager' => $this->manager,
            'allowances' => $this->allowances,
            'all_allowances' => $this->get_all_allowances(),
        ]);
    }

    public function mount($upso_type_id, $main_region_id, $region_id, $allowances, $search, $manager = null): void
    {
        $this->step = 0;
        $this->manager = $manager;
        // dd($allowances);
        $this->upso_type_id = $upso_type_id;
        $this->main_region_id = $main_region_id;
        $this->region_id = $region_id;
        $this->allowances = $allowances;
        $this->search = $search;
        if ($this->allowances == null) {
            $this->allowances = [];
        }

        // '오피', '건마', '룸/풀싸롱', '안마/휴게텔', '핸플/립/키스',
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

    public function add_allowance($allowance_id): void
    {
        if ($this->allowances && in_array((string) $allowance_id, $this->allowances)) {
            if (($key = array_search($allowance_id, $this->allowances)) !== false) {
                unset($this->allowances[$key]);
            }
        } else {
            $this->allowances[] = $allowance_id;
            // array_push( $this->allowances, $allowance_id);
        }
        // dd($this->allowances);
        $this->step = 0;
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
        $allowances = Allowance::withCount('managers')->get();

        return $allowances;
    }

    protected function get_managers($upso_type_id, $region_ids, $selected, $search)
    {

        // dd( serialize($region_ids));
        if ($this->step == 0) {
            // $milliseconds = (int) (round(microtime(true) * 1000000));
            $secondtime = substr(Carbon::now()->format('his'), 0, -2);
            // $this->cache_key = $cache_key = $tt ;

            // dd( gettype($region_ids) );
            $selected_string = implode('-', $selected);
            $region_ids_string = implode('-', $region_ids->toArray());
            // dd($region_ids_string);
            $this->cache_key = implode('|', [
                $secondtime, $upso_type_id, $region_ids_string, $selected_string, $search,
            ]);

            $cache_tag = Carbon::now()->format('h');

            $seconds = 180;
            $managers = Cache::remember($this->cache_key, $seconds, function () use ($upso_type_id, $region_ids, $selected, $search) {
                $managers = Manager::when($region_ids, function ($q, $region_ids) {
                    return $q->whereHas('upso', function ($q) use ($region_ids): void {
                        $q->whereIn('region_id', $region_ids);
                    });
                })
                    ->when($upso_type_id, function ($q, $upso_type_id) {
                    return $q->whereHas('upso', function ($q) use ($upso_type_id): void {
                        $q->where('upso_type_id', $upso_type_id);
                    });
                })
                    ->when($search, function ($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%');
                });

                // 매니저들이 가능한 allowances 중 중복되게 가지고 있는 매니저들만 가져온다.
                $managers = $managers->when(count($selected), function ($query) use ($selected) {
                    return $query->whereHas('allowances', function ($query) use ($selected): void {
                        $query->distinct()->whereIn('allowances.id', $selected);
                    }, '=', count($selected));
                });
                $managers = $managers->with('upso')
                    ->with('allowances')
                    ->with('upso.upso_type')
                    ->inRandomOrder()
                    ->get();

                return $managers;
            });
        } else {
            $managers = Cache::get($this->cache_key);
        }

        // $skip = ( $this->step ) * $this->perPage ;
        $skip = 0;
        $take = $this->perPage;
        if ($managers) {
            $data = $managers->skip($skip)->take($take);
        } else {
            $data = collect([]);
        }

        return $data;
    }

    protected function get_region_ids($main_region_id, $region_id)
    {
        if ($region_id) {
            return collect([$region_id]);
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
