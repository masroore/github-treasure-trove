<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('publish_at', 'desc')->get();
        $cat = '';

        return view('homepages.home', compact('products', 'cat'));
    }

    /**
     * Display a listing of the products by status.
     *
     * @return \Illuminate\Http\Response
     */
    public function status($status)
    {
        $products = Product::OfStatus($status)->get();
        $cat = '';

        return view('homepages.home', compact('products', 'cat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assignedCats = [];

        return view('products.create', compact('assignedCats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->publish_at = new Carbon($request->get('publish_at'));
        $product = auth()->user()->products()->create($this->validateRequest());
        $product->categories()->sync($request->categories);

        return redirect($product->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findorFail($id);
        $images = $product->getMedia('photos');
        //   dd($images);

        $foundcats = $product->categories;
        $assignedCats = $product->categories->pluck('id')->toArray();
        //     dd($assignedCats);
        return view('products.product_detail', compact('product', 'images', 'foundcats'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // $this->authorize('manage', $product);

        $product = Product::findorFail($product->id);
        $assignedCats = $product->categories->pluck('id')->toArray();

        return view('products.edit', compact('product', 'assignedCats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->publish_at = new Carbon($request->get('publish_at'));
        $product->update($this->validateRequest());
        $product->categories()->sync($request->categories);

        return redirect($product->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

     //   $this->authorize('manage', $product);

        $product->delete();

        return redirect('/');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'featured_img' => '',
            'title' => 'required|min:4|max:124',
            'description' => 'required|min:10|max:500',
            'status' => 'required|in:For Sale,Not For Sale,Sold,',
            'price' => 'required',
            'discount' => 'required',
            'publish_at' => 'required|date',
        ]);
    }
}
