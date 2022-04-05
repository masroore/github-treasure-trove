<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Restricting certain functions to Auth Users only.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['bycategory']]);
    }

    /**
     * Display a listing of categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('category', 'desc')->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Create a new Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a new Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'category' => 'required',
            'active' => 'required',
        ]);

        $category = new Category();

        $category->category = $request->category;
        $category->type = 'SBJ';  //this is to avoid the db rejecting
        $category->active = $request->active;

        $category->save();

        return view('categories.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $attributes = request()->validate([
            'category' => 'required',
            'type' => '',
            'active' => 'required|in:1,0',
        ]);

        $category->update($attributes);

        return view('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category = Category::find($category->id);
        $category->delete();

        return redirect('category')->with('Success', 'Category has been deleted');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bycategory($id)
    {
        $cat = Category::findOrFail($id);

        $products = $cat->products;

        return view('homepages.home', compact('products', 'cat'));
    }
}
