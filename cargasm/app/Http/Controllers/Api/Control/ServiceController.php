<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Control\SeoRequest;
use App\Http\Requests\Control\ServiceRequest;
use App\Http\Requests\SyncRequest;
use App\Http\Resources\Control\LanguageResource;
use App\Http\Resources\Control\MediaResource;
use App\Http\Resources\Control\SeoModelEditResource;
use App\Http\Resources\Control\ServiceEditResource;
use App\Http\Resources\Control\ServiceResource;
use App\Models\Notify;
use App\Models\Service;
use App\Notifications\ServiceModeratePublished;
use App\Services\Service\ServiceManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Variable;

class ServiceController extends Controller
{
    /**
     * @api {get} /api/v1/control/services 01. Список
     * @apiVersion 1.0.0
     * @apiName GetServiceIndex
     * @apiGroup 36.СТО
     *
     * @apiParam {Integer} [page=1] Номер страницы
     * @apiParam {Integer} [per_page] Количество элементов на странице
     * @apiParam {String=id,name,place,country,created_at} [sort=created_at] Поле для сортировки
     * @apiParam {String=asc,desc} [direction=desc] Направление сортировки
     * @apiParam {String} [_lang] Фильтрация по языку
     * @apiParam {String} [q] Поисковый запрос
     *
     * @apiParam {Array} [f] Поля для фильтрации. См. ниже:
     * @apiParam(f) {Integer} [user_id] Партнер, создавшый запись
     *
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/api/v1/control/services?direction=asc&sort=name&q=Carter-Group&f[user_id]=1
     */
    public function index(Request $request)
    {
        $f = $request->get('f', []);

        $services = Service::sortable('created_at')
            ->filterable($f)
            ->searchable()
            ->with('phones')
            ->paginate($request->per_page);

        return ServiceResource::collection($services)
            ->additional([
                'form' => $this->getFormAdditional(),
            ]);
    }

    /**
     * @api {get} /api/v1/control/services/create 02. Создать (форма)
     * @apiVersion 1.0.0
     * @apiName GetServiceCreate
     * @apiGroup 36.СТО
     */
    public function create()
    {
        return response()->json([
            'form' => $this->getFormAdditional(),
        ]);
    }

