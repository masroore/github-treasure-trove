<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Request $request)
    {
    }

    public function index()
    {
        $activePage = 'categories';

        $products = Product::with('options')->with('delivery_time')->select('products.id', 'products.name', 'products.sku', 'products.base_price', 'products.sale_price', 'products.image', 'products.quantity', 'products.description', 'products.status', 'products.return_policy_days')
            ->orderByDesc('id')
            ->paginate(6);

        return view('index', compact('products', 'activePage'));
    }
}
