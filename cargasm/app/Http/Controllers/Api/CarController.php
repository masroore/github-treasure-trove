<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarStoreRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Http\Requests\Complaint\PostComplaintRequest;
use App\Http\Requests\HandbookRequest;
use App\Http\Resources\CarResource;
use App\Http\Resources\SeoModelResource;
use App\Models\Car;
use App\Models\Handbook;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Mail;

class CarController extends Controller
{
    /**
     * @api {get} /api/v1/users/{id}/cars 1. Получение автомобилей юзера
     * @apiVersion 1.0.0
     * @apiName CarsUsers
     * @apiGroup 15.Авто
     * @apiDescription Фильтрация f[]
     * @apiParam {string} [status] Поиск по статусу <code>published,moderate</code>
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function getUserCars($id, Request $request)
    {
        $f = $request->get('f', []);
        /** @var User $user */
        $user = User::findOrFail($id);
        $cars = Car::with('media')
            ->where('user_id', $user->id)
            ->where('status', Car::STATUS_PUBLISHED)
            ->filterable($f)
            ->paginate($request->per_page);

        $url = config('services.cars.urlService') . 'models';

        $response = Http::withHeaders([
            'Auth-token' => config('services.cars.serviceToken'),
        ])->acceptJson()->get($url, [
            'ids' => $cars->pluck('model_id')->toArray(),
        ]);

        $data = $response->json();

        CarResource::setModels($data['data'] ?? []);

