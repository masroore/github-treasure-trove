<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Premium;
use App\Models\Region;
use App\Models\Upso;
use App\Models\UpsoType;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ManagerController extends Controller
{
    private $seconds;

    private $colors;

    private $bg_colors;

    public function __construct()
    {
        $this->middleware(['auth', 'isDirector'])->only(['create', 'update', 'edit', 'store', 'destroy']);
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

    public function list(Request $request)
    {
        $upso_id = $request->upso_id;
        $manager_id = $request->manager_id;
        $upso = Upso::where('id', $upso_id)
            ->with('managers')
            ->with('upso_type')
            ->with('all_images')
            ->first();
        if (!$upso) {
            return redirect()->back()->with('error', '업소 정보가 필요합니다.');
        }
        $manager = Manager::where('id', $manager_id)
            ->with('upso')
            ->with('all_images')
            ->first();

        $upso_types = UpsoType::all();

        return view('managers.list')
            ->with('upso_id', $upso_id)
            ->with('upso_types', $upso_types)
            ->with('upso_type', $upso->upso_type)
            ->with('upso', $upso)
            ->with('managers', $upso->managers)
            ->with('manager', $manager);
    }

    public function store(Request $request): void
    {

    }

    public function destroy(Manager $manager, Request $request)
    {
        if (Auth::user()->isAdmin() || Auth::user()->id == $manager->upso->user_id) {
            $manager1 = $manager;
            $manager->delete();
            $this->saveCache($manager1);

            return redirect()->route('managers.index', [
                'upsp_type_id' => $request->upso_type_id,
                'main_region_id' => $request->main_region_id,
                'region_id' => $request->region_id,
                'upso_id' => $request->upso_id,
            ]);
            // } elseif( Auth::user()->id == $manager->upso->user_id )  {
        //     $msg = '삭제는 관리자만 가능합니다.';
        //     return redirect()->back()->with('error', $msg);
        //     return redirect()->route('managers.index', [
        //         'upsp_type_id'=>$request->upso_type_id,
        //         'main_region_id'=>$request->main_region_id,
        //         'region_id'=>$request->region_id,
        //         'upso_id'=>$request->upso_id,
        //     ])->with('error', '삭제는 관리자만 가능합니다.');
        }

        return redirect()->back()->with('error', '권한이 없습니다.');
    }

    public function edit(Manager $manager)
    {
        $user = Auth::user();
        $upso = $manager->upso;

        if (!$this->checkPermission('edit', $upso)) {
            return redirect()->back()->with('error', '권한이 없습니다.');
        }

        if ($upso->user_id == Auth::user()->id || Auth::user()->isAdmin()) {
            return view('managers.edit')
                ->with('manager', $manager);
        }

        return redirect()->back()->with('error', '권한이 없습니다.');
    }

    public function update(Upso $upso, Request $request): void
    {
        dd($upso);
    }

    public function index(Request $request)
    {
        $this->seconds = 60 * 60 * 2;
        $upso_types = UpsoType::all();

        $upso_type_id = $request->upso_type_id;
        $main_region_id = $request->main_region_id;
        $region_id = $request->region_id;
        $allowances = $request->allowances;
        $search = $request->search;
        $allow_id = $request->allow_id;

        $region_ids = $this->get_region_ids($main_region_id, $region_id);
        if ($request->region_id) {
            $region = Region::find($request->region_id);
        } elseif ($request->main_region_id) {
            $region = Region::find($request->main_region_id);
        } else {
            $region = null;
        }

        // $allows = $allow_id ;

        return view('managers.index')
            ->with('main_regions', $this->get_main_regions())
            ->with('main_region', $this->get_main_region($main_region_id, $region_id))
            ->with('sub_regions', $this->get_sub_regions($main_region_id))
            ->with('main_region_id', $main_region_id)
            ->with('region', $region)
            ->with('region_id', $region_id)
            ->with('allowances', $allowances)
                    // ->with('notices', $this->get_upsos( $upso_type_id, $region_ids, $show_order =1 , $search) )
                    // ->with('upsos_best', $this->get_upsos( $upso_type_id, $region_ids, $show_order =2 , $search) )
                    // ->with('upsos', $this->get_upsos( $upso_type_id, $region_ids, $show_order =3 , $search) )
            ->with('upso_types', $upso_types)
            ->with('upso_type', $this->get_upso_type($upso_type_id))
                    // ->with('managers', $this->get_managers( $region_ids, $upso_type_id, $allow_id ))
            ->with('upso_type_id', $upso_type_id)
            ->with('premia', $this->get_premia($upso_type_id))
            ->with('search', $search);
    }

    public function get_managers($region_ids, $upso_type_id, $allow_ids): void
    {
        $managers = Manager::whereHas('upso', function ($q) use ($region_ids, $upso_type_id): void {
            $q->whereIn('region_id', $region_ids)
                ->where('upso_type_id', $upso_type_id);
        })->when($allow_ids, function ($q, $allow_ids) {
            return $q->whereHas('allowances', function ($qq) use ($allow_ids): void {
                $qq->whereIn('id', $allow_ids);
            });
        })->get();
    }

    public function show(Manager $manager, Request $request)
    {
        $manager = Manager::where('id', $manager->id)
            ->with('upso')
            ->with('upso.user')
            ->with('upso.upso_type')
            ->with('all_images')
            ->with('allowances')
            ->first();

        $manager->increment('visits');

        $upso_types = UpsoType::all();

        $upso_type_id = $request->upso_type_id;
        $main_region_id = $request->main_region_id;
        $region_id = $request->region_id;
        $allowances = $request->allowances;
        $search = $request->search;

        $region_ids = $this->get_region_ids($main_region_id, $region_id);
        if ($request->region_id) {
            $region = Region::find($request->region_id);
        } elseif ($request->main_region_id) {
            $region = Region::find($request->main_region_id);
        } else {
            $region = null;
        }

        return view('managers.show')
            ->with('manager', $manager)
            ->with('upso', $manager->upso)
            ->with('main_regions', $this->get_main_regions())
            ->with('main_region', $this->get_main_region($main_region_id, $region_id))
            ->with('sub_regions', $this->get_sub_regions($main_region_id))
            ->with('main_region_id', $main_region_id)
            ->with('region', $region)
            ->with('region_id', $region_id)
            ->with('allowances', $allowances)
                // ->with('notices', $this->get_upsos( $upso_type_id, $region_ids, $show_order =1 , $search))
                // ->with('upsos_best', $this->get_upsos( $upso_type_id, $region_ids, $show_order =2 , $search))
                // ->with('upsos', $this->get_upsos( $upso_type_id, $region_ids, $show_order =3 , $search))
                // ->with('managers', $this->get_managers( $main_region_id, $region_id, $allow_id ))
            ->with('upso_types', $upso_types)
            ->with('upso_type', $this->get_upso_type($upso_type_id))
            ->with('upso_type_id', $upso_type_id)
            ->with('premia', $this->get_premia($upso_type_id))
            ->with('search', $search)
            ->with('colors', $this->colors)
            ->with('bg_colors', $this->bg_colors);
    }

    public function test(Manager $manager, Request $request)
    {
        $manager = Manager::where('id', $manager->id)
            ->with('upso')
            ->with('all_images')
            ->with('allowances')
            ->first();
        $manager->increment('visits');

        $upso_types = UpsoType::all();

        $upso_type_id = $request->upso_type_id;
        $main_region_id = $request->main_region_id;
        $region_id = $request->region_id;
        $allowances = $request->allowances;
        $search = $request->search;

        $region_ids = $this->get_region_ids($main_region_id, $region_id);
        if ($request->region_id) {
            $region = Region::find($request->region_id);
        } elseif ($request->main_region_id) {
            $region = Region::find($request->main_region_id);
        } else {
            $region = null;
        }

        return view('managers.show')
            ->with('manager', $manager)
            ->with('upso', $manager->upso)
            ->with('main_regions', $this->get_main_regions())
            ->with('main_region', $this->get_main_region($main_region_id, $region_id))
            ->with('sub_regions', $this->get_sub_regions($main_region_id))
            ->with('main_region_id', $main_region_id)
            ->with('region', $region)
            ->with('region_id', $region_id)
            ->with('allowances', $allowances)
                // ->with('notices', $this->get_upsos( $upso_type_id, $region_ids, $show_order =1 , $search))
                // ->with('upsos_best', $this->get_upsos( $upso_type_id, $region_ids, $show_order =2 , $search))
                // ->with('upsos', $this->get_upsos( $upso_type_id, $region_ids, $show_order =3 , $search))
                // ->with('managers', $this->get_managers( $main_region_id, $region_id, $allow_id ))
            ->with('upso_types', $upso_types)
            ->with('upso_type', $this->get_upso_type($upso_type_id))
            ->with('upso_type_id', $upso_type_id)
            ->with('premia', $this->get_premia($upso_type_id))
            ->with('search', $search);
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        // if( ! $user->isAdmin() ){
        if (!$user->upso) {
            return redirect()->route('upsos.create')->with('error', '매니저 등록을 위해서는 업소를 먼저 등록해야 합니다.');
        }

        if (!$this->checkPermission('create', $user->upso)) {
            return redirect()->back()->with('error', '권한이 없습니다.');
        }
        // }

        return view('managers.create', [
            // 'main_regions'=> $this->get_main_regions(),

        ]);
    }

    protected function ifExistPost($user)
    {
        $upsos = Upso::where('user_id', $user->id);
        if ($upsos->count() > 0) {
            return $upsos->first();
        }

        return false;
    }

    public function getPostBest($type, $post_cat_ids, $count)
    {
        if ($type == 'month') {
            $ago = Carbon::today()->subMonth()->toDateString();
        } elseif ($type == 'week') {
            $ago = Carbon::today()->subWeek()->toDateString();
        }

        $last = Carbon::today()->subDays(1)->toDateString();

        $cache_key = 'upso-logs-best-' . $count . '-' . $last . '-' . implode('-', $post_cat_ids);
        $logs = Cache::remember($cache_key, $this->seconds, function () use ($post_cat_ids, $ago, $last, $count) {
            return ClickLog::select('post_id')
                ->whereIn('post_cat_id', $post_cat_ids)
                ->whereBetween('click_date', [$ago,  $last])
                ->groupBy('post_id')
                ->orderByRaw('SUM(count) DESC')
                ->take($count)
                ->get();
        });

        // foreach($logs as $log){
        //     $count = ClickLog::where('post_id', $log->post_id)
        //                     ->whereBetween('click_date', [ $ago,  $last ])
        //                     ->sum('count');
        //     echo $log->post_id . " - " . $count ."\n<br>";
        // }

        $ids = $logs->pluck('post_id')->toArray();

        if (!$ids) {
            return collect([]);
        }

        $ids_ordered = implode(',', $ids);

        // $cache_key = 'posts-best-' . $count . '-' . $last . '-'.  implode( '-', $post_cat_ids);
        // $posts = Cache::remember($cache_key,  $this->seconds , function () use( $ids, $ids_ordered) {
        //     return Post::whereIn('id', $ids)
        //             ->with('post_cat')
        //             ->with('region')
        //             ->orderByRaw(\DB::raw("FIELD(id, $ids_ordered)"))
        //             ->get();
        // });

        $posts = Post::whereIn('id', $ids)
            ->with('post_cat')
            ->with('region')
            ->withCount('comments')
            ->orderByRaw(DB::raw("FIELD(id, $ids_ordered)"))
            ->get();

        return $posts;
    }

    public function get_best_upsos_count()
    {
        $key = 'general';
        $setting = Setting::where('key', $key)
            ->first();
        $data = unserialize($setting->value);
        $best_upsos_count = $data['best_upsos_count'] ?? 5;

        return (int) $best_upsos_count;
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

    protected function get_main_region($main_region_id, $region_id)
    {
        if ($main_region_id) {
            return Region::where('id', $main_region_id)->with('upsos')->get();
        }

        return null;
    }

    protected function get_sub_regions($main_region_id)
    {
        if ($main_region_id) {
            $sub_regions = Region::where('parent_id', $main_region_id)->get();
        } else {
            // $sub_regions = Region::whereNotNull( 'parent_id')->get();
            $sub_regions = null;
        }

        return $sub_regions;
    }

    protected function get_upsos($upso_type_id, $region_ids, $show_order, $search)
    {
        if ($show_order == 1) {
            $upsos = Upso::where('show_order', $show_order)
                ->paginate(100);
        } else {
            $upsos = Upso::when($upso_type_id, function ($query, $upso_type_id) {
                return $query->where('upso_type_id', $upso_type_id);
            })
                ->where('show_order', $show_order)
                ->when($region_ids, function ($query, $region_ids) {
                return $query->whereIn('region_id', $region_ids);
            })
                ->when($search, function ($query, $search): void {
                $query->where('title', $search);
            })->paginate();
        }

        return $upsos;
    }

    public function get_main_regions()
    {
        $main_regions = Region::whereNull('parent_id')->get();

        return $main_regions;
    }

    public function get_premia($upso_type_id)
    {
        // $premia = Premium::where('upso_type_id', $upso_type_id  )
        // ->get();
        $premia = Premium::take(4)->get();
        // dd($premia->toArray());
        return $premia;
    }

    public function get_upso_type($upso_type_id)
    {
        $upso_type = UpsoType::find($upso_type_id);

        return $upso_type;
    }

    protected function saveCache($upso): void
    {
        $cache_key = implode('.', ['upso', $upso->id]);
        Cache::forget($cache_key);
        $cache_key = 'upso-premia';
        Cache::forget($cache_key);

        // $key = 'new-post_cat-' . $this->post_cat_id ;
        // $seconds = 60 * 60 * 24 ;
        // Cache::put( $key , 'on' , $seconds);
    }

    protected function checkPermission($mode, $upso)
    {
        // dd( $upso->user_id);
        // dd( Auth::user()->nick);
        // dd($upso->user->nick);
        if (in_array($mode, ['create', 'edit', 'update', 'store'])) {
            if (Auth::user()->isAdmin() || Auth::user()->id == $upso->user_id) {
                return true;
            }
        }

        return false;
    }
}
