<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 27.01.19
 * Time: 11:51.
 */

namespace App\Http\View\FrontComposers;

use App\Models\Shop\Product;
use Cart;
use Illuminate\View\View;

class ShoppingCartComposer
{
    public function compose(View $view): void
    {
        $cartProducts = Product::whereIn('id', Cart::getIds())->with('values')->get();
        $productsCounts = Cart::get();

        $total = $cartProducts->map(function ($product) use ($productsCounts) {
            return $product->getCalculatePrice('price') * $productsCounts[$product->id]; // TODO currency
        })->sum();

        $view->with(compact('cartProducts', 'productsCounts', 'total'));
    }
}
