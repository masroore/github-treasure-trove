<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Request $request)
    {
    }

    public function index($category_slug = '')
    {
        $activePage = 'store';
        $categories_list = Category::with('categories')->where('category_id', 0)->get();

        $filter_category_id = '';
        if (isset($category_slug) && '' != $category_slug) {
            $filter_category_id = Category::where('slug', $category_slug)->pluck('id')->first();
        }

        $products = Product::leftjoin('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->with('options')->with('delivery_time');

        if ($filter_category_id && '' != $filter_category_id) {
            $products = $products->where('product_categories.category_id', $filter_category_id);
        }

        $products = $products->select('products.id', 'products.name', 'products.slug', 'products.sku', 'products.base_price', 'products.sale_price', 'products.image', 'products.description', 'products.status', 'products.return_policy_days');
        $products = $products->orderByDesc('id')
            ->paginate(30);

        return view('store.index', compact('categories_list', 'products', 'activePage', 'filter_category_id'));
    }

    public function getCategories()
    {
        $activePage = 'categories';
        $homepage_categories = Category::where('show_on_homepage', 1)->get();

        return view('categories', compact('activePage', 'homepage_categories'));
    }

    public function searchProducts(Request $request)
    {
        $keyword = $request->keyword;
        $top_filter_category = $request->top_filter_category;
        $products = ProductCategory::leftjoin('products', 'products.id', '=', 'product_categories.product_id')
                            //->where('product_categories.category_id', $top_filter_category)
            ->where('products.name', 'LIKE', '%' . $keyword . '%')
            ->select(['products.name', 'products.id', 'products.slug'])
            ->limit(10)
            ->get();

        $html = "<ul id='product-list'>";

        foreach ($products as $product) {
            $product_name = $product->name;
            $product_slug = $product->slug;
            $product_id = $product->id;
            $html .= "<li class='cat-products' id='p_slug_" . $product_id . "' data-product-slug='" . $product_slug . "'><a id='product_name_" . $product_id . "' href='javascript:void(0)' onClick='selectProduct(" . $product_id . ")' >" . $product_name . '</a></li>';
        }
        $html .= '</ul>';

        return $html;
    }

    public function getProducts($category_slug = '')
    {
        $activePage = 'products';
        if (isset($category_slug) && '' != $category_slug) {
            $category_id = Category::where('slug', $category_slug)->pluck('id')->first();
        }
        $products = Product::leftjoin('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->with('options')
            ->with('delivery_time')
            ->select('products.id', 'products.name', 'products.slug', 'products.sku', 'products.base_price', 'products.sale_price', 'products.image', 'products.quantity', 'products.description', 'products.status', 'products.return_policy_days');
        if ($category_id && '' != $category_id) {
            $products = $products->where('product_categories.category_id', $category_id);
        }

        $products = $products->orderByDesc('id')->paginate(6);

        return view('product-listing', compact('products', 'activePage'));
    }

    public function getProductDetails(Request $request, $slug = '')
    {
        if ('' == $slug) {
            return redirect('/store');
        }

        $activePage = 'categories';
        $category_name = '';
        $productdetails = Product::with('options', 'delivery_time', 'categories', 'galleries')->where('slug', 'LIKE', $slug)->first();

        if (isset($productdetails->categories) && \count($productdetails->categories) > 0) {
            $product_category = $productdetails->categories->first();
            $product_category_id = $product_category->category_id;

            if ($product_category_id) {
                $category_data = Category::find($product_category_id);
                $category_name = (isset($category_data->name)) ? $category_data->name : '';
            }
        }

        return view('product_detail', compact('productdetails', 'activePage', 'category_name'));
    }
}
