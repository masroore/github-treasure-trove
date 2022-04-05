<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Post;
use App\Models\Tag;
use App\Repositories\PostRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\ClickLog\Entities\ClickLog;

class PostController extends Controller
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function list_test(Post $post, Request $request)
    {
        $perPage = 20;
        $cat_id = $request->cat_id;

        if ($request->has('tag_id')) {
            $tag_id = $request->tag_id;
        } else {
            $tag_id = -1;
        }

        if ($request->has('page')) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        $tag = Tag::find($tag_id);

        $cat = Cat::find($cat_id);
        $tags = Tag::where('cat_id', $cat_id)->get();

        if ($tag) {
            $posts = Post::where('cat_id', $cat_id)
                ->whereHas('tags', function ($query) use ($tag): void {
                $query->where('name', $tag->name);
            })
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        } else {
            $posts = Post::where('cat_id', $cat_id)
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        }

        $posts_month = $this->postRepository->getPostBest('month', $cat_id);
        $posts_week = $this->postRepository->getPostBest('week', $cat_id);

        $posts->appends(request()->query());

        return view('lists', compact('page', 'cat', 'posts', 'posts_week', 'posts_month', 'tags', 'tag'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 20;
        $cat_id = $request->cat_id;

        if ($request->has('tag_id')) {
            $tag_id = $request->tag_id;
        } else {
            $tag_id = -1;
        }

        $orderBy = $request->orderBy;
        $search = $request->search;
        $condition1 = $request->condition1;
        $condition2 = $request->condition2;

        if ($request->has('page')) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        $tag = Tag::find($tag_id);

        $cat = Cat::find($cat_id);
        $tags = Tag::where('cat_id', $cat_id)->get();

        // dd($tag);

        if ($tag) {
            $posts = Post::where('cat_id', $cat_id)
                ->whereHas('tags', function ($query) use ($tag): void {
                $query->where('name', $tag->name);
            })
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        } else {
            if ($orderBy == '' || $orderBy == 'created_at') {
                $posts = Post::where('cat_id', $cat_id)
                    ->when($search, function ($query) use ($search, $condition1, $condition2) {
                            if ($condition1 == 'title') {
                                return $query->where('title', 'like', '%' . $search . '%');
                            } elseif ($condition1 == 'content') {
                                return $query->where('content', 'like', '%' . $search . '%');
                            } elseif ($condition1 == 'all') {
                                if ($condition2 == 'and') {
                                    return $query->where('title', 'like', '%' . $search . '%')
                                        ->where('content', 'like', '%' . $search . '%');
                                } elseif ($condition2 == 'or') {
                                    return $query->where('title', 'like', '%' . $search . '%')
                                        ->orWhere('content', 'like', '%' . $search . '%');
                                }
                            }
                        })
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
            } elseif ($orderBy = 'visits') {
                $posts = Post::where('cat_id', $cat_id)
                    ->when($search, function ($query) use ($search, $condition1, $condition2) {
                            if ($condition1 == 'title') {
                                return $query->where('title', 'like', '%' . $search . '%');
                            } elseif ($condition1 == 'content') {
                                return $query->where('content', 'like', '%' . $search . '%');
                            } elseif ($condition1 == 'all') {
                                if ($condition2 == 'and') {
                                    return $query->where('title', 'like', '%' . $search . '%')
                                        ->where('content', 'like', '%' . $search . '%');
                                } elseif ($condition2 == 'or') {
                                    return $query->where('title', 'like', '%' . $search . '%')
                                        ->orWhere('content', 'like', '%' . $search . '%');
                                }
                            }
                        })
                    ->orderBy('visits', 'desc')
                    ->paginate($perPage);
            }
        }

        // dd($cat_id);
        $posts_month = $this->postRepository->getPostBest('month', $cat_id);
        $posts_week = $this->postRepository->getPostBest('week', $cat_id);

        // $posts->appends(request()->query());
        $posts->appends(['tag_id' => $tag_id, 'cat_id' => $cat_id, 'search' => $search])->links();

        return view('lists', compact('page', 'cat', 'posts', 'posts_week', 'posts_month', 'tags', 'tag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Request $request)
    {
        $post->increment('visits');

        $clicklog = ClickLog::where('cat_id', $post->cat->id)
            ->where('post_id', $post->id)
            ->where('click_date', Carbon::now()->toDateString())
            ->first();
        if ($clicklog) {
            $clicklog->increment('count');
        } else {
            ClickLog::create(
                [
                    'cat_id' => $post->cat->id,
                    'post_id' => $post->id,
                    'click_date' => Carbon::now()->toDateString(),
                    'count' => 1,
                ]
            );
        }

        $perPage = 20;
        $tags = Tag::where('cat_id', $post->cat_id)->get();
        if ($request->has('page')) {
            $page = $request->page;
        } else {
            $page = 1;
        }
        if ($request->has('tag_id')) {
            $tag_id = $request->tag_id;
        } else {
            $tag_id = -1;
        }
        $tag = Tag::find($tag_id);

        $orderBy = $request->orderBy;
        $search = $request->search;
        $condition1 = $request->condition1;
        $condition2 = $request->condition2;

        $posts_month = $this->postRepository->getPostBest('month', $post->cat->id);
        $posts_week = $this->postRepository->getPostBest('week', $post->cat->id);

        // if( $tag) {
        //     $posts = Post::where('cat_id',  $post->cat->id  )
        //     ->whereHas('tags', function($query) use ($tag) {
        //         $query->where('name', $tag->name);
        //     })
        //     ->orderBy('created_at', 'desc')
        //     ->paginate( $perPage);

        // } else {
        //     $posts = Post::where('cat_id',  $post->cat->id  )
        //     ->orderBy('created_at', 'desc')
        //     ->paginate( $perPage);
        // }

        $cat = $post->cat;
        $cat_id = $cat->id;

        if ($tag) {
            $posts = Post::where('cat_id', $cat_id)
                ->whereHas('tags', function ($query) use ($tag): void {
                $query->where('name', $tag->name);
            })
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        } else {
            if ($orderBy == '' || $orderBy == 'created_at') {
                $posts = Post::where('cat_id', $cat_id)
                    ->when($search, function ($query) use ($search, $condition1, $condition2) {
                            if ($condition1 == 'title') {
                                return $query->where('title', 'like', '%' . $search . '%');
                            } elseif ($condition1 == 'content') {
                                return $query->where('content', 'like', '%' . $search . '%');
                            } elseif ($condition1 == 'all') {
                                if ($condition2 == 'and') {
                                    return $query->where('title', 'like', '%' . $search . '%')
                                        ->where('content', 'like', '%' . $search . '%');
                                } elseif ($condition2 == 'or') {
                                    return $query->where('title', 'like', '%' . $search . '%')
                                        ->orWhere('content', 'like', '%' . $search . '%');
                                }
                            }
                        })
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
            } elseif ($orderBy = 'visits') {
                $posts = Post::where('cat_id', $cat_id)
                    ->when($search, function ($query) use ($search, $condition1, $condition2) {
                            if ($condition1 == 'title') {
                                return $query->where('title', 'like', '%' . $search . '%');
                            } elseif ($condition1 == 'content') {
                                return $query->where('content', 'like', '%' . $search . '%');
                            } elseif ($condition1 == 'all') {
                                if ($condition2 == 'and') {
                                    return $query->where('title', 'like', '%' . $search . '%')
                                        ->where('content', 'like', '%' . $search . '%');
                                } elseif ($condition2 == 'or') {
                                    return $query->where('title', 'like', '%' . $search . '%')
                                        ->orWhere('content', 'like', '%' . $search . '%');
                                }
                            }
                        })
                    ->orderBy('visits', 'desc')
                    ->paginate($perPage);
            }
        }

        // dd($page);

        return view('show', compact('page', 'posts', 'post', 'posts_week', 'posts_month', 'tags', 'tag', 'cat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

    }
}
