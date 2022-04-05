<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Control\BannerRequest;
use App\Http\Requests\SyncRequest;
use App\Http\Resources\Control\BannerResource;
use App\Http\Resources\Control\LanguageResource;
use App\Models\Banner;
use Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BannerController extends Controller
{
    /**
     * @api {get} /api/v1/control/banners 01. Список банеров
     * @apiVersion 1.0.0
     * @apiName GetBanners
     * @apiGroup 32.Банеры
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=10] Количество элементов на странице
     * @apiParam {String} [_lang] Фильтрация по языку
     */
    public function index(Request $request)
    {
        $this->authorize('banner-manage');

        $items = Banner::orderByDesc('id')->byLangs()->with('media')->paginate($request->per_page);

        return BannerResource::collection($items);
    }

    /**
     * @api {get} /api/v1/control/banners/create 02. Создать баннер (форма)
     * @apiVersion 1.0.0
     * @apiName GetBannerCreate
     * @apiGroup 32.Банеры
     */
    public function create()
    {
        $this->authorize('banner-manage');

        return response()->json([
            'form' => $this->getFormAdditional(new Banner()),
        ]);
    }

    /**
     * @api {post} /api/v1/control/banners 03. Сохранить баннер
     * @apiVersion 1.0.0
     * @apiName PostBanner
     * @apiGroup 32.Банеры
     *
     * @apiParam {String} name Название
     * @apiParam {String} url URL ссылки
     * @apiParam {String=top,left,right,center,button} region Регион (позиция на странице)
     * @apiParam {Integer} weight Вес
     * @apiParam {String} lang Язык
     * @apiParam {String} target Target
     * @apiParam {Boolean} is_active Включить/Выключить
     *
     * @apiParam {Array} media_deleted ID удаления media
     * @apiParam {Array} image Изображение
     *
     * @apiParamExample {json} Request-Example:
     * "photo": {
     *        "id": null,
     *        "file": "<BINARY FILE>",
     *        "title": "File title",
     *        "alt": "File alt",
     *        "is_active": true,
     *        "is_main": true,
     *        "delete": false,
     * }
     */
    public function store(BannerRequest $request)
    {
        $this->authorize('banner-manage');

        /** @var Banner $banner */
        $banner = Banner::create($request->only('name', 'url', 'region', 'sub_region', 'weight', 'target', 'lang', 'is_active'));
        $banner->mediaManage($request);

        return response()
            ->json(['message' => trans('system.actions.store.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {get} /api/v1/control/banners/{bannerId}/edit 04. Редактировать баннер (форма)
     * @apiVersion 1.0.0
     * @apiName GetMenuItemEdit
     * @apiGroup 32.Банеры
     */
    public function edit(Banner $banner)
    {
        $this->authorize('banner-manage');

        return BannerResource::make($banner->load('media'))->additional([
            'form' => $this->getFormAdditional($banner),
        ]);
    }

    /**
     * @api {patch} /api/v1/control/banners/{bannerId} 05. Обновить баннер
     * @apiVersion 1.0.0
     * @apiName PatchBanner
     * @apiGroup 32.Банеры
     *
     * @apiParam {String} name Название
     * @apiParam {String} url URL ссылки
     * @apiParam {String=top,left,right,center,button} region Регион (позиция на странице)
     * @apiParam {Array} [image] Изображение
     * @apiParam {String} lang Язык
     * @apiParam {Boolean} is_active Включить/Выключить
     */
    public function update(BannerRequest $request, Banner $banner)
    {
        $this->authorize('banner-manage');

        $banner->update($request->only('name', 'url', 'region', 'sub_region', 'weight', 'target', 'lang', 'is_active'));
        $banner->mediaManage($request);

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_ACCEPTED);
    }

    /**
     * @api {post} /api/v1/control/banners/sync 06. Синхронизация записей
     * @apiVersion 1.0.0
     * @apiName PostBannersSync
     * @apiGroup 32.Банеры
     *
     * @apiDescription Метод позволяет масово изменять, добавлять, удалять записи.
     *
     * @apiParam {Array} [deleted] Массив ID-дов для удаления.
     * @apiParam {Array} [changed] Массив обьектов записей и их полей для изменения.
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *          "deleted": [4711, 234],
     *          "changed": [
     *           {
     *               "id": 13,
     *               "weight": 33
     *           },
     *           {
     *               "id": 14,
     *               "weight": 34
     *           }
     *          ]
     *     }
     */
    public function sync(SyncRequest $request)
    {
        $this->authorize('banner-manage');

        if ($request->deleted) {
            Banner::whereIn('id', $request->deleted)->delete();
        }

        if ($request->changed) {
            foreach ($request->changed as $item) {
                if (isset($item['id']) && ($model = Banner::find($item['id']))) {
                    $model->update(Arr::only($item, 'weight'));
                }
            }
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_OK);
    }

    protected function getFormAdditional(?Model $model = null): array
    {
        return [
            //'translations' => $model->getTranslationsList(),
            'regions' => Banner::regionList(),
            'sub_regions' => Banner::subRegionsList(),
            'languages' => LanguageResource::collection(get_languages()),
        ];
    }
}
