<?php

namespace App\Repositories;

use App\Models\Post;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Cache;
use Modules\ClickLog\Entities\ClickLog;

class PostRepository
{
    public function all(): void
    {
    }

    public function getPostByCat($cat_id, $count)
    {
        return Post::where('cat_id', $cat_id)
            ->orderBy('created_at', 'desc')
            ->take($count)
            ->get();
    }

    public function clickPost($post_id, $cat_id)
    {
        $data = [
            'post_id' => $post_id,
            'cat_id' => $cat_id,
            'clcik_date' => date('Y-m-d'),
            'click_hour' => date('H'),
        ];

        return ClickLog::create(
            $data
        );
    }

    public function getPostBest($type, $cat_id)
    {
        $seconds = 30 * 60;

        if ($type == 'month') {
            $ago = Carbon::today()->subMonth();
        } elseif ($type == 'week') {
            $ago = Carbon::today()->subWeek();
        }
        // dd($ago);

        // $logs = ClickLog::where('cat_id', $cat_id)
        //         ->whereBetween('click_date', [ $ago,  Carbon::now()->toDateString()])
        //         ->orderBy('count', 'desc')
        //         ->take(10)
        //         ->get();
        // $posts = Post::whereIn( 'id', $logs->pluck('post_id')->all() )
        //         ->get();

        // $startDay = Carbon::now()->startOfDay();
        // $endDay   = $startDay->copy()->endOfDay();

        // $dt = Carbon::now();
        // $startDay = $dt->copy()->startOfDay();
        // $endDay = $dt->copy()->endOfDay() ;

        $posts = Cache::remember('posts-best-sub-' . $type . '-' . $cat_id, $seconds, function () use ($cat_id, $ago) {
            return Post::where('cat_id', $cat_id)
                ->whereBetween('created_at', [$ago->toDateTimeString(),  Carbon::now()->toDateTimeString()])
                ->get();
        });

        // $posts = Post::where('cat_id', $cat_id)
        //         ->whereBetween('created_at', [ $ago->toDateTimeString(),  Carbon::now()->toDateTimeString()])
        //         ->get();

        $logs = Cache::remember('logs-best-' . $type . '-' . $cat_id, $seconds, function () use ($posts, $ago) {
            return ClickLog::select('post_id')->whereIn('post_id', $posts->pluck('id')->all())
                ->whereBetween('click_date', [$ago->toDateString(),  Carbon::now()->toDateString()])
                ->groupBy('post_id')
                ->orderByRaw('SUM(count) DESC')
                ->take(10)
                ->get();
        });

        // $logs = ClickLog::select('post_id')->whereIn('post_id', $posts->pluck('id')->all())
        //         ->whereBetween('click_date', [ $ago->toDateString() ,  Carbon::now()->toDateString()])
        //         ->groupBy( 'post_id' )
        //         ->orderByRaw('SUM(count) DESC')
        //         ->take(10)
        //         ->get();

        $ids = $logs->pluck('post_id')->toArray();

        if (!$ids) {
            return collect([]);
        }

        $ids_ordered = implode(',', $ids);

        $posts = Cache::remember('posts1-best-' . $type . '-' . $cat_id, $seconds, function () use ($ids, $ids_ordered) {
            return Post::whereIn('id', $ids)
                ->orderByRaw(DB::raw("FIELD(id, $ids_ordered)"))
                ->get();
        });

        // $posts = Post::whereIn('id', $ids)
        //     ->orderByRaw(\DB::raw("FIELD(id, $ids_ordered)"))
        //     ->get();
        return $posts;
    }
}