    /**
     * @api {post} /api/v1/control/services 03. Сохранить
     * @apiVersion 1.0.0
     * @apiName PostServiceStore
     * @apiGroup 36.СТО
     *
     * @apiParam {String} lang Код языка
     * @apiParam {String} name Название СТО
     * @apiParam {String} email Email сервиса
     * @apiParam {Array} [phones] Масив телефонов СТО
     * @apiParam {String} country Страна
     * @apiParam {String} place Город
     * @apiParam {String} street Улица
     * @apiParam {String} address Полный адрес
     * @apiParam {Number} latitude географическая широта
     * @apiParam {Number} longitude долгота
     * @apiParam {Array} working Время работы (нужен массив з данными, который я вам верну)
     * @apiParam {String} descr Описание СТО
     * @apiParam {Array} service Предоставляемые услуги (нужен массив з данными, который я вам верну)
     * @apiParam {Array} [video] Видео
     * @apiParam {Array} [social] Соц. сети (нужен массив з данными, который я вам верну)
     * @apiParam {Array} [photos] Главное фото (массив с одного элемента)
     * @apiParam {String} status Статус
     * @apiParam {Boolean} is_active Вкл/Откл
     * @apiParam {Boolean} is_sitemap Отображать на карте сайта
     * @apiParam {String} msg_reject Коментарий (для модерации)
     * @apiParam {Int} user_id Пользователь
     * @apiParam {Array} [media_deleted] ID удаления media
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *          "phones": [
     *           {
     *               "phone": "0671111111"
     *           },
     *           {
     *               "phone": "0671111111"
     *           }
     *          ],
     *          "working": [
     *          {
     *              "days": "Пн-ПТ",
     *              "time": "10:00-19:00"
     *          },
     *          {
     *              "days": "Сб",
     *              "time": "10:00-18:00"
     *          }
     *          ],
     *          "video": [
     *          {
     *              "video": "https://www.youtube.com/watch?v=pujQD1WvKvs&list=RDpujQD1WvKvs&start_radio=1,
     *          },
     *          {
     *              "video": "https://www.youtube.com/watch?v=pujQD1WvKvs&list=RDpujQD1WvKvs&start_radio=1,
     *          }
     *          ],
     *          "social": {
     *              'vk' => 'https://vk.com/feed',
     *              'youtube' => '',
     *              'facebook' => 'https://www.facebook.com',
     *              'ok' => ''
     *          },
     *          "photos": {
     *              {
     *                  id: "NULL or ID",
     *                  file: "<BINARY FILE>",
     *                  title: "File title",
     *                  alt: "File alt",
     *                  is_active: true,
     *                  is_main: true,
     *                  delete: false,
     *              }
     *          }
     *     }
     */
    public function store(ServiceRequest $request)
    {
        /** @var Service $service */
        $service = Service::create($request->only([
            'lang', 'name', 'email', 'country', 'place', 'street', 'address',
            'latitude', 'longitude', 'working', 'descr', 'service', 'video', 'social',
            'status', 'is_active', 'is_sitemap', 'msg_reject', 'user_id', 'slug',
        ]));

        //$service->mediaManage($request);
        $service->mediaDelete($request->media_deleted);
        $service->mediaSave(array_merge($request->photo ?? [], [
            'file' => $request->photo['file'] ?? null,
            'is_main' => true,
        ]), 'images');

        ServiceManager::addPhones($request, $service);

        return response()
            ->json(['message' => trans('system.actions.store.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {get} /api/v1/control/services/{serviceId}/edit 04. Редактировать
     * @apiVersion 1.0.0
     * @apiName GetServiceEdit
     * @apiGroup 36.СТО
     */
    public function edit(Service $service)
    {
        /** @var Service $service */
        $service = $service->load('media', 'user', 'phones');

        return ServiceEditResource::make($service)->additional([
            'form' => $this->getFormAdditional(),
        ]);
    }

    /**
     * @api {patch} /api/v1/control/services/{serviceId} 05. Обновить
     * @apiVersion 1.0.0
     * @apiName PatchServiceUpdate
     * @apiGroup 36.СТО
     */
    public function update(ServiceRequest $request, Service $service)
    {
//        $statusChanged = $service->status;
//        $user = $service->user()->get();
        $user = $service->user;

        $service->update($request->only([
            'lang', 'name', 'email', 'country', 'place', 'street', 'address',
            'latitude', 'longitude', 'working', 'descr', 'service', 'video', 'social',
            'status', 'is_active', 'is_sitemap', 'msg_reject', 'user_id', 'type', 'slug',
        ]));

//        if ($service->wasChanged('status') && $service->status === Service::SERVICE_PUBLISHED) {
//            Notification::send($user,new ServiceModeratePublished($service));
//            $service->notifies()->create([
//                'user_id' => $user->id,
//                'type' => Notify::TYPE_MODERATE,
//                'text' => trans('notification.services.moderate')
//            ]);
//        }

        $service->mediaDelete($request->media_deleted);
        $service->mediaSave(array_merge($request->photo ?? [], [
            'file' => $request->photo['file'] ?? null,
            'is_main' => true,
        ]), 'images');

        ServiceManager::addPhones($request, $service);

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_ACCEPTED);
    }

    /**
     * @api {patch} /api/v1/control/services/{serviceId} 06. Удалить
     * @apiVersion 1.0.0
     * @apiName PatchServiceUpdate
     * @apiGroup 36.СТО
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()
            ->json(['message' => trans('system.actions.destroy.success')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/control/services/sync 07. Синхронизация записей
     * @apiVersion 1.0.0
     * @apiName PostServiceSync
     * @apiGroup 36.СТО
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
        $this->authorize('service-manage');

        if ($request->deleted) {
            Service::whereIn('id', $request->deleted)->delete();
        }

        if ($request->changed) {
            foreach ($request->changed as $item) {
                if (isset($item['id']) && ($model = Service::find($item['id']))) {
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
            'statuses' => Service::statusesList(),
            'services' => Service::servicesList(),
            'languages' => LanguageResource::collection(get_languages()),
        ];
    }

    /**
     * @api {get} /api/v1/control/services/{serviceId}/media 08. Редактировать Media
     * @apiVersion 1.0.0
     * @apiName GetServiceImagesEdit
     * @apiGroup 36.СТО
     */
    public function mediaEdit(Service $service)
    {
        return MediaResource::collection($service->media);
    }

    /**
     * @api {post} /api/v1/control/services/{serviceId}/media 09. Загрузить Media
     * @apiVersion 1.0.0
     * @apiName PostServiceImagesEdit
     * @apiGroup 36.СТО
     *
     * @apiParam {Array} photos Photos array with fields
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
    public function mediaSave(Request $request, Service $service)
    {
        $this->authorize('service-manage');

        $service->mediaManage($request);
        if ($request->photos) {
            foreach ($request->file('photos', []) as $file) {
                $service->mediaSave($file, 'images');
            }
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], \Illuminate\Http\Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/control/services/{serviceId}/seo 10. Редактировать SEO
     * @apiVersion 1.0.0
     * @apiName GetServiceSeoEdit
     * @apiGroup 36.СТО
     */
    public function seoEdit(Service $service)
    {
        $this->authorize('service-manage');

        return (new SeoModelEditResource($service))
            ->additional([
                'form' => [
                    'tokens' => Variable::setLang($service->lang)->getArray('seo_masks')['services']['tokens'] ?? [],
                ],
            ]);
    }

    /**
     * @api {post} /api/v1/control/services/{serviceId}/seo 11. Сохранить SEO
     * @apiVersion 1.0.0
     * @apiName PostServiceSeoEdit
     * @apiGroup 36.СТО
     *
     * @apiParam {String} [title] Title
     * @apiParam {String} [keywords] Keywords
     * @apiParam {String} [description] Description
     * @apiParam {String=index,noindex} [robots] Robots
     */
    public function seoSave(SeoRequest $request, Service $service)
    {
        $this->authorize('service-manage');

        $service->seo()->updateOrCreate([], $request->validated());

        return response()
            ->json(['message' => trans('system.actions.update.success')], \Illuminate\Http\Response::HTTP_OK);
    }
}
