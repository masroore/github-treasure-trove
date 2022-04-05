<?php

namespace App\Http\Controllers;

use App\Models\Premium;
use App\Models\Region;
use App\Models\Upso;
use App\Models\UpsoType;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UpsoController extends Controller
{
    private $seconds;

    public function __construct()
    {
        $this->middleware(['auth', 'isDirector'])->only(['create', 'update', 'edit', 'store', 'destroy']);
    }

    public function destroy(Upso $upso, Request $request)
    {
        if (Auth::user()->isAdmin() || Auth::user()->id == $upso->user_id) {
            $upso1 = $upso;
            $upso->delete();
            $this->saveCache($upso1);

            return redirect()->route('upsos.index', [
                'upsp_type_id' => $request->upso_type_id,
                'main_region_id' => $request->main_region_id,
                'region_id' => $request->region_id,
            ]);
            // } elseif( Auth::user()->id == $upso->user_id )  {
        //     $msg = '삭제는 관리자만 가능합니다.';
        //     return redirect()->back()->with('error', $msg);
        }

        return redirect()->back()->with('error', '권한이 없습니다.');
    }

    public function edit(Upso $upso)
    {
        if ($upso->user_id == Auth::user()->id || Auth::user()->isAdmin()) {
            return view('upsos.edit')
                ->with('upso', $upso);
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
        $search = $request->search;

        $region_ids = $this->get_region_ids($main_region_id, $region_id);
        if ($request->region_id) {
            $region = Region::find($request->region_id);
        } elseif ($request->main_region_id) {
            $region = Region::find($request->main_region_id);
        } else {
            $region = null;
        }

        return view('upsos.index')
            ->with('main_regions', $this->get_main_regions())
            ->with('main_region', $this->get_main_region($main_region_id, $region_id))
            ->with('sub_regions', $this->get_sub_regions($main_region_id))
            ->with('main_region_id', $main_region_id)
            ->with('region', $region)
            ->with('region_id', $region_id)
            ->with('notices', $this->get_upsos($upso_type_id, $region_ids, $show_order = 1, $search))
            ->with('upsos_best', $this->get_upsos($upso_type_id, $region_ids, $show_order = 2, $search))
            ->with('upsos', $this->get_upsos($upso_type_id, $region_ids, $show_order = 3, $search))
            ->with('upso_types', $upso_types)
            ->with('upso_type', $this->get_upso_type($upso_type_id))
            ->with('upso_type_id', $upso_type_id)
                    // ->with('premia', $this->get_premia( $upso_type_id))
            ->with('search', $search)
            ->with('cat', 'upso');
    }

    public function show(Upso $upso, Request $request)
    {

        // dd($request->all());

        $upso = Upso::where('id', $upso->id)
            ->with('all_images')
            ->first();
        $upso->increment('visits');

        $upso_types = UpsoType::all();

        $upso_type_id = $request->upso_type_id;
        $main_region_id = $request->main_region_id;
        $region_id = $request->region_id;
        $search = $request->search;

        $region_ids = $this->get_region_ids($main_region_id, $region_id);
        if ($request->region_id) {
            $region = Region::find($request->region_id);
        } elseif ($request->main_region_id) {
            $region = Region::find($request->main_region_id);
        } else {
            $region = null;
        }

        // dd($upso_type_id);

        return view('upsos.show')
            ->with('upso', $upso)
            ->with('main_regions', $this->get_main_regions())
            ->with('main_region', $this->get_main_region($main_region_id, $region_id))
            ->with('sub_regions', $this->get_sub_regions($main_region_id))
            ->with('main_region_id', $main_region_id)
            ->with('region', $region)
            ->with('region_id', $region_id)
            ->with('notices', $this->get_upsos($upso_type_id, $region_ids, $show_order = 1, $search))
            ->with('upsos_best', $this->get_upsos($upso_type_id, $region_ids, $show_order = 2, $search))
            ->with('upsos', $this->get_upsos($upso_type_id, $region_ids, $show_order = 3, $search))
            ->with('upso_types', $upso_types)
            ->with('upso_type', $this->get_upso_type($upso_type_id))
            ->with('upso_type_id', $upso_type_id)
                // ->with('premia', $this->get_premia( $upso_type_id))
            ->with('search', $search);
    }

    public function create(Request $request)
    {

        // $main_region_id = $request->main_region_id;
        // $region_id = $request->region_id;
        // $main_regions = Region::whereNull( 'parent_id')->get();

        // $region_ids = $this->get_region_ids( $main_region_id, $region_id );

        // $main_region = $this->get_main_region( $main_region_id, $region_id );
        // $sub_regions = $this->get_sub_regions( $main_region_id, $region_id );

        if (Auth::user()->isAdmin()) {
        } else {
            $user_upso = $this->ifExistPost(Auth::user());
            if ($user_upso) {
                if (!Auth::user()->isAdmin()) {
                    $msg = '이미 업소정보가 존재하여 기존 업소 정보로 이동합니다.';

                    return redirect()
                        ->route('upsos.show', ['upso' => $user_upso])
                        ->with('error', $msg);
                }
            }
        }

        $upso_types = UpsoType::all();

        return view('upsos.create')
            ->with('main_regions', $this->get_main_regions())
            ->with('upso_types', $upso_types);
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
                ->inRandomOrder()
                ->get();
        } else {
            $upsos = Upso::when($upso_type_id, function ($query, $upso_type_id) {
                return $query->where('upso_type_id', $upso_type_id);
            })
                ->where('show_order', $show_order)
                ->when($region_ids, function ($query, $region_ids) {
                return $query->whereIn('region_id', $region_ids);
            })
                ->when($search, function ($query, $search) {
                return $query->where(function ($qq) use ($search): void {
                    $qq->where('site_name', 'like', '%' . $search . '%')
                        ->orWhere('title', 'like', '%' . $search . '%');
                });
            })
                ->inRandomOrder()
                ->get();
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
        // $cache_key = 'upso-premia';
        // Cache::forget($cache_key);

        // $key = 'new-post_cat-' . $this->post_cat_id ;
        // $seconds = 60 * 60 * 24 ;
        // Cache::put( $key , 'on' , $seconds);
    }
}
