<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Resources\Control\LanguageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Variable;

class VariableController extends Controller
{
    /**
     * @apiPrivate
     *
     * @api {get} /api/v1/control/variables/list 01. Список переменных
     * @apiVersion 1.0.0
     * @apiName GetVariablesList
     * @apiGroup 89.Переменные
     */
    public function list()
    {
        return response()->json([
            'vars' => Variable::useCache(false)->all()->mapWithKeys(function ($item) {
                return [$item->key => $item->value];
            }),
        ]);
    }

    /**
     * @apiPrivate
     *
     * @api {get} /api/v1/control/variables/{key} 02. Одна переменная
     * @apiVersion 1.0.0
     * @apiName GetVariableShow
     * @apiGroup 89.Переменные
     */
    public function show($key)
    {
        return response()->json([
            'var' => Variable::get($key),
        ]);
    }

    /**
     * @apiPrivate
     *
     * @api {post} /api/v1/control/variables 03. Сохранить переменые и их значения
     * @apiVersion 1.0.0
     * @apiName PostVariablesSave
     * @apiGroup 89.Переменные
     *
     * @apiParam {Array} vars Массив имен ключей и их значений
     * @apiParam(vars) {String} site_name Название сайта
     * @apiParam(vars) {String} site_phone Телефон сайта
     * @apiParam(vars) {String} site_description Описание сайта
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "vars": {
     *          "site_name":"Example Site Name",
     *          "site_phone": "71234567890"
     *       }
     *     }
     */
    public function save(Request $request)
    {
        $this->validate($request, [
            'vars' => 'array',
            //'vars.*' => 'nullable|string',
            'vars_array' => 'array',
            'vars_file.*' => 'file',
        ]);

        foreach ($request->get('vars', []) as $key => $value) {
            Variable::save($key, $value);
        }

        foreach ($request->get('vars_array', []) as $key => $value) {
            Variable::saveArray($key, $value);
        }

//        \Cache::forget('laravel.variables.cache');
//        \Artisan::call('config:clear');

        return response()
            ->json(['message' => trans('system.actions.store.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {get} /api/v1/control/variables/seo-masks/form 01. Получить переменные SEO-маски
     * @apiVersion 1.0.0
     * @apiName GetSeoMasks
     * @apiGroup 89.Переменные
     *
     * @apiParam {String} [_lang] Фильтрация по языку
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "var": {
     *
     *       }
     *     }
     */
    public function editSeoMasks(Request $request)
    {
        //$this->authorize('variable-manage');

        $var = Variable::setLang($request->_lang)->getArray('seo_masks');

        $var = array_merge([
            'home_page' => [
                'title' => 'Главная страница',
                'fields' => [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ],
                'tokens' => [
                ],
            ],

            'pages' => [
                'title' => 'Страница (Одна)',
                'fields' => [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ],
                'tokens' => [
                    '[node:name]' => 'Значения поля Name',
                    '[node:content]' => 'Значения поля Content',
                    '[node:lang]' => 'Значения поля Lang',
                ],
            ],

            'news_list' => [
                'title' => 'Новости (Список)',
                'fields' => [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ],
                'tokens' => [
                ],
            ],

            'news' => [
                'title' => 'Новость (Одна)',
                'fields' => [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ],
                'tokens' => [
                    '[node:title]' => 'Значения поля Title',
                    '[node:text]' => 'Значения поля Text',
                    '[node:lang]' => 'Значения поля Lang',
                ],
            ],

            'blog_list' => [
                'title' => 'Статьи (Список)',
                'fields' => [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ],
                'tokens' => [
                ],
            ],

            'blog' => [
                'title' => 'Статья (Одна)',
                'fields' => [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ],
                'tokens' => [
                    '[node:title]' => 'Значения поля Title',
                    '[node:text]' => 'Значения поля Text',
                    '[node:lang]' => 'Значения поля Lang',
                ],
            ],

            'services_list' => [
                'title' => 'СТО (Список)',
                'fields' => [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ],
                'tokens' => [
                ],
            ],
            'services' => [
                'title' => 'СТО (Одна)',
                'fields' => [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ],
                'tokens' => [
                    '[node:name]' => 'Значения поля Name',
                    '[node:descr]' => 'Значения поля Descr',
                    '[node:lang]' => 'Значения поля Lang',
                ],
            ],

            'event_list' => [
                'title' => 'События (Список)',
                'fields' => [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ],
                'tokens' => [
                ],
            ],
            'event' => [
                'title' => 'Событие (Одна)',
                'fields' => [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ],
                'tokens' => [
                    '[node:title]' => 'Значения поля Name',
                    '[node:descr]' => 'Значения поля Descr',
                    '[node:lang]' => 'Значения поля Lang',
                    '[node:place]' => 'Значения поля Place',
                ],
            ],

            'car_model' => [
                'title' => 'Модель авто (Одна)',
                'fields' => [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ],
                'tokens' => [
                    '[node:name]' => 'Значения поля Name',
                ],
            ],

            'cars' => [
                'title' => 'Авто (Одна)',
                'fields' => [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ],
                'tokens' => [
                    '[node:brand:name]' => 'Значения поля Brand Name',
                    '[node:model:name]' => 'Значения поля Model Name',
                    '[node:descr]' => 'Значения поля Descr',
                ],
            ],
        ], $var);

        return response()->json([
            'var' => $var,
            'lang' => $request->_lang,
            'languages' => LanguageResource::collection(get_languages()),
        ]);
    }

    /**
     * @api {post} /api/v1/control/variables/seo-masks/form 02. Сохранить переменные SEO-маски
     * @apiVersion 1.0.0
     * @apiName PostSeoMasks
     * @apiGroup 89.Переменные
     *
     * @apiParam {Array} var Массив переменных SEO-масок
     * @apiParam {String} [lang] Язык переменных
     */
    public function saveSeoMasks(Request $request)
    {
        //$this->authorize('variable-manage');
        $request->validate([
            'var' => 'nullable|array',
            'var.*.description' => 'max:160',
        ]);

        Variable::saveArray('seo_masks', $request->var, $request->lang);

        return response()
            ->json(['message' => trans('system.actions.store.success')], Response::HTTP_CREATED);
    }
}
