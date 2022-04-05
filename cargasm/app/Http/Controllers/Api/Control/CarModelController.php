<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarModelRequest;
use App\Http\Resources\Control\CarModelResource;
use App\Http\Resources\Control\MediaResource;
use App\Http\Resources\Media;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CarModelController extends Controller
{
    /**
     * @api {get} /api/v1/control/terms/models/create 4. Создать
     * @apiVersion 1.0.0
     * @apiName GetModelCreate
     * @apiGroup 34.Модели авто
     */
    public function create()
    {
        return response()->json([
            'form' => $this->getFormAdditional(),
        ]);
    }

    /**
     * @api {post} /api/v1/control/terms/models 3. Сохранить
     * @apiVersion 1.0.0
     * @apiName PostModelStore
     * @apiGroup 34.Модели авто
     *
     * @apiParam {String} name Название модели
     * @apiParam {Integer} parent_id ID марки авто
     * @apiParam {Integer} production_start ID марки
     * @apiParam {Integer} production_end ID марки
     * @apiParam {Boolean} [status=1] Статус
     *
     * @apiParamExample {json} Request-Example:
     * "photo": {
     *        "id": null,
     *        "file": "<BINARY FILE>",
     *        "title": "File title",
     *        "alt": "File alt",
     *        "is_active": true,
     *        "is_main": false,
     *        "delete": false,
     * }
     */
    public function store(CarModelRequest $request)
    {
        $this->authorize('term-manage');

        /** @var CarModel $model */
        $model = CarModel::create($request->validated() + ['level' => 2]);
        $model->mediaManage($request);

        return response()
            ->json(['message' => trans('system.actions.store.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {get} /api/v1/control/terms/models/{modelId}/edit 4. Редактировать
     * @apiVersion 1.0.0
     * @apiName GetModelEdit
     * @apiGroup 34.Модели авто
     */
    public function edit(CarModel $model)
    {
        $this->authorize('term-manage');

        return CarModelResource::make($model->load('parent', 'media'))
            ->additional([
                'form' => $this->getFormAdditional(),
            ]);
    }

    /**
     * @api {patch} /api/v1/control/terms/models/{modelId} 5. Обновить
     * @apiVersion 1.0.0
     * @apiName PatchModelUpdate
     * @apiGroup 34.Модели авто
     *
     * @apiParam {String} name Название модели
     * @apiParam {Integer} parent_id ID марки авто
     * @apiParam {Integer} production_start ID марки
     * @apiParam {Integer} production_end ID марки
     * @apiParam {Boolean} [status=1] Статус
     */
    public function update(CarModelRequest $request, CarModel $model)
    {
        $this->authorize('term-manage');

        $model->update($request->validated());
        $model->mediaManage($request);

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_ACCEPTED);
    }

    protected function getFormAdditional(): array
    {
        return [
            'production_periods' => array_map(function ($item) {
                return (string) $item;
            }, range(1930, now()->year)),
        ];
    }

    /**
     * @api {get} /api/v1/control/terms/models/{modelId}/media 08. Редактировать Media (модели - форма)
     * @apiVersion 1.0.0
     * @apiName GetModelImagesEdit
     * @apiGroup 34.Модели авто
     */
    public function mediaEdit(CarModel $model)
    {
        return MediaResource::collection($model->media);

        if ($media = $model->getFirstMedia('photos')) {
            return new Media($media);
        }

        return response()->json([
            'data' => [
                //'id' => null,
            ],
        ]);
    }

    /**
     * @api {post} /api/v1/control/terms/models/{modelId}/media 09. Загрузить Media (модели)
     * @apiVersion 1.0.0
     * @apiName PostModelImagesEdit
     * @apiGroup 34.Модели авто
     *
     * @apiParam {Array} photos Изображения
     *
     * @apiParamExample {json} Request-Example:
     * "photos": {
     *    {
     *        id: null,
     *        file: "<BINARY FILE>",
     *        title: "File title",
     *        alt: "File alt",
     *        is_active: true,
     *        is_main: false,
     *        delete: false,
     *    },
     *    {
     *        id: 1234,
     *        file: "<BINARY FILE>",
     *        title: "File title",
     *        alt: "File alt",
     *        is_active: true,
     *        is_main: true,
     *        delete: false,
     *    }
     * }
     */
    public function mediaSave(Request $request, CarModel $model)
    {
        $this->authorize('term-manage');

//        $request->validate([
//            'photo.file' => 'nullable|required|image',
//        ]);

        $model->mediaManage($request);

        return response()
            ->json(['message' => trans('system.actions.update.success')], \Illuminate\Http\Response::HTTP_OK);
    }
}
