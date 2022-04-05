<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Control\CarAddRequest;
use App\Http\Requests\SyncRequest;
use App\Http\Resources\Control\HandbookResource;
use App\Models\Car;
use App\Models\Handbook;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class HandbookController extends Controller
{
    /**
     * @api {get} /api/v1/control/handbook 01. Список
     * @apiVersion 1.0.0
     * @apiName HandbookAll
     * @apiGroup 50.Материалы требующие проверки
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
        $this->authorize('handbook-manage');

        $handbooks = Handbook::sortable('created_at')
            ->filterable()
            ->searchable()
            ->paginate($request->per_page);

        return HandbookResource::collection($handbooks);
    }

    /**
     * @api {get} /api/v1/control/handbook/{id} 02. Отдельный материал
     * @apiVersion 1.0.0
     * @apiName HandbookShow
     * @apiGroup 50.Материалы требующие проверки
     */
    public function show(Handbook $handbook)
    {
        $this->authorize('handbook-manage');

        return HandbookResource::make($handbook->load('user'));
    }

    /**
     * @api {post} /api/v1/control/handbook/{id} 03. Добавить в справочник
     * @apiVersion 1.0.0
     * @apiName HandbookStore
     * @apiGroup 50.Материалы требующие проверки
     *
     * @apiParam {String} name Название марки
     * @apiParam {String} [name_ru] Название марки (rus)
     * @apiParam {String} [name_en] Название марки (eng)
     * @apiParam {String} [generation_name] Название генерации
     * @apiParam {String} [year_begin] Год начала выпуска
     * @apiParam {String} [year_end] Год завершения выпуска
     */
    public function store(CarAddRequest $request, $id)
    {
        $this->authorize('handbook-manage');

        $handbook = Handbook::findOrFail($id);

        $url = 'https://api-cars-cargasm.demka.online/api/cars/models';

        $response = Http::withHeaders([
            'Auth-token' => config('services.carsServiceToken'),
        ])->post($url, [
            'name' => $request->name,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'generation_name' => $request->generation_name,
            'year_begin' => $request->year_begin,
            'year_end' => $request->year_end,
        ]);

//        if ($handbook->car_id)
//        {
//            $car = Car::findOrFail($handbook->car_id);
//            $car->update([
//               'status' => Car::STATUS_PUBLISHED
//            ]);
//        }

        $handbook->update([
            'status' => Handbook::STATUS_PUBLISHED,
        ]);

        $response = $response->json();
        $response['message'] = trans('system.car.save');

        return $response;
    }

    /**
     * @api {delete} /api/v1/control/handbook/{id} 04. Удалить
     * @apiVersion 1.0.0
     * @apiName HandbookDestroy
     * @apiGroup 50.Материалы требующие проверки
     */
    public function destroy($id)
    {
        $this->authorize('handbook-manage');

        $handbook = Handbook::findOrFail($id);
        $handbook->delete();

        return response()
            ->json(['message' => trans('system.actions.destroy.success')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/control/handbook/sync 05. Синхронизация записей
     * @apiVersion 1.0.0
     * @apiName HandbookSync
     * @apiGroup 50.Материалы требующие проверки
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
        $this->authorize('handbook-manage');

        if ($request->deleted) {
            Handbook::whereIn('id', $request->deleted)->delete();
        }

        if ($request->changed) {
            foreach ($request->changed as $item) {
                if (isset($item['id']) && ($model = Handbook::find($item['id']))) {
                    //$model->update(\Arr::only($item, 'is_active'));
                }
            }
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_OK);
    }
}
