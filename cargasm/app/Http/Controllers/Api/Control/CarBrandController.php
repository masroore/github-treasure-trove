<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Control\SeoRequest;
use App\Http\Requests\SyncRequest;
use App\Http\Resources\Control\CarBrandResource;
use App\Http\Resources\Control\SeoModelEditResource;
use App\Models\CarModel;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Variable;

class CarBrandController extends Controller
{
    /**
     * @api {get} /api/v1/control/terms/brands 01. Марки (бренды)
     * @apiVersion 1.0.0
     * @apiName GetBrands
     * @apiGroup 33.Марки авто
     *
     * @apiParam {String} [q] Поисковый запрос
     * @apiParam {String=0,1} [with_models=1] Получать Марки->Модели
     * @apiParam {String=id,name} [sort=name] Поле для сортировки
     * @apiParam {String=desc,asc} [direction=asc] Направление сортировки
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=10] Количество элементов на странице
     */
    public function index(Request $request)
    {
        $this->authorize('term-manage');

        $brands = CarModel::whereIsRoot()
            ->searchable()
            ->when($request->get('with_models', 1), function ($q): void {
                $q->with('models');
            })->sortable(['name' => 'asc'])
            ->paginate($request->per_page);

        return CarBrandResource::collection($brands);
    }

    public function create(): void
    {

    }

    /**
     * @api {post} /api/v1/control/terms/brands 03. Сохранить
     * @apiVersion 1.0.0
     * @apiName PostBrandStore
     * @apiGroup 33.Марки авто
     *
     * @apiParam {String} name Название
     * @apiParam {Boolean} [status=true] Статус
     */
    public function store(Request $request)
    {
        $this->authorize('term-manage');

        /** @var CarModel $model */
        $model = CarModel::create($request->validate([
            'name' => 'required|string',
            'status' => 'sometimes|boolean',
        ]) + ['level' => 1]);
        $model->mediaManage($request);

        return response()
            ->json(['message' => trans('system.actions.store.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {get} /api/v1/control/terms/brands/{brandId}/edit 04. Редактировать
     * @apiVersion 1.0.0
     * @apiName GetBrandEdit
     * @apiGroup 33.Марки авто
     */
    public function edit(CarModel $model)
    {
        $this->authorize('term-manage');

        return CarBrandResource::make($model->load('media'));
    }

    /**
     * @api {patch} /api/v1/control/terms/brands/{brandId} 05. Обновить
     * @apiVersion 1.0.0
     * @apiName PatchBrandUpdate
     * @apiGroup 33.Марки авто
     *
     * @apiParam {String} name Название
     * @apiParam {Boolean} [status=true] Статус
     */
    public function update(Request $request, CarModel $model)
    {
        $this->authorize('term-manage');

        $model->update($request->validate([
            'name' => 'required|string',
            'status' => 'sometimes|boolean',
        ]));
        $model->mediaManage($request);

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_ACCEPTED);
    }

    /**
     * @api {delete} /api/v1/control/terms/brands/{brandId} 06. Удалить (марки, модель)
     * @apiVersion 1.0.0
     * @apiName DeleteBrandDestroy
     * @apiGroup 33.Марки авто
     */
    public function destroy(CarModel $model)
    {
        $this->authorize('term-manage');

        $model->delete();

        return response()
            ->json(['message' => trans('system.actions.destroy.success')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/terms/brands/sync 07. Синхронизация записей (марки, модели)
     * @apiVersion 1.0.0
     * @apiName PostBrandModelSync
     * @apiGroup 33.Марки авто
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
     *               "id": 231,
     *               "status": true
     *           },
     *           {
     *               "id": 453,
     *               "status": false
     *           }
     *          ]
     *     }
     */
    public function sync(SyncRequest $request)
    {
        $this->authorize('term-manage');

        if ($request->deleted) {
            CarModel::whereIn('id', $request->deleted)->delete();
        }

        if ($request->changed) {
            foreach ($request->changed as $item) {
                if (isset($item['id']) && ($model = CarModel::find($item['id']))) {
                    $model->update(Arr::only($item, 'status'));
                }
            }
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], \Illuminate\Http\Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/control/terms/brands/{brandId}/seo 10. Редактировать SEO (марки, модели - форма)
     * @apiVersion 1.0.0
     * @apiName GetBrandModelSeoEdit
     * @apiGroup 33.Марки авто
     */
    public function seoEdit(CarModel $model)
    {
        $this->authorize('term-manage');

        return (new SeoModelEditResource($model))
            ->additional([
                'form' => [
                    'tokens' => Variable::setLang('en')->getArray('seo_masks')['car_model']['tokens'] ?? [],
                ],
            ]);
    }

    /**
     * @api {post} /api/v1/control/terms/brands/{brandId}/seo 11. Сохранить SEO (марки, модели)
     * @apiVersion 1.0.0
     * @apiName PostBrandModelSeoEdit
     * @apiGroup 33.Марки авто
     *
     * @apiParam {String} [title] Title
     * @apiParam {String} [keywords] Keywords
     * @apiParam {String} [description] Description
     * @apiParam {String=index,noindex} [robots] Robots
     */
    public function seoSave(SeoRequest $request, CarModel $model)
    {
        $this->authorize('page-manage');

        $model->seo()->updateOrCreate([], $request->validated());

        return response()
            ->json(['message' => trans('system.actions.update.success')], \Illuminate\Http\Response::HTTP_OK);
    }
}
