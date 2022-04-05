<?php

namespace Modules\AdminApi\Http\Controllers\v1;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use Modules\AdminApi\Http\Controllers\BaseController;

class FilterController extends BaseController
{
    public function allProducts()
    {
        $show = request()->show ?? 12;
        $categories = request()->category ?? [];
        $price = json_decode(request()->price, true);
        $cardType = request()->cardType;
        $filterName = request()->sorting ? explode('_', request()->sorting)[0] : null;
        $filterOrder = request()->sorting ? explode('_', request()->sorting)[1] : null;
        $product = ProductCategory::whereIn('category_id', $categories)->pluck('product_id')->toArray();
        $uniqueProductId = array_unique($product);
        $products = Product::where('status', '1')
            ->when(\count($categories) > 0, function ($query) use ($uniqueProductId) {
                return $query->whereIn('id', $uniqueProductId);
            })
                        // ->when($price, function ($query, $price) {
                        //     $minPrice = $price['minPrice']??0;
                        //     $maxPrice = $price['maxPrice']??200;
                        //     return $query->whereBetween('base_price', [(float)$minPrice, (float)$maxPrice]);
                        // })
                        // ->when($cardType, function ($query, $cardType) {
                        //     return $query->where('card_type', $cardType);
                        // })
            ->when('price' == $filterName, function ($query) use ($filterOrder) {
                return $query->orderBy('base_price', $filterOrder);
            })
            ->when('alpha' == $filterName, function ($query) use ($filterOrder) {
                return $query->orderBy('name', $filterOrder);
            })
            ->with('options', 'options.option', 'options.optionValues')
            ->paginate($show);

        foreach ($products as $p) {
            $p->setAttribute('image_path', URL('/') . '/images/products/');

            if ('1' == $p->status) {
                $p->status = 'Active';
            } else {
                $p->status = 'Inactive';
            }
            if ('1' == $p->is_featured) {
                $p->is_featured = 'Featured';
            } else {
                $p->is_featured = 'Not-Featured';
            }
            if ('1' == $p->show_on_homepage) {
                $p->show_on_homepage = 'Show';
            } else {
                $p->show_on_homepage = 'Dont Show';
            }
            if ('1' == $p->trending) {
                $p->trending = 'Yes';
            } else {
                $p->trending = 'No';
            }
            if ($p->options) {
                foreach ($p->options as $option) {
                    $option->setAttribute('option_id', $option->id);
                    $option->setAttribute('option_name', $option->option->name);
                    $option->setAttribute('option_type', $option->option->type);

                    if (\count($option->optionValues) > 0) {
                        foreach ($option->optionValues as $optionvalue) {
                            $optionvalue->setAttribute('value', $optionvalue->optionValue->name);
                            $optionvalue->setAttribute('image_path', URL('/') . '/images/products/' . $optionvalue->thumbnail);
                        }
                    }
                }
            }
        }

        return $this->success($products);
    }

    public function Categories()
    {
        $categories = Category::whereNull('category_id')->select('id', 'name', 'category_id')->withCount('products')->with(['categories' => function ($category) {
            $category->select('id', 'name', 'category_id');

            return $category->withCount('products');
        }, 'categories.categories' => function ($childcategory) {
            $childcategory->select('id', 'name', 'category_id');

            return $childcategory->withCount('products');
        }])
            ->get();

        return $this->success($categories);
    }
}
