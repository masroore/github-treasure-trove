<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 16.04.19
 * Time: 12:48.
 */

namespace App\Managers;

use Illuminate\Support\Facades\App;

class SitemapManager
{
    public function store(): void
    {
        $sitemap = App::make('sitemap');

        $tags = \Fomvasss\LaravelMetaTags\Models\MetaTag::orderByDesc('path')
            ->orderBy('updated_at')
            ->with('metatagable')->get();

        $defaultPriority = variable('sitemap_priority', 0.5);
        $defaultChangeFreq = variable('sitemap_changefreq', 'daily');

        foreach ($tags as $tag) {
            if ($path = $this->getPathEntity($tag)) {
                $sitemap->add(url($path), $tag->updated_at, $tag->priority ?: $defaultPriority, $tag->changefreq ?: $defaultChangeFreq);
            }
        }

        $sitemap->store('xml', 'sitemap');
    }

    protected function getPathEntity($tag)
    {
        if ($tag->robots && preg_match('/(noindex|nofollow|none)/', $tag->robots)) {
            return '';
        }

        if ($tag->path) {
            return $tag->path;
        }

        if ($tag->metatagable) {
            if ($urlAlias = $tag->metatagable->urlAlias) {
                return $urlAlias->alias;
            }
            if ($systemPath = $tag->metatagable->generateUrlSource()) { // TODO Check isset method generateUrlSource()
                return $systemPath;
            }
        }

        return '';
    }

    public function destroy()
    {
        if (file_exists(public_path('sitemap.xml'))) {
            return unlink(public_path('sitemap.xml'));
        }

        return false;
    }
}
