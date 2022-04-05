<?php

namespace App\Observers;

use App\Models\News;

class NewsObserver
{
    /**
     * Handle the page "created" event.
     */
    public function created(News $node): void
    {
        if ($source = $node->generateUrlSource()) {
            $node->urlAlias()->create([
                'alias' => $node->generateUrlAlias(),
                'source' => $source == '/' ? '/' : trim($source, '/'),
                'locale' => $node->locale,
                'locale_bound' => request('locale_bound'),
            ]);
        }
        if ($metaTags = $node->generateMetaTags()) {
            $node->metaTag()->create($metaTags);
        }
    }

    /**
     * Handle the page "updated" event.
     *
     * @param  \App\Models\Page  $page
     */
    public function updated(News $page): void
    {

    }

    /**
     * Handle the page "deleted" event.
     *
     * @param  \App\Models\Page  $page
     */
    public function deleted(News $page): void
    {
        $page->urlAliases()->delete();
        $page->metaTag()->delete();
    }

    /**
     * Handle the page "restored" event.
     *
     * @param  \App\Models\Page  $page
     */
    public function restored(News $page): void
    {

    }

    /**
     * Handle the page "force deleted" event.
     *
     * @param  \App\Models\Page  $page
     */
    public function forceDeleted(News $page): void
    {

    }
}
