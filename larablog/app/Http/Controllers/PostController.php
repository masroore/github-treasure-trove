<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use Mews\Purifier\Facades\Purifier;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        // Check PostPolicy if the user has permission to perform this task
        $this->authorize('viewAny', Post::class);

        // If logged user is admin or super admin
        if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin()) {
            $posts = Post::latest()->paginate(20);
        } else {
            // only authors posts
            $UserPosts = auth()->user()->posts;
            $posts = $this->paginate($UserPosts, '7');
        }

        return view('post.index', compact('posts'));
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
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        // Check PostPolicy if the user has permission to perform this task
        $this->authorize('create', Post::class);

        return view('post.write', [
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param
     *
     * @return RedirectResponse
     */
    public function store()
    {
        // Check PostPolicy if the user has permission to perform this task
        $this->authorize('create', Post::class);

        // Validate input data
        request()->validate([
            'title' => 'required|max:255|min:5|unique:posts,title',
            'category_id' => 'required| integer | min:1',
            'slug' => 'required|max:100|min:5|alpha_dash|unique:posts,slug',
            'post_img' => 'required | image | max:700',
            'details' => 'required|min:100',

        ]);

        // Create a new instance of Post model
        $insert_post = new Post();
        $insert_post->title = request('title');
        $insert_post->slug = request('slug');
        $insert_post->category_id = request('category_id');
        $insert_post->details = Purifier::clean(request('details'));
        $insert_post->user_id = Auth::id();
        $image = request()->file('post_img');

        if ($image) {
            $image_name = hexdec(uniqid()) . '.webp';                                                      // unique number with lowercase extension
            $upload_path = 'uploads/post_img/';                                                            // set the public path
            $img_url = $upload_path . $image_name;

            // resize image to new width but do not exceed original size
            $new_img = Image::make($image)->encode('webp', 70)->widen(800, function ($constraint): void {
                $constraint->upsize();
            });
            // save the new image with new name
            $success = $new_img->save($img_url);

            // Set thumbnail from main image
            $thumbnail_url = 'uploads/thumbnail/' . $image_name;
            // crop the best fitting
            Image::make($image)->encode('webp', 80)->fit(400, 250)->save($thumbnail_url);
            // if success set img url to database
            if ($success) {
                $insert_post->post_img = $img_url;
                $insert_post->thumbnail = $thumbnail_url;
            }
        }
        $insert_post->save();
        // add tags to post_tag pivot table after post stored to database
        $insert_post->tags()->sync(request()->tags, false);

        // If success then return with $notification message
        if ($insert_post) {
            $notification = [
                'message' => 'Successfully Posted',
                'alert-type' => 'success',
            ];

            return redirect()->route('post.index')->with($notification);
        }
        $notification = [
            'message' => 'Error Occurred!',
            'alert-type' => 'error',
        ];

        // Return to previews page
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function show(Post $post)
    {
        $previous = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();
        $next = Post::where('id', '>', $post->id)->orderBy('id')->first();

        return view('post.show', compact('post', 'previous', 'next'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(Post $post)
    {
        // Check PostPolicy if the user has permission to perform this task
        $this->authorize('update', $post);

        $categories = Category::all();
        $tags = Tag::all();

        return view('post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(Post $post)
    {
        // Check PostPolicy if the user has permission to perform this task
        $this->authorize('update', $post);

        // Validate input data
        request()->validate([
            'title' => 'required|max:255|min:5|unique:posts,title,' . $post->id,
            'slug' => 'required|max:100|min:5|alpha_dash|unique:posts,slug,' . $post->id,
            'category_id' => 'required| integer |min:1',
            'post_img' => 'image|max:1000',
            'details' => 'required |min:100',
        ]);

        $post->title = request('title');
        $post->slug = request('slug');
        $post->category_id = request('category_id');
        $post->details = Purifier::clean(request('details'));
        $post->user_id = Auth::id();
        $image = request()->file('post_img');
        if ($image) {
            $image_name = hexdec(uniqid()) . '.webp';  // unique number with lowercase extension
            $upload_path = 'uploads/post_img/';        // set the public path
            $img_url = $upload_path . $image_name;

            // resize image to new width but do not exceed original size
            $new_img = Image::make($image)->encode('webp', 70)->widen(800, function ($constraint): void {
                $constraint->upsize();
            });

            // save the new image with new name
            $success = $new_img->save($img_url);
            // Set thumbnail from main image
            $thumbnail_url = 'uploads/thumbnail/' . $image_name;
            // crop the best fitting
            Image::make($image)->encode('webp', 80)->fit(400, 250)->save($thumbnail_url);
            // if success delete old photos and set img url to database
            if ($success) {
                File::delete($post->post_img, $post->thumbnail);
                $post->post_img = $img_url;
                $post->thumbnail = $thumbnail_url;
            }
        }
        $post->save();
        // Check if tags has changed or not
        if (isset(request()->tags)) {
            $post->tags()->sync(request()->tags);
        } else {
            $post->tags()->sync([]);
        }
        // If success then return with $notification message
        if ($post) {
            $notification = [
                'message' => 'Successfully Updated',
                'alert-type' => 'success',
            ];

            return redirect()->route('post.index')->with($notification);
        }
        $notification = [
            'message' => 'Error Occurred!',
            'alert-type' => 'error',
        ];

        // Return to previews page
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function destroy(Post $post)
    {
        $post->tags()->detach();
        File::delete($post->thumbnail);
        File::delete($post->post_img);
        $post->delete();

        $notification = [
            'message' => 'Successfully Post Deleted',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
