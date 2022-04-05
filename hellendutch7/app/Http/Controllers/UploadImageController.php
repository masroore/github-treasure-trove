<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UploadImageController extends Controller
{
    /**
     * Restricting certain functions to Auth Users only.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function load($product_id)
    {
        return view('images.upload', compact('product_id'));
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,png,jpg,JPG|max:12000',
        ]);

        $product = Product::find($request->product_id);

        $product->addMediaFromRequest('image')
            ->toMediaCollection('photos', 's3');

        return redirect('/product/' . $request->product_id);
    }

    public function delete($aid, $id)
    {
        $mediaitem = Media::find($id)->delete();

        return redirect('/product/' . $aid);
    }

    public function featured($aid, $id)
    {
        $product = Product::find($aid);
        $product->featured_img = Media::find($id)->getUrl();

        $product->save();

        return redirect('/product/' . $aid);
    }

    // Show a media Item
    public function show($id)
    {
        $image = Media::find($id);

        return view('images.show', compact('image'));
    }
}
