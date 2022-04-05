<?php

namespace App\Http\Controllers;

use App\Product;
use App\SimpleProduct;
use Illuminate\Http\Request;

class CashbackController extends Controller
{
    public function save(Request $request, $id)
    {
        if ('simple_product' == $request->product_type) {
            $product = SimpleProduct::findorfail($id);

            $product->cashback_settings()->updateOrCreate([
                'simple_product_id' => $id,
            ], [
                'cashback_type' => $request->cashback_type,
                'discount_type' => $request->discount_type,
                'discount' => $request->discount,
                'enable' => $request->enable ? 1 : 0,
            ]);
        }

        if ('variant_product' == $request->product_type) {
            $product = Product::findorfail($id);

            $product->cashback_settings()->updateOrCreate([
                'product_id' => $id,
            ], [
                'cashback_type' => $request->cashback_type,
                'discount_type' => $request->discount_type,
                'discount' => $request->discount,
                'enable' => $request->enable ? 1 : 0,
            ]);
        }

        notify()->success(__('Cashback settings updated !'), __('Success'));

        return back();
    }

    public function apply($id, $amount, $type = 'simple_product')
    {
        if ('simple_product' == $type) {
            $product = SimpleProduct::findorfail($id);
        } else {
            $product = Product::findorfail($id);
        }

        $cashback = $product->cashback_settings;

        if ('per' == $cashback->cashback_type) {
            if ('upto' == $cashback->discount_type) {
                $random_no = mt_rand(0, $cashback->discount);
                $cb = $amount * $random_no / 100;
            }

            if ('flat' == $cashback->discount_type) {
                $cb = $amount * $cashback->discount / 100;
            }
        }

        if ('fix' == $cashback->cashback_type) {
            if ('upto' == $cashback->discount_type) {
                $random_no = mt_rand(0, $cashback->discount);
                $cb = $random_no;
            }

            if ('flat' == $cashback->discount_type) {
                $cb = $cashback->discount;
            }
        }

        return $cb;
    }
}
