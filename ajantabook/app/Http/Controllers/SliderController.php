<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Slider;
use Illuminate\Http\Request;
use Image;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:sliders.manage']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::with(['childcategory', 'category', 'subcategory', 'products'])->get();

        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::all();
        $category = Category::all();

        return view('admin.slider.create', compact('product', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slider = new Slider();

        $request->validate([
            'image' => 'required | mimes:png,jpeg,jpg,gif,bmp| max:1000',
        ]);

        if ('cat' == $request->link_by) {
            $slider->category_id = $request->category_id;
        } elseif ('sub' == $request->link_by) {
            $slider->child = $request->subcat;
        } elseif ('url' == $request->link_by) {
            $slider->url = $request->url;
        } elseif ('child' == $request->link_by) {
            $slider->grand_id = $request->child;
        } elseif ('pro' == $request->link_by) {
            $slider->product_id = $request->pro;
        }
        $slider->link_by = $request->link_by;
        $slider->topheading = $request->heading;
        $slider->heading = $request->subheading;
        $slider->headingtextcolor = $request->headingtextcolor;
        $slider->subheadingcolor = $request->subheadingcolor;
        $slider->buttonname = $request->buttonname;
        $slider->moredesc = $request->moredesc;
        $slider->moredesccolor = $request->moredesccolor;
        $slider->btnbgcolor = $request->btnbgcolor;
        $slider->btntextcolor = $request->btntextcolor;

        if (isset($request->status)) {
            $slider->status = '1';
        } else {
            $slider->status = '0';
        }

        if ($file = $request->file('image')) {
            $optimizeImage = Image::make($file);

            $optimizePath = public_path() . '/images/slider/';

            $image = time() . $file->getClientOriginalName();

            $optimizeImage->fit(1247, 520, function ($constraint): void {
                $constraint->aspectRatio();
            });

            $optimizeImage->save($optimizePath . $image);

            $slider->image = $image;
        }

        $slider->save();

        return redirect()->route('slider.index')->with('added', __('Slider has been created !'));
    }

    public function show(Category $category): void
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::all();
        $slider = Slider::findOrFail($id);
        $product = Product::all();

        return view('admin.slider.edit', compact('slider', 'product', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::findorFail($id);

        $request->validate([
            'image' => 'mimes:png,jpeg,jpg,gif,bmp| max:1000',
        ]);

        if ('cat' == $request->link_by) {
            $slider->category_id = $request->category_id;
            $slider->child = null;
            $slider->url = null;
            $slider->grand_id = null;
            $slider->product_id = null;
        } elseif ('sub' == $request->link_by) {
            $slider->child = $request->subcat;
            $slider->category_id = null;
            $slider->url = null;
            $slider->grand_id = null;
            $slider->product_id = null;
        } elseif ('url' == $request->link_by) {
            $slider->url = $request->url;
            $slider->child = null;
            $slider->category_id = null;
            $slider->grand_id = null;
            $slider->product_id = null;
        } elseif ('child' == $request->link_by) {
            $slider->grand_id = $request->child;
            $slider->url = null;
            $slider->child = null;
            $slider->category_id = null;
            $slider->product_id = null;
        } elseif ('pro' == $request->link_by) {
            $slider->product_id = $request->pro;
            $slider->grand_id = null;
            $slider->url = null;
            $slider->child = null;
            $slider->category_id = null;
        } else {
            $slider->product_id = null;
            $slider->grand_id = null;
            $slider->url = null;
            $slider->child = null;
            $slider->category_id = null;
        }

        $slider->link_by = $request->link_by;
        $slider->topheading = $request->heading;
        $slider->heading = $request->subheading;
        $slider->headingtextcolor = $request->headingtextcolor;
        $slider->subheadingcolor = $request->subheadingcolor;
        $slider->buttonname = $request->buttonname;
        $slider->moredesc = $request->moredesc;
        $slider->moredesccolor = $request->moredesccolor;
        $slider->btnbgcolor = $request->btnbgcolor;
        $slider->btntextcolor = $request->btntextcolor;

        if (isset($request->status)) {
            $slider->status = '1';
        } else {
            $slider->status = '0';
        }

        if ($file = $request->file('image')) {
            if (file_exists(public_path() . '/images/slider/' . $slider->image)) {
                unlink('images/slider/' . $slider->image);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/slider/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->fit(1247, 520, function ($constraint): void {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image, 72);

            $slider->image = $image;
        }

        $slider->save();

        return redirect()->route('slider.index')->with('added', __('Slider has been updated !'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Slider::find($id);
        $value = $cat->delete();
        if ($value) {
            session()->flash('deleted', __('Slider has been deleted'));

            return redirect('admin/slider');
        }
    }
}
