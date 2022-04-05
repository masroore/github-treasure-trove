<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends Controller
{
    /**
     * TagController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Tag::class, 'tag');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('tags.store', [
            'tags' => Tag::paginate(20),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        Tag::create(request()->validate([
            'name' => 'required | string | max:20 | unique:tags',
        ]));
        $notification = [
            'message' => 'Congrats! New Tag added.',
            'alert-type' => 'success',
        ];

        // Return to previews page
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function show(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(Tag $tag)
    {
        request()->validate([
            'name' => 'required | string | max:20 | unique:tags',
        ]);

        $tag->name = request()->name;
        $tag->save();

        $notification = [
            'message' => 'Congrats! Tag updated.',
            'alert-type' => 'success',
        ];

        // Return to previews page
        return redirect()->route('tag.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function destroy(Tag $tag)
    {
        // Safely delete tags from post or detach
        $tag->posts()->detach();
        $tag->delete();

        $notification = [
            'message' => 'Congrats! Tag deleted.',
            'alert-type' => 'success',
        ];

        // Return to previews page
        return redirect()->back()->with($notification);
    }
}
