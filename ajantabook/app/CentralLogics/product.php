<?php

namespace App\CentralLogics;

use App\Model\Product;
use App\Model\Review;

class product
{
    public static function get_product($id)
    {
        return self::active()->with(['rating'])->where('id', $id)->first();
    }

    public static function get_latest_products($limit = 10, $offset = 1)
    {
        $paginator = self::active()->with(['rating'])->latest()->paginate($limit, ['*'], 'page', $offset);
        // $paginator->count();
        return [
            'total_size' => $paginator->total(),
            'limit' => $limit,
            'offset' => $offset,
            'products' => $paginator->items(),
        ];
    }

    public static function get_related_products($product_id)
    {
        $product = self::find($product_id);

        return self::active()->with(['rating'])->where('category_ids', $product->category_ids)
            ->where('id', '!=', $product->id)
            ->limit(10)
            ->get();
    }

    public static function search_products($name, $limit = 10, $offset = 1)
    {
        $key = explode(' ', $name);
        $paginator = self::active()->with(['rating'])->where(function ($q) use ($key): void {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->paginate($limit, ['*'], 'page', $offset);

        return [
            'total_size' => $paginator->total(),
            'limit' => $limit,
            'offset' => $offset,
            'products' => $paginator->items(),
        ];
    }

    public static function get_product_review($id)
    {
        return Review::where('product_id', $id)->get();
    }

    public static function get_rating($reviews)
    {
        $rating5 = 0;
        $rating4 = 0;
        $rating3 = 0;
        $rating2 = 0;
        $rating1 = 0;
        foreach ($reviews as $key => $review) {
            if (5 == $review->rating) {
                ++$rating5;
            }
            if (4 == $review->rating) {
                ++$rating4;
            }
            if (3 == $review->rating) {
                ++$rating3;
            }
            if (2 == $review->rating) {
                ++$rating2;
            }
            if (1 == $review->rating) {
                ++$rating1;
            }
        }

        return [$rating5, $rating4, $rating3, $rating2, $rating1];
    }

    public static function get_overall_rating($reviews)
    {
        $totalRating = \count($reviews);
        $rating = 0;
        foreach ($reviews as $key => $review) {
            $rating += $review->rating;
        }
        if (0 == $totalRating) {
            $overallRating = 0;
        } else {
            $overallRating = number_format($rating / $totalRating, 2);
        }

        return [$overallRating, $totalRating];
    }
}
