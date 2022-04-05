<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Control\PageRequest;
use App\Http\Requests\Control\SeoRequest;
use App\Http\Requests\SyncRequest;
use App\Http\Resources\Control\PageResource;
use App\Http\Resources\Control\SeoModelEditResource;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Variable;

class PageController extends Controller
{
    /**
     * @api {get} /api/v1/control/pages 01. Список
     * @apiVersion 1.0.0
     * @apiName GetPageIndex
     * @apiGroup 30.Страницы
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=10] Количество элементов на странице
     * @apiParam {String} [_lang] Фильтрация по языку
     */
    public function index(Request $request)
    {
        $this->authorize('page-manage');

        $pages = Page::orderByDesc('id')->byLangs()->paginate($request->per_page);

        return PageResource::collection($pages);
    }

    /**
     * @api {get} /api/v1/control/pages/create 02. Создать (форма)
     * @apiVersion 1.0.0
     * @apiName GetPageCreate
     * @apiGroup 30.Страницы
     */
    public function create()
    {
        $this->authorize('page-manage');

        return response()->json([
            'translations' => (new Page())->getTranslationsList(),
            //'tokens' => \Variable::getArray('seo_masks')['pages']['tokens'] ?? [],
        ]);
    }

    /**
     * @api {post} /api/v1/control/pages 03. Сохранить
     * @apiVersion 1.0.0
     * @apiName PostPageStore
     * @apiGroup 30.Страницы
     *
     * @apiParam {String} name Название
     * @apiParam {String} content Контент
     * @apiParam {String} slug Slug (**home** - для главной!)
     * @apiParam {String} lang Язык
     * @apiParam {String} [translation_uuid] UUID переводимой модели (для которой создаем перевод)
     */
    public function store(PageRequest $request)
    {
        $this->authorize('page-manage');

        $page = Page::create($request->only('name', 'slug', 'content', 'lang', 'translation_uuid'));

        if ($request->has('seo')) {
            $page->seo()->updateOrCreate([], $request->only('seo'));
        }

        return response()
            ->json(['message' => trans('system.actions.store.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {get} /api/v1/control/pages/{pageId}/edit 04. Редактировать (форма)
     * @apiVersion 1.0.0
     * @apiName GetPageEdit
     * @apiGroup 30.Страницы
     */
    public function edit(Page $page)
    {
        $this->authorize('page-manage');

        return (new PageResource($page->load('translations')))
            ->additional([
                'translations' => $page->getTranslationsList(),
            ]);
    }

    /**
     * @api {patch} /api/v1/control/pages/{pageId} 05. Обновить
     * @apiVersion 1.0.0
     * @apiName PatchPageUpdate
     * @apiGroup 30.Страницы
     *
     * @apiParam {String} name Название
     * @apiParam {String} content Контент
     * @apiParam {String} slug Slug (**home** - для главной!)
     */
    public function update(PageRequest $request, Page $page)
    {
        $this->authorize('page-manage');

        $page->update($request->only('name', 'slug', 'content'/*, 'lang'*/));

        if ($request->has('seo')) {
            $page->seo()->updateOrCreate([], $request->only('seo'));
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_ACCEPTED);
    }

    /**
     * @apiPrivate
     *
     * @api {delete} /api/v1/control/pages/{pageId} 06. Удалить
     * @apiVersion 1.0.0
     * @apiName DeletePage
     * @apiGroup 30.Страницы
     */
    public function destroy(Page $page)
    {
        $this->authorize('page-manage');

        $page->delete();

        return response()
            ->json(['message' => trans('system.actions.destroy.success')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/control/pages/sync 07. Синхронизация записей
     * @apiVersion 1.0.0
     * @apiName PostPageSync
     * @apiGroup 30.Страницы
     *
     * @apiDescription Метод позволяет масово изменять, добавлять, удалять записи.
     *
     * @apiParam {Array} [deleted] Массив ID-дов для удаления.
     * @apiParam {Array} [changed] Массив обьектов записей и их полей для изменения.
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *          "deleted": [4711, 234]
     *     }
     */
    public function sync(SyncRequest $request)
    {
        $this->authorize('page-manage');

        if ($request->deleted) {
            Page::whereIn('id', $request->deleted)->delete();
        }

        if ($request->changed) {
            foreach ($request->changed as $item) {
                if (isset($item['id']) && ($model = Page::find($item['id']))) {
                    //$model->update(\Arr::only($item, 'is_active'));
                }
            }
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], \Illuminate\Http\Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/control/pages/{pageId}/seo 08. Редактировать SEO (форма)
     * @apiVersion 1.0.0
     * @apiName GetPageSeoEdit
     * @apiGroup 30.Страницы
     */
    public function seoEdit(Page $page)
    {
        $this->authorize('page-manage');

        return (new SeoModelEditResource($page))
            ->additional([
                'form' => [
                    'tokens' => Variable::setLang($page->lang)->getArray('seo_masks')['pages']['tokens'] ?? [],
                ],
            ]);
    }

    /**
     * @api {post} /api/v1/control/pages/{pageId}/seo 09. Сохранить SEO
     * @apiVersion 1.0.0
     * @apiName PatchPageSeoSave
     * @apiGroup 30.Страницы
     *
     * @apiParam {String} [title] Title
     * @apiParam {String} [keywords] Keywords
     * @apiParam {String} [description] Description
     * @apiParam {String=index,noindex} [robots] Robots
     */
    public function seoSave(SeoRequest $request, Page $page)
    {
        $this->authorize('page-manage');

        $page->seo()->updateOrCreate([], $request->validated());

        return response()
            ->json(['message' => trans('system.actions.update.success')], \Illuminate\Http\Response::HTTP_OK);
    }
}
