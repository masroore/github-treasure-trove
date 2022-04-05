<?php

namespace App\Http\Controllers\Front\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Shop\ProductReviewRequest;
use App\Models\Shop\Product;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::isPublish()->findOrFail($request->product_id);
        $reviews = $product->group->reviews;

        $html = view('front.products.inc.reviews', compact('reviews', 'product'))->render();
        if ($request->ajax()) {
            return response()->json([
                'html' => $html,
            ]);
        }

        return $html;
    }

    public function store(ProductReviewRequest $request)
    {
        Product::isPublish()->findOrFail($request->product_id)->reviews()->create([
            'name' => $request->name,
            'body' => $request->body,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'user_id' => $request->user()->id,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        return redirect()->back();
    }
}
