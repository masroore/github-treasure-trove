<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use View;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        // dd($categories);
        return View::make('admin.categories-list')->with([
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('admin.category-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->category_name = $request->input('category_name');
        $category->slug = Str::slug($request->category_name, '-');
        $cat_icon = $request->file('cat_icon');
        if ('' != $cat_icon) {
            $filename = $cat_icon->getClientOriginalName();
            $imagename = 'cat-' . mt_rand(000000, 999999) . '.' . $cat_icon->getClientOriginalExtension();
            $extension = $cat_icon->getClientOriginalExtension();
            // $imagename= $filename;
            $destinationpath = public_path('assets/images/categories/');
            $cat_icon->move($destinationpath, $imagename);
            $category->cat_icon = $imagename;
        }

        $category->cat_desc = $request->input('cat_desc');

        if ($category->save()) {
            return response()->json(['status' => 'true', 'message' => 'Category added successfully'], 200);
        }

        return response()->json(['status' => 'errorr', 'message' => 'error occured please try again'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getSingleData = Category::find($id);

        return View::make('admin.category-update', compact('getSingleData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $findData = Category::find($id);
        $findData->category_name = $request->input('category_name');
        $category->slug = $request->input('slug');
        $cat_icon = $request->file('cat_icon');
        if ('' != $cat_icon) {
            $filename = $cat_icon->getClientOriginalName();
            $imagename = 'cat-' . mt_rand(000000, 999999) . '.' . $cat_icon->getClientOriginalExtension();
            $extension = $cat_icon->getClientOriginalExtension();
            // $imagename= $filename;
            $destinationpath = public_path('assets/images/categories/');
            $cat_icon->move($destinationpath, $imagename);
            $findData->cat_icon = $imagename;
        }

        $findData->cat_desc = $request->input('cat_desc');

        if ($findData->save()) {
            return response()->json(['status' => 'true', 'message' => 'Category updated successfully'], 200);
        }

        return response()->json(['status' => 'errorr', 'message' => 'error occured please try again'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteData = Category::find($id);
        if ($deleteData->delete()) {
            return response()->json(['status' => 'true', 'message' => 'Category deleted successfully'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'error occured please try again'], 200);
    }
}
