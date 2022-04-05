<?php

namespace App\CentralLogics;

use App\Model\Category;
use App\Model\Product;

class category
{
    public static function parents()
    {
        return self::where('position', 0)->get();
    }

    public static function child($parent_id)
    {
        return self::where(['parent_id' => $parent_id])->get();
    }

    public static function products($category_id)
    {
        $products = Product::active()->get();
        $product_ids = [];
        foreach ($products as $product) {
            foreach (json_decode($product['category_ids'], true) as $category) {
                if ($category['id'] == $category_id) {
                    $product_ids[] = $product['id'];
                }
            }
        }

        return Product::with('rating')->whereIn('id', $product_ids)->get();
    }

    public static function all_products($id)
    {
        $cate_ids = [];
        $cate_ids[] = (int) $id;
        foreach (self::child($id) as $ch1) {
            $cate_ids[] = $ch1['id'];
            foreach (self::child($ch1['id']) as $ch2) {
                $cate_ids[] = $ch2['id'];
            }
        }

        $products = Product::active()->get();
        $product_ids = [];
        foreach ($products as $product) {
            foreach (json_decode($product['category_ids'], true) as $category) {
                if (\in_array($category['id'], $cate_ids)) {
                    $product_ids[] = $product['id'];
                }
            }
        }

        return Product::with('rating')->whereIn('id', $product_ids)->get();
    }
}
