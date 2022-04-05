<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use App\Models\Post;
use App\Models\Tag;
use File;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cat_id = $request->cat_id;
        if (!$cat_id) {
            $cat_id = 1;
        }
        $cat = Cat::find($cat_id);
        $types = ['gallery', 'list-password'];
        $cats = Cat::whereIn('type', $types)->get();

        $keyword = $request->get('search');
        $perPage = 15;

        $tags = Tag::where('cat_id', $cat_id)
            ->orderBy('name')
            ->get();

        if (!empty($keyword)) {
            $posts = Post::where('name', 'LIKE', "%$keyword%")
                ->orWhere('label', 'LIKE', "%$keyword%")
                ->orderBy('created_at', 'desc')
                ->latest()
                ->paginate($perPage);
        } else {
            $posts = Post::where('cat_id', $cat_id)
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc')
                ->paginate($perPage);
        }
        $posts->appends(request()->query());

        return view('admin.posts.index', compact('posts', 'cats', 'cat', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = ['gallery', 'list-password'];

        $cats = Cat::whereIn('type', $types)->get();

        return view('admin.posts.create', compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cat_id = $request->cat_id;
        $cat = Cat::find($cat_id);

        // $this->validate($request, ['name' => 'required']);

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $ext = File::extension($file->getClientOriginalName());

            $image = Image::make($file);
            $image->resize(200, 150);

            $ff = time() . '.' . $ext;

            $thumb_path = 'storage/upload/thumbs/' . $ff;
            $real_path = base_path() . '/storage/app/public/upload/thumbs/' . $ff;

            if ($file->getClientOriginalExtension() == 'gif') {
                // echo $file->getRealPath() ;
                $cc = copy($file->getRealPath(), $real_path);
                if (!$cc) {
                    return redirect()->back()->with('error', '이미지 저장에 실패했습니다. ');
                }
            } else {
                $cc = $image->save($real_path);
                if (!$cc) {
                    return redirect()->back()->with('error', '이미지 저장에 실패했습니다. ');
                }
            }

            $data['thumb_path'] = $thumb_path;
            $post = Post::create($data);

            $post->tags()->detach();

            if ($request->has('tags')) {
                foreach ($request->tags as $tag_name) {
                    $tag = Tag::whereName($tag_name)->first();
                    $post->tags()->attach($tag);
                }
            }
        } else {
            return redirect()->back()->with('error', '이미지 파일이 없습니다.');
        }

        return redirect('/admin/posts?cat_id=' . $cat_id)->with('flash_message', '글이 추가 되었습니다. ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('admin.posts.show', compact('Post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id): void
    {
        // $post = Post::findOrFail($id);
        // $tags = Tag::select('id', 'name', 'label')->get()->pluck('label', 'name');

        // return view('admin.posts.edit', compact('Post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $cat_id = $request->cat_id;
        $cat = Cat::find($cat_id);

        $this->validate($request, ['name' => 'required']);

        $post = Post::findOrFail($id);
        $post->update($request->all());
        $post->tags()->detach();

        if ($request->has('tags')) {
            foreach ($request->tags as $tag_name) {
                $tag = Tag::whereName($tag_name)->first();
                $post->attach($tag);
            }
        }

        return redirect('admin.posts')->with('flash_message', 'Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $cat_id = Post::find($id)->cat_id;
        Post::destroy($id);

        return redirect('/admin/posts?cat_id=' . $cat_id)->with('flash_message', '삭제되었습니다.');
    }
}
