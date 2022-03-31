<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Category;
use App\Models\Back\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = Category::getMenu(true);
        $groups = Category::active()->groupBy('group')->pluck('group', 'id');

        if ($request->has('group')) {
            $categories = collect($category['admin_list'])->where('group', $request->input('group'));
        } else {
            $categories = $category['admin_list'];
        }

        return view('back.category.index', compact('categories', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::parents();
        $groups = Category::active()->clearSinglePages()->groupBy('group')->pluck('group', 'id');

        return view('back.category.edit', compact('parents', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        $category = Category::store($request);

        Cache::forget('cats');

        if ($category) {
            if ($request->hasFile('image')) {
                $path = Photo::imageUpload($request->file('image'), $category, 'category');

                Category::updateImagePath($category, $path);
            }

            return redirect()->route('categories')->with(['success' => 'Category was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the category.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $parents = Category::parents();
        $groups = Category::active()->groupBy('group')->pluck('group', 'id');

        return view('back.category.edit', compact('category', 'parents', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required']);

        $updated = Category::edit($request, $category);

        Cache::forget('cats');

        if ($updated) {
            if ($request->hasFile('image')) {
                $path = Photo::imageUpload($request->file('image'), $updated, 'category');

                Category::updateImagePath($updated, $path);
            }

            return redirect()->route('categories')->with(['success' => 'Category was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the category.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (isset($request['data']['id'])) {
            Cache::forget('cats');

            return response()->json(
                Category::withSubDestroy($request['data']['id'])
            );
        }
    }
}
