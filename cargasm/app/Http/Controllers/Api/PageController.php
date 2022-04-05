<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageShowBySlugResource;
use App\Http\Resources\SeoModelResource;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * @api {get} /api/v1/page/{pageSlug} 01. Одна страница
     * @apiVersion 1.0.0
     * @apiName GetPageBySlug
     * @apiGroup 17.Страницы
     */
    public function show(string $slug)
    {
        $page = Page::byLang()
            ->whereSlug($slug)
            ->firstOrFail();

        return (new PageShowBySlugResource($page))
            ->additional([
                'seo' => new SeoModelResource($page),
                'translations' => $page->getTranslationsList(),
            ]);
    }
}
