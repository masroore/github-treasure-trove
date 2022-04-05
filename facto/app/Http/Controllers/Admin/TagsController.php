<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(Request $request): void
    {
        // $keyword = $request->get('search');
        // $perPage = 15;

        // if (!empty($keyword)) {
        //     $tags = Tag::where('name', 'LIKE', "%$keyword%")
        //             ->orWhere('label', 'LIKE', "%$keyword%")
        //             ->orderBy('created_at', 'desc')
        //             ->latest()
        //             ->paginate($perPage);
        // } else {
        //     $tags = Tag::where('cat_id', $cat_id)
        //             ->orderBy('created_at', 'desc')
        //             ->paginate($perPage);
        // }

        // return view('admin.posts.index', compact('tags', 'cats', 'cat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->name;
        $cat_id = $request->cat_id;

        $tag = Tag::firstOrCreate(
            [
                'cat_id' => $cat_id,
                'name' => $name,
            ]
        );

        return redirect('/admin/posts?cat_id=' . $cat_id)->with('success', '태그가 입력되었습니다.');

        // return redirect('admin.tags')->with('flash_message', 'Post added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $tag = Tag::findOrFail($id);

        return view('admin.posts.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $tags = Tag::select('id', 'name', 'label')->get()->pluck('label', 'name');

        return view('admin.posts.edit', compact('tag', 'tags'));
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

        $tag = Tag::findOrFail($id);
        $tag->update($request->all());
        $tag->tags()->detach();

        if ($request->has('tags')) {
            foreach ($request->tags as $tag_name) {
                $tag = Tag::whereName($tag_name)->first();
                $tag->attach($tag);
            }
        }

        return redirect('admin.tags')->with('flash_message', 'Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        Tag::destroy($id);

        return redirect('admin.tags')->with('flash_message', 'Post deleted!');
    }
}
