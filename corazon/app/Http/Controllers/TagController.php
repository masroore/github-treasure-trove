<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = Tag::all();

        return view('tag.index', compact('tags'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('tag.create');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(TagStoreRequest $request)
    {
        $tag = Tag::create($request->validated());

        $request->session()->flash('tag.id', $tag->id);

        return redirect()->route('tag.index');
    }

    /**
     * @param \App\Tag $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Tag $tag)
    {
        return view('tag.show', compact('tag'));
    }

    /**
     * @param \App\Tag $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Tag $tag)
    {
        return view('tag.edit', compact('tag'));
    }

    /**
     * @param \App\Tag $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, Tag $tag)
    {
        $tag->update($request->validated());

        $request->session()->flash('tag.id', $tag->id);

        return redirect()->route('tag.index');
    }

    /**
     * @param \App\Tag $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Tag $tag)
    {
        $tag->delete();

        return redirect()->route('tag.index');
    }
}
