<?php

namespace Modules\AdminApi\Http\Controllers\v1;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use App\Models\ProductOption;
use App\Models\ProductQuestion;
use App\Models\ProductQuestionAnswer;
use App\Models\ProductRelatedProduct;
use App\Models\Review;
use Modules\AdminApi\Http\Controllers\BaseController;

class ProductController extends BaseController
{
    public function featuredProduct()
    {
        $products = Product::query();
        $featuredProducts = $products->where('status', 1)->where('is_featured', 1)->select('name', 'description', 'image', 'id')->limit(8)->get();

        return $this->success($featuredProducts);
    }

    public function topRatedProduct()
    {
        $productsSortedId = Review::where('status', 1)  //get product id in ascending order according to the sum of rating grouped by product id
            ->select('product_id')
            ->selectRaw('SUM(rating) as rating')
            ->orderByDesc('rating')
            ->groupby('product_id')
            ->limit(20)
            ->get()
            ->pluck('product_id');

        $products = Product::query();
        $topRatedProducts = $products->whereIn('id', $productsSortedId)
            ->where('status', 1)
            ->select('name', 'description', 'image', 'id', 'category_id', 'uuid')
            ->with('options:id,product_id,option_id', 'options.option:id,name,type')
            ->limit(8)
            ->get();

        return $this->success($topRatedProducts);
    }

    public function trendingProduct()
    {
        $products = Product::query();
        $trendingProducts = $products->where('status', 1)->where('trending', 1)->select('name', 'description', 'image', 'id')->limit(8)->get();

        return $this->success($trendingProducts);
    }

    public function getProductGeneral($id)
    {
        $product = Product::where('id', $id)->where('status', 1)->select(['id', 'sku', 'name', 'length', 'breadth', 'height', 'width', 'description', 'base_price', 'quantity', 'image', 'video', 'meta_title', 'meta_description'])->with('galleries')->first();
        $product['image'] = $product['image'];
        $product['image_path'] = URL('/') . '/images/products/';

        return $this->success($product);
    }

    public function getProductGallery($id)
    {
        $fullImageUrl = [];
        $productGalleries = ProductGallery::where('product_id', $id)->orderByDesc('order')->select('image')->get();
        foreach ($productGalleries as $productGallery) {
            $fullImageUrl[] = \URL::full() . $productGallery->image;
        }

        return $this->success($fullImageUrl);
    }

    public function getProductCategory($id)
    {
        $productCategoryIds = ProductCategory::where('product_id', $id)->where('status', 1)->pluck('category_id');
        $categoryDetails = Category::whereIn('id', $productCategoryIds)->select(['uuid', 'name', 'slug', 'image', 'description'])->get();

        return $this->success($categoryDetails);
    }

    public function getProductOptionValue($id)
    {
        $productOptions = ProductOption::where('product_id', $id)->with('optionValues')->get();

        $productOptionValuesArray = [];
        $productOptionArray = [];

        foreach ($productOptions as $productOption) {
            $productOptionArray = [
                'option_id'=>$productOption->id,
                'option_type'=>$productOption->option->type,
                'option_name'=>$productOption->option->name,
            ];
            $optionValuesArray = [];
            foreach ($productOption->optionValues as $optionValue) {
                $optionValuesArray[] =
                [
                    'value'=>$optionValue->optionValue->name,
                    'quantity'=>$optionValue->quantity,
                    'price'=>$optionValue->price,
                    'option_value_id'=>$optionValue->id,
                    'price_prefix'=>$optionValue->price_prefix,
                    'thumbnail'=>$optionValue->thumbnail,
                ];
            }
            $productOptionArray['option_values'] = $optionValuesArray;
            $productOptionValuesArray[] = $productOptionArray;
        }

        return $this->success($productOptionValuesArray);
    }

    public function getProductQuestionAnswer($id)
    {
        $productQuestionIds = ProductQuestion::where('product_id', $id)->pluck('id');
        $productQuestionAnswer = ProductQuestionAnswer::whereIn('product_question_id', $productQuestionIds)->select(['id', 'uuid', 'product_question_id', 'answer', 'status'])->with('productQuestion:uuid,name,description,email')->get()->makeHidden(['id', 'status', 'product_question_id']);

        return $this->success($productQuestionAnswer);
    }

    public function getRelatedProducts($id)
    {
        $relatedProductsIds = ProductRelatedProduct::where('product_id', $id)->pluck('related_product_id');
        $relatedProducts = Product::whereIn('id', $relatedProductsIds)->select('image', 'base_price', 'description')->get();

        return $this->success($relatedProducts);
    }
}
