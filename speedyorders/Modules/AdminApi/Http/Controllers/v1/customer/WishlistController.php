<?php

namespace Modules\AdminApi\Http\Controllers\v1\customer;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Modules\AdminApi\Http\Controllers\BaseController;
use Modules\AdminApi\Services\AddToWishlistService;

class WishlistController extends BaseController
{
    public function addToWishList(Request $request, AddToWishlistService $service)
    {
        return $service->handle($request);
    }

    public function getCustomerWishlist()
    {
        $customer_id = request()->user()->id;
        $wishlists = Wishlist::where('customer_id', $customer_id)->with('wishlistProductOption')->get();
        $res = [];
        if ($wishlists) {
            foreach ($wishlists as $w_product) {
                $product['product_name'] = $w_product->product->name;
                $options = [];
                if ($w_product->wishlistProductOption) {
                    foreach ($w_product->wishlistProductOption as $option) {
                        $wishlist['option'] = $option->productOption->option->name;
                        $wishlist['option_type'] = $option->productOption->option->type;
                        $wishlist['option_value'] = ('select' == $option->productOption->option->type) ? $option->productOptionValue->optionValue->name : $option->product_option_value;
                        $options[] = $wishlist;
                    }

                    $product['options'] = $options;

                    $res[] = $product;
                }
            }
        }

        return $this->success($res);
    }
}
