<?php

namespace App\Observers;

use App\Models\Page;

class PageObserver
{
    /**
     * Handle the page "created" event.
     */
    public function created(Page $page): void
    {
        if ($source = $page->generateUrlSource()) {
            $page->urlAlias()->create([
                'alias' => $page->generateUrlAlias(),
                'source' => $source == '/' ? '/' : trim($source, '/'),
                'locale' => $page->locale,
                'locale_bound' => request('locale_bound'),
            ]);
        }
        if ($metaTags = $page->generateMetaTags()) {
            $page->metaTag()->create($metaTags);
        }
    }

    /**
     * Handle the page "updated" event.
     */
    public function updated(Page $page): void
    {

    }

    /**
     * Handle the page "deleted" event.
     */
    public function deleted(Page $page): void
    {
        $page->urlAliases()->delete();
        $page->metaTag()->delete();
    }

    /**
     * Handle the page "restored" event.
     */
    public function restored(Page $page): void
    {

    }

    /**
     * Handle the page "force deleted" event.
     */
    public function forceDeleted(Page $page): void
    {

    }
}
