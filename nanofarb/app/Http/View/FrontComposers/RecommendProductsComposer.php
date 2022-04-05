<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 27.01.19
 * Time: 11:51.
 */

namespace App\Http\View\FrontComposers;

use Cache;
use Illuminate\View\View;

class RecommendProductsComposer
{
    public function compose(View $view): void
    {
        $recommend_products = Cache::remember(serialize(variable('recommend_products', '[]')), 10, function () {
            return \App\Models\Shop\Product::with('media', 'reviews', 'group.product.media', 'urlAlias')
                ->isPublish()->whereIn('id', json_decode(variable('home_page_bestsellers', '[]')))->get();
        });

        $view->with(compact('recommend_products'));
    }
}
