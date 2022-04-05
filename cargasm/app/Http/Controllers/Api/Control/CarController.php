<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Control\CarRequest;
use App\Http\Requests\Control\SeoRequest;
use App\Http\Requests\SyncRequest;
use App\Http\Resources\Control\CarResource;
use App\Http\Resources\Control\MediaResource;
use App\Http\Resources\Control\SeoModelEditResource;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Variable;

class CarController extends Controller
{
    /**
     * @api {get} /api/v1/control/cars 01. Список
     * @apiVersion 1.0.0
     * @apiName GetCarIndex
     * @apiGroup 39.Авто
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page] Количество элементов на странице
     * @apiParam {String=id,created_at} [sort=created_at] Поле для сортировки
     * @apiParam {String=asc,desc} [direction=desc] Направление сортировки
     *
     * @apiParam {String} [q] Поисковый запрос
     *
     * @apiParam {Array} [f] Поля для фильтрации. См. ниже:
     * @apiParam(f) {Integer} [user_id] Партнер, создавшый запись
     */
    public function index(Request $request)
    {
        $this->authorize('car-manage');

        $cars = Car::sortable('created_at')
            ->filterable()
            ->searchable()
            ->with('media')
            ->paginate($request->per_page);

        $url = config('services.cars.urlService') . 'models';

        $response = Http::withHeaders([
            'Auth-token' => config('services.cars.serviceToken'),
        ])->acceptJson()->get($url, [
            'ids' => $cars->pluck('model_id')->toArray(),
        ]);

        $data = $response->json();

        CarResource::setModels($data['data'] ?? []);

        return CarResource::collection($cars)
            ->additional([
                'form' => $this->getFormAdditional(),
            ]);
    }

    /**
     * @api {get} /api/v1/control/cars/create 02. Создать
     * @apiVersion 1.0.0
     * @apiName GetCarCreate
     * @apiGroup 39.Авто
     */
    public function create()
    {
        return response()->json([
            //'form' => $this->getFormAdditional(),
        ]);
    }