        return CarResource::collection($cars);
    }

    /**
     * @api {post} /api/v1/cars/{id} 2. Показать информацию про машину
     * @apiVersion 1.0.0
     * @apiName CarShow
     * @apiGroup 15.Авто
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function show($id)
    {
        $car = Car::with('media')->findOrFail($id);
        $url = config('services.cars.urlService') . 'models';

        $response = Http::withHeaders([
            'Auth-token' => config('services.cars.serviceToken'),
        ])->acceptJson()->get($url, [
            'ids' => $car->model_id,
        ]);

        $data = $response->json();

        CarResource::setModels($data['data'] ?? []);

        return CarResource::make($car)
            ->additional(['seo' => new SeoModelResource($car)]);
    }

    /**
     * @api {post} /api/v1/cars 3. Добавить свое авто
     * @apiVersion 1.0.0
     * @apiName CarStore
     * @apiGroup 15.Авто
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} name Название
     * @apiParam {File} main_photo Главное фото
     * @apiParam {Int} mark_id Id марки
     * @apiParam {Int} model_id Id модели
     * @apiParam {Int} [year] Год выпуска автомобиля
     * @apiParam {String} [descr] Описание
     * @apiParam {String} [vin] VIN номер автомобиля
     * @apiParam {Array} [photos] дополниетельные поля
     * @apiParam {Boolean} is_homemade Заводской/Самодельный автомобиль, <code>0 - </code> Заводской,<code>1 - </code> Самодельный,
     */
    public function store(CarStoreRequest $request)
    {
        $user = $request->user();
        $car = Car::create([
            'name' => $request->name,
            'model_id' => $request->model_id,
            'mark_id' => $request->mark_id,
            'descr' => $request->descr,
            'vin' => $request->vin,
            'year' => $request->year,
            'is_homemade' => $request->boolean('is_homemade'),
            'status' => Car::STATUS_PUBLISHED,
            'user_id' => $user->id,
        ]);

        if ($request->hasFile('main_photo.file')) {
            $car->addMedia($request->main_photo['file'])->toMediaCollection('image');
        }
        if ($request->photos) {
            foreach ($request->file('photos', []) as $file) {
                $car->mediaSave($file, 'images');
            }
        }

        return response()->json(['message' => trans('system.car.save'), 'data' => $car], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/cars/store/self-car 4. Добавить авто которого нет в базе
     * @apiVersion 1.0.0
     * @apiName CarSelfStore
     * @apiGroup 15.Авто
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} [brand] Марка
     * @apiParam {String} [model] Модель
     * @apiParam {String} [year] Год выпуска
     */
    public function storeSelf(HandbookRequest $request)
    {
        $user = $request->user();

        $handbook = Handbook::create([
            'mark' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'status' => Handbook::STATUS_MODERATE,
        ]);

        return response()->json(['message' => trans('system.car.add'), 'data' => $handbook], Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/cars/{id}/edit 5. Изменить авто
     * @apiVersion 1.0.0
     * @apiName CarEdit
     * @apiGroup 15.Авто
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function edit($id)
    {
        $car = Car::findOrFail($id);

        $url = config('services.cars.urlService') . 'models';
        $response = Http::withHeaders([
            'Auth-token' => config('services.cars.serviceToken'),
        ])->acceptJson()->get($url, [
            'ids' => $car->model_id,
        ]);

        $data = $response->json();

        CarResource::setModels($data['data'] ?? []);

        return CarResource::make($car);
    }

    /**
     * @api {put/patch} /api/v1/cars/{id} 6. Обновить свое авто
     * @apiVersion 1.0.0
     * @apiName CarUpdate
     * @apiGroup 15.Авто
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {File} main_photo Главное фото
     * @apiParam {String} [name] Название автомобиля
     * @apiParam {Int} mark_id Id марки
     * @apiParam {Int} model_id Id модели
     * @apiParam {String} [descr] Описание
     * @apiParam {Int} [year] Год выпуска автомобиля
     * @apiParam {String} [vin] VIN номер автомобиля
     * @apiParam {Array} [photos] дополниетельные поля
     */
    public function update($id, CarUpdateRequest $request)
    {
        $car = Car::findOrFail($id);

        if (Gate::denies('car-update', $car)) {
            return response()->json(['message' => trans('system.car.denies')], Response::HTTP_FORBIDDEN);
        }

        $car->update([
            'name' => $request->name,
            'mark_id' => $request->mark_id,
            'model_id' => $request->model_id,
            'descr' => $request->descr,
            'vin' => $request->vin,
            'year' => $request->year,
            'is_homemade' => $request->boolean('is_homemade'),
            'status' => Car::STATUS_PUBLISHED,
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

        return response()->json(['message' => trans('system.car.save')], Response::HTTP_OK);
    }

    /**
     * @api {delete} /api/v1/cars/{id} 7. Удалить свое авто
     * @apiVersion 1.0.0
     * @apiName CarDelete
     * @apiGroup 15.Авто
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        if (Gate::denies('car-delete', $car)) {
            return response()->json(['message' => trans('system.car.denies')], Response::HTTP_FORBIDDEN);
        }

        $car->clearMediaCollection('image');
        $car->clearMediaCollection('images');
        Storage::delete($car->main_photo);
        Storage::delete($car->photos);

        $car->delete();

        return response()->json(['message' => trans('system.car.delete')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/cars/{id}/complaint 8. Пожаловаться на авто
     * @apiVersion 1.0.0
     * @apiName ComplaintCar
     * @apiGroup 15.Авто
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     * @apiParam {String} complaint_text Текст жалобы
     * @apiParam {String} theme Тема жалобы
     *
     * * @apiDescription Жалобу можно писать не чаще чем через 24 часа
     */
    public function complaint($id, PostComplaintRequest $request)
    {
        $car = Car::findOrFail($id);
        $user = auth()->user();

        if ($user->hasComplaintCar($car)) {
            return response()->json(['message' => trans('system.complaint.already')], Response::HTTP_BAD_REQUEST);
        }

        $complaint = $car->complaints()->create([
            'user_id' => $user->id,
            'complaint_text' => $request->complaint_text,
            'theme' => $request->theme,
        ]);

        $mails = array_map(function ($mail) {
            return trim($mail);
        }, explode(',', env('MAIL_ADMIN')));

        Mail::to($mails)->send(new \App\Mail\ComplaintMail('Новая жалоба', 'emails.complaint.complaint', [
            'link' => env('FRONT_URL') . '/cars/' . $car->id,
            'complaint' => $complaint,
        ]));

        return response()
            ->json(['message' => trans('system.complaint.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {get} /cars/brands 9. Получить марки авто
     * @apiVersion 1.0.0
     * @apiName ComplaintCar
     * @apiGroup 15.Авто
     *
     * @apiParam {String} [q] Поисковый запрос
     * @apiParam {Integer} [limit] Лимит на получение, default=100
     */
    public function brands(Request $request)
    {
        $url = config('services.cars.urlService') . 'marks';
        $response = Http::withHeaders([
            'Auth-token' => config('services.cars.serviceToken'),
        ])->acceptJson()->get($url, [
            'q' => $request->get('q'),
            'limit' => $request->get('limit'),
            'ids' => $request->get('ids'),
        ]);

        return $response->json();
    }

    /**
     * @api {post} /cars/models 10. Получить модели авто
     * @apiVersion 1.0.0
     * @apiName ComplaintCar
     * @apiGroup 15.Авто
     *
     * @apiParam {Int} mark_id Id марки
     * @apiParam {Integer} [limit] Лимит на получение, default=100
     * @apiParam {String} [q] Поисковый запрос
     * @apiParam {Array} [ids] ID для фильтрация
     */
    public function models(Request $request)
    {
        $url = config('services.cars.urlService') . 'models';

        $response = Http::withHeaders([
            'Auth-token' => config('services.cars.serviceToken'),
        ])->acceptJson()->get($url, [
            'q' => $request->get('q'),
            'limit' => $request->get('limit'),
            'mark_id' => $request->get('mark_id'),
            'ids' => $request->get('ids'),
        ]);

        return $response->json();
    }

    /**
     * @api {get} /cars/catalog/brands 11. Получить марки авто для магазина
     * @apiVersion 1.0.0
     * @apiName CarBrandMagazine
     * @apiGroup 15.Авто
     *
     * @apiParam {String} [q] Поисковый запрос
     */
    public function brandsMagazine(Request $request)
    {
        $url = config('services.cars.urlMagazine') . 'get%3Abrands/';

        $response = Http::asForm()->post($url);

        $brands = $response->json();

        if ($q = $request->get('q')) {
            $res = [];
            foreach ($brands as $brand) {
                if (strpos(mb_strtolower($brand['title'] ?? ''), mb_strtolower($q)) !== false) {
                    $res[] = $brand;
                }
            }

            return $res;
        }

        return $brands;
    }

    /**
     * @api {post} /cars/catalog/model 12. Получить модели авто для магазина
     * @apiVersion 1.0.0
     * @apiName CarBrandMagazine
     * @apiGroup 15.Авто
     *
     * @apiParam {String} [brand_id] Id марки
     * @apiParam {String} [q] Поисковый запрос
     */
    public function modelMagazine(Request $request)
    {
        $url = config('services.cars.urlMagazine') . 'get%3Agenerations/';

        $response = Http::asForm()->post($url, [
            'brand_id' => $request->get('brand_id'),
        ]);

        $brands = $response->json();

        if ($q = $request->get('q')) {
            $res = [];
            foreach ($brands as $brand) {
                if (strpos(mb_strtolower($brand['title'] ?? ''), mb_strtolower($q)) !== false) {
                    $res[] = $brand;
                }
            }

            return $res;
        }

        return $brands;
    }
}
