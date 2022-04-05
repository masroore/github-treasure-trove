<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        if (request('tag')) {
            $posts = Tag::where('name', request('tag'))->firstOrFail()->posts;
            $posts = $this->paginate($posts);
        } else {
            $posts = Post::with('category')->latest('updated_at')->paginate(7);
        }

        return view('index', compact('posts'));
    }

    /**
     * Paginate collections.
     *
     * @var array
     */
    public function paginate($items, $perPage = 7, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * @return Application|Factory|View
     */
    public function postsByCategory(Category $slug)
    {
        $posts = $slug->posts;

        return view('index', [
            'posts' => $this->paginate($posts), // Custom pagination with collection help from paginate() function
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function postsByAuthor(User $user)
    {
        $posts = $user->posts;

        return view('index', [
            'posts' => $this->paginate($posts, '7'), // Custom pagination with collection help from paginate() function
        ]);
    }

    public function searchItem()
    {
        // get the query string
        $query = request('search');
        // search in the mysql database and paginate latest
        $posts = Post::where('title', 'like', "%{$query}%")->latest()->paginate(5);
        // if result is empty, through an error or return response
        if ($posts->isEmpty()) {
            abort(404);
        } else {
            $posts = $posts->pluck('title', 'slug');
        }

        return response($posts);
    }
}
