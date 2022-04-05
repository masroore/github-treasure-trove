<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeoModelResource;
use Variable;

class SeoController extends Controller
{
    /**
     * @api {get} /api/v1/seo/{type} 01. Получить СЕО-метатеги
     * @apiVersion 1.0.0
     * @apiName GetPageBySlug
     * @apiGroup 92.SEO
     *
     * @apiDescription Получить список метатегов для типа страницы.
     * Возможные типы:
     * <code>
     * home_page - главная,
     * news_list - список новостей,
     * blog_list - список статтей блога,
     * services_list - список СТО,
     * event_list - список Событий,
     * </code>
     */
    public function show(string $type)
    {
        $var = Variable::getArray('seo_masks', null, app()->getLocale())[$type] ?? [];

        return response()->json([
            'data' => SeoModelResource::prepareMetatags([
                'title' => $var['fields']['title'] ?? '',
                'description' => $var['fields']['description'] ?? '',
                'keywords' => $var['fields']['keywords'] ?? '',
                'robots' => 'index',
            ]),
        ]);
    }
}
