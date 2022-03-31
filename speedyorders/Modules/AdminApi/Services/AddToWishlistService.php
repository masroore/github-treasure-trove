<?php

namespace Modules\AdminApi\Services;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\Wishlist;
use App\Models\wishlistProductOption;
use Illuminate\Support\Facades\DB;

class AddToWishlistService
{
    public function handle($request)
    {
        $customer_id = $request->user()->id;
        $options = [];
        $optionsLength = 0;

        if (isset($request->options) && \count($request->options) > 0) {
            foreach ($request->options as $option_id => $option_value) {
                $product_option = ProductOption::where('id', $option_id)->first();

                $product_option_type = $product_option->option->type;

                if ('select' == $product_option_type) {
                    $options[$option_id] = $option_value;
                }
            }

            $optionsLength = \count($options);
        }

        if ($this->checkProductAlredyExistInWishlist($request, $customer_id, $options, $optionsLength)) {
            return response()->json([
                'status'=>200,
                'msg'   => 'Product Already Exist In Your Wishlist !',
            ]);
        }

        try {
            DB::beginTransaction();

            $product = Product::where('status', '1')->where('id', $request->product_id)->with('options')->first();

            if ($product) {
                $wishlist = Wishlist::create([
                        'customer_id' => $customer_id,
                        'product_id' => $product->id,
                        ]);

                if (isset($request->options) && \count($request->options) > 0) {
                    foreach ($request->options as $option_id => $option_value) {
                        $product_option = ProductOption::where('id', $option_id)->first();

                        $product_option_type = $product_option->option->type;

                        wishlistProductOption::create([
                                    'wishlist_id'               => $wishlist->id,
                                    'product_option_id'         => $option_id,
                                    'product_option_value_id'   => ('select' == $product_option_type) ? $option_value : null,
                                    'product_option_value'      => ('select' == $product_option_type) ? null : $option_value,

                                    ]);
                    }
                }
                DB::commit();

                return response()->json([
                                'status'=>200,
                                'msg'   => 'Product Added To Your Wishlist !',
                            ]);
            }

            return response()->json([
                            'status'=>200,
                            'msg'   => 'Product Not Found !',
                        ]);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();

            return response()->json([
                            'status'=>200,
                            'msg'   => 'Something Went Wrong !',
                        ]);
        }
    }

    private function checkProductAlredyExistInWishlist($request, $customer_id, $options, $optionsLength)
    {
        $isExist = false;
        $newProduct = $request->product_id;

        $newOptions = $request->options ?? [];
        $productExist = Wishlist::where('customer_id', $customer_id)->where('product_id', $newProduct)->with('wishlistProductOption')->get();

        if (\count($newOptions) > 0) {
            foreach ($productExist as $p_exist) {
                $oldWishListOptions = [];

                if ($p_exist->wishlistProductOption) {
                    foreach ($p_exist->wishlistProductOption as $oldOption) {
                        if ('select' == $oldOption->productOption->option->type) {
                            $oldWishListOptions[$oldOption->product_option_id] = $oldOption->product_option_value_id;
                        }
                    }
                }
                if (\count(array_intersect($options, $oldWishListOptions)) == $optionsLength) {
                    $isExist = true;
                }
            }
        } else {
            if (\count($productExist) > 0) {
                $isExist = true;
            }
        }

        return $isExist;
    }
}
