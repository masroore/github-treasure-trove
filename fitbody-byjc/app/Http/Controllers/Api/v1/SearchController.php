<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Front\Page;
use App\Models\Front\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $response = [];
        $products = Product::where('name', 'like', '%' . $request->input('term') . '%')->get();

        if ($products) {
            foreach ($products->take(5)->all() as $product) {
                $subcat_slug = $product->subcategory() ? $product->subcategory()->slug : 'null';
                $response['products'][] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'special' => $product->action ? $this->getActionPrice($product->price, $product->action) : $product->price,
                    'image' => asset($product->image),
                    'url' => Str::slug($product->clientAsArray()->name) . '/' . $product->category()->slug . '/' . $subcat_slug . '/' . $product->slug,
                ];
            }

            $response['text_view_all'] = 'Pogledajte sve rezultate.';
            $response['total'] = $products->count();
            $response['text_no_result'] = 'Nažalost! Nema rezultata prema vašoj pretrazi.';
        }

        return response()->json($response);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function all(Request $request)
    {
        if ($request->has('q')) {
            $pages = Page::search($request->input('q'))->orderBy('created_at', 'desc')->paginate(config('settings.pagination.items'));

            return view('front.page.search', compact('pages'));
        }

        $pages = Page::orderBy('created_at')->paginate(config('settings.pagination.items'));

        return view('front.page.search', compact('pages'));
    }

    /**
     * @param $price
     * @param $action
     *
     * @return string
     */
    private function getActionPrice($price, $action)
    {
        return number_format(($price - ($price * ($action->discount / 100))), 2);
    }
}
