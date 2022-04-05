<?php

namespace App\Observers;

use App\Models\Taxonomy\Term;

class TermObserver
{
    /**
     * Handle the term "created" event.
     */
    public function created(Term $term): void
    {
        if ($source = $term->generateUrlSource()) {
            $term->urlAlias()->create([
                'alias' => $term->generateUrlAlias(),
                'source' => $source == '/' ? '/' : trim($source, '/'),
                'locale' => $term->locale,
                'locale_bound' => request('locale_bound'),
            ]);
        }

        if (empty($term->system_name) && ($system_name = $term->generateSystemName())) {
            $term->setAttribute('system_name', $system_name);
            $term->save();
        }

        if ($metaTags = $term->generateMetaTags()) {
            $term->metaTag()->create($metaTags);
        }
    }

    /**
     * Handle the term "updated" event.
     */
    public function updated(Term $term): void
    {

    }

    /**
     * Handle the term "deleted" event.
     */
    public function deleted(Term $term): void
    {
        $term->urlAliases()->delete();
        $term->metaTag()->delete();
    }

    /**
     * Handle the term "restored" event.
     */
    public function restored(Term $term): void
    {

    }

    /**
     * Handle the term "force deleted" event.
     */
    public function forceDeleted(Term $term): void
    {

    }
}