    /**
     * @api {post} /api/v1/control/cars 03. Сохранить
     * @apiVersion 1.0.0
     * @apiName PostCarStore
     * @apiGroup 39.Авто
     *
     * @apiParam {Int} user_id ID пользователя
     * @apiParam {Int} mark_id ID бренда
     * @apiParam {Int} model_id ID модели
     * @apiParam {String} descr Описание авто
     * @apiParam {String} status Статус авто
     * @apiParam {String} vin VIN код авто
     * @apiParam {Boolean} is_active Активный/Не активный
     * @apiParam {Boolean} is_sitemap Добавлять на карту сайта
     */
    public function store(CarRequest $request)
    {
        $this->authorize('car-manage');

        /** @var Car $car */
        $car = Car::create([
            'name' => $request->name,
            'model_id' => $request->model_id,
            'mark_id' => $request->mark_id,
            'descr' => $request->descr,
            'vin' => $request->vin,
            'year' => $request->year,
            'is_homemade' => $request->boolean('is_homemade'),
            'status' => $request->status,
            'user_id' => $request->user_id,
        ]);

        if ($request->hasFile('main_photo.file')) {
            $car->addMedia($request->main_photo['file'])->toMediaCollection('image');
        }
        if ($request->photos) {
            foreach ($request->file('photos', []) as $file) {
                $car->mediaSave($file, 'images');
            }
        }

        return response()
            ->json(['message' => trans('system.actions.store.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {post} /api/v1/control/cars/{carId}/edit 04. Редактировать
     * @apiVersion 1.0.0
     * @apiName GetCarEdit
     * @apiGroup 39.Авто
     */
    public function edit(Car $car)
    {
        $url = config('services.cars.urlService') . 'models';
        $response = Http::withHeaders([
            'Auth-token' => config('services.cars.serviceToken'),
        ])->acceptJson()->get($url, [
            'ids' => $car->model_id,
        ]);

        $data = $response->json();

        CarResource::setModels($data['data'] ?? []);

        return CarResource::make($car->load('media', 'user'))->additional([
            'form' => $this->getFormAdditional(),
        ]);
    }

    /**
     * @api {patch} /api/v1/control/cars/{carId} 05. Обновить
     * @apiVersion 1.0.0
     * @apiName PatchCarUpdate
     * @apiGroup 39.Авто
     */
    public function update(CarRequest $request, Car $car)
    {
        $this->authorize('car-manage');

        $car->update([
            'name' => $request->name,
            'mark_id' => $request->mark_id,
            'model_id' => $request->model_id,
            'descr' => $request->descr,
            'vin' => $request->vin,
            'year' => $request->year,
            'is_homemade' => $request->boolean('is_homemade'),
            'status' => $request->status,
        ]);

        if ($request->hasFile('main_photo.file')) {
            $car->clearMediaCollection('image');
            $car->addMedia($request->main_photo['file'])->toMediaCollection('image');
        }
        if ($request->photos) {
            foreach ($request->file('photos', []) as $file) {
                $car->mediaSave($file, 'images');
            }
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_ACCEPTED);
    }

    /**
     * @api {patch} /api/v1/control/cars/{carId} 06. Удалить
     * @apiVersion 1.0.0
     * @apiName DeleteCarDestroy
     * @apiGroup 39.Авто
     */
    public function destroy(Car $car)
    {
        $this->authorize('car-manage');

        $car->clearMediaCollection('image');
        $car->clearMediaCollection('images');
        Storage::delete($car->main_photo);
        Storage::delete($car->photos);
        $car->delete();

        return response()
            ->json(['message' => trans('system.actions.destroy.success')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/control/cars/sync 07. Синхронизация записей
     * @apiVersion 1.0.0
     * @apiName PostPostSync
     * @apiGroup 39.Авто
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
        $this->authorize('car-manage');

        if ($request->deleted) {
            Car::whereIn('id', $request->deleted)->delete();
        }

        if ($request->changed) {
            foreach ($request->changed as $item) {
                if (isset($item['id']) && ($model = Car::find($item['id']))) {
                    //$model->update(\Arr::only($item, 'is_active'));
                }
            }
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_OK);
    }

    protected function getFormAdditional(): array
    {
        return [
            //...
        ];
    }

    /**
     * @api {get} /api/v1/control/cars/{carId}/seo 08. Редактировать SEO
     * @apiVersion 1.0.0
     * @apiName GetCarSeoEdit
     * @apiGroup 39.Авто
     */
    public function seoEdit(Car $car)
    {
        return (new SeoModelEditResource($car))
            ->additional([
                'form' => [
                    'tokens' => Variable::setLang('en')->getArray('seo_masks')['cars']['tokens'] ?? [],
                ],
            ]);
    }

    /**
     * @api {post} /api/v1/control/pages/{pageId}/seo 09. Сохранить SEO
     * @apiVersion 1.0.0
     * @apiName PatchPageSeoSave
     * @apiGroup 39.Авто
     *
     * @apiParam {String} [title] Title
     * @apiParam {String} [keywords] Keywords
     * @apiParam {String} [description] Description
     * @apiParam {String=index,noindex} [robots] Robots
     */
    public function seoSave(SeoRequest $request, Car $post)
    {
        $this->authorize('post-manage');

        $post->seo()->updateOrCreate([], $request->validated());

        return response()
            ->json(['message' => trans('system.actions.update.success')], \Illuminate\Http\Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/control/cars/{carId}/media 10. Редактировать Media
     * @apiVersion 1.0.0
     * @apiName GetCarImagesEdit
     * @apiGroup 39.Авто
     */
    public function mediaEdit(Car $car)
    {
        return MediaResource::collection($car->media);
    }

    /**
     * @api {post} /api/v1/control/cars/{carId}/media 11. Загрузить Media
     * @apiVersion 1.0.0
     * @apiName PostCarImagesEdit
     * @apiGroup 39.Авто
     *
     * @apiParam {Array} media_deleted ID удаления media
     * @apiParam {Array} photos Photos array
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
    public function mediaSave(Request $request, Car $car)
    {
        $this->authorize('service-manage');

        $car->mediaManage($request);

        return response()
            ->json(['message' => trans('system.actions.update.success')], \Illuminate\Http\Response::HTTP_OK);
    }
}
