<?php

namespace App\Observers\Shop;

use App\Models\Shop\Sale;

class SaleObserver
{
    /**
     * Handle the product "created" event.
     *
     * @param  \App\Models\Shop\Product  $sale
     */
    public function created(Sale $sale): void
    {
        if ($source = $sale->generateUrlSource()) {
            $sale->urlAlias()->create([
                'alias' => $sale->generateUrlAlias(),
                'source' => $source == '/' ? '/' : trim($source, '/'),
                'locale' => $sale->locale,
                'locale_bound' => request('locale_bound'),
            ]);
        }

        if ($metaTags = $sale->generateMetaTags()) {
            $sale->metaTag()->create($metaTags);
        }
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Models\Shop\Product  $sale
     */
    public function updated(Sale $sale): void
    {

    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Models\Shop\Product  $sale
     */
    public function deleted(Sale $sale): void
    {
        $sale->urlAliases()->delete();
        $sale->metaTag()->delete();
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\Models\Shop\Product  $sale
     */
    public function restored(Sale $sale): void
    {

    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\Models\Shop\Product  $sale
     */
    public function forceDeleted(Sale $sale): void
    {

    }
}
