<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckValidLangForDomain;
use App\Http\Requests\Complaint\PostComplaintRequest;
use App\Http\Requests\ServiceRequest;
use App\Http\Requests\ServiceSearchRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Http\Requests\ServiceUser;
use App\Http\Resources\PostResource;
use App\Http\Resources\RatingResource;
use App\Http\Resources\SeoModelResource;
use App\Http\Resources\ServiceCleanResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\ServiceShowResource;
use App\Models\Notify;
use App\Models\Post;
use App\Models\Rating;
use App\Models\Service;
use App\Models\User;
use App\Notifications\Service\ServiceComplaint;
use App\Notifications\ServiceModerate;
use App\Services\Service\ServiceManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show', 'getServicesPosts', 'getServicesRatings', 'getUserServices', 'searchService']);
    }

    /**
     * @api {get} /api/v1/services 1. Получить все СТО
     * @apiVersion 1.0.0
     * @apiName ServiceIndex
     * @apiGroup 11.СТО
     *
     * @apiParam {String} lang Код языка
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function index(CheckValidLangForDomain $request)
    {
        $user = auth()->user();

        $services = Service::with('ratings', 'media', 'phones')
            ->whereHas('user')
//            ->when($user, function($q) use ($user) {
//                $q->where('status', Service::SERVICE_PUBLISHED)
//                    ->orWhere('user_id', $user->id);
//        })
//        ->when(!$user,function($q) {
//            $q->where('status', Service::SERVICE_PUBLISHED);
//        })
            ->where('status', Service::SERVICE_PUBLISHED)
            ->orderByDesc('created_at')
            ->paginate($request->per_page);

        return ServiceResource::collection($services);
    }

    /**
     * @api {get} /api/v1/services/{slug} 2. Получить СТО
     * @apiVersion 1.0.0
     * @apiName ServiceShow
     * @apiGroup 11.СТО
     */
    public function show($slug)
    {
        $user = auth()->user();
        /** @var Service $service */
        $service = Service::with('ratings', 'ratings.user', 'media')
            ->where('slug', $slug)
            ->when($user, function ($q) use ($user): void {
                $q->where(function ($q2) use ($user): void {
                    $q2->where('status', Service::SERVICE_PUBLISHED)
                        ->orWhere('user_id', $user->id);
                });
            })
            ->firstOrFail();

        return ServiceShowResource::make($service)
            ->additional([
                'seo' => new SeoModelResource($service),
            ]);
    }

    /**
     * @api {get} /api/v1/services/{slug}/posts 3. Получить посты СТО
     * @apiVersion 1.0.0
     * @apiName ServiceShowPosts
     * @apiGroup 11.СТО
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function getServicesPosts($slug, Request $request)
    {
        /** @var Service $service */
        $service = Service::where('slug', $slug)->firstOrFail();

        $posts = Post::with('media', 'author')->withCount('likes', 'comments')
            ->where('status', Post::POST_PUBLISHED)
            ->where('author_type', 'App\Models\Service')
            ->where('author_id', $service->id)
            ->orderByDesc('created_at')
            ->paginate($request->per_page);

        return PostResource::collection($posts);
    }

    /**
     * @api {get} /api/v1/services/{slug}/ratings 4. Получить отзывы о СТО
     * @apiVersion 1.0.0
     * @apiName ServiceShowRatings
     * @apiGroup 11.СТО
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function getServicesRatings($slug, Request $request)
    {
        /** @var Service $service */
        $service = Service::where('slug', $slug)->firstOrFail();

        $ratings = Rating::with('user', 'comments', 'comments.user')->where('service_id', $service->id)->withCount('likes', 'comments')->paginate($request->per_page);

        return RatingResource::collection($ratings);
    }

    /**
     * @api {post} /api/v1/services 5. Добавить СТО
     * @apiVersion 1.0.0
     * @apiName ServiceSave
     * @apiGroup 11.СТО
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} lang Код языка
     * @apiParam {File} main_photo Главное фото СТО
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
     * @apiParam {Array} [photos] Масив фотографий
     * @apiParam {Array} [video] Видео
     * @apiParam {Array} [social] Соц. сети (нужен массив з данными, который я вам верну)
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
     *          }
     *     }
     */
    public function store(ServiceRequest $request)
    {
        $user = auth()->user();

        if (Gate::denies('create-service')) {
            return response()->json(['message' => trans('system.service.denies')], Response::HTTP_FORBIDDEN);
        }

        /** @var Service $service */
        $service = $user->services()->create([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'place' => $request->place,
            'street' => $request->street,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'working' => $request->working,
            'descr' => $request->descr,
            'service' => $request->service,
            'video' => $request->video,
            'social' => $request->social,
            'status' => Service::SERVICE_MODERATE,
            'lang' => $request->lang,
        ]);

        if ($request->hasFile('main_photo.file')) {
            $service->addMedia($request->main_photo['file'])->toMediaCollection('image');
        }

        if ($request->photos) {
            foreach ($request->file('photos', []) as $file) {
                $service->mediaSave($file, 'images');
            }
        }

        //ServiceManager::addMainPhoto($request, $service);
        //ServiceManager::addPhotos($request, $service);
        ServiceManager::addPhones($request, $service);

        Notification::send($user, new ServiceModerate($service));
        $service->notifies()->create([
            'user_id' => $user->id,
            'type' => Notify::TYPE_MODERATE,
            'text' => trans('notification.services.moderate'),
        ]);

        return response()->json(['message' => trans('system.service.moderate'), 'service' => ServiceCleanResource::make($service)], Response::HTTP_OK);
    }

    /**
     * @api {put/patch} /api/v1/services/{id} 6. Обновить СТО
     * @apiVersion 1.0.0
     * @apiName ServiceUpdate
     * @apiGroup 11.СТО
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {File} main_photo Главное фото СТО
     * @apiParam {String} name Название СТО
     * @apiParam {String} email Email сервиса
     * @apiParam {Array} [phones] Масив телефонов СТО
     * @apiParam {String} country Страна
     * @apiParam {String} place Город
     * @apiParam {String} street Улица
     * @apiParam {String} address Полный адрес
     * @apiParam {Number} latitude географическая широта
     * @apiParam {Number} longitude долгота
     * @apiParam {Array} working Время работы
     * @apiParam {String} descr Описание СТО
     * @apiParam {Array} service Предоставляемые услуги
     * @apiParam {Array} [photos] Масив фотографий
     * @apiParam {Array} [video] Видео
     * @apiParam {Array} [social] Соц. сети
     */
    public function update($id, ServiceUpdateRequest $request)
    {
        $service = Service::with('user')->findOrFail($id);
        $user = $service->user;

        if (Gate::denies('update-service', $service)) {
            return response()->json(['message' => trans('system.service.denies')], Response::HTTP_FORBIDDEN);
        }
        $statusChanged = ($service->status != Service::SERVICE_MODERATE) ? true : false;

        $service->update([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'place' => $request->place,
            'street' => $request->street,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'working' => $request->working,
            'descr' => $request->descr,
            'service' => $request->service,
            'video' => $request->video,
            'social' => $request->social,
            'status' => Service::SERVICE_MODERATE,
        ]);

//        ServiceManager::addMainPhoto($request, $service);
//        ServiceManager::addPhotos($request, $service);

        if ($request->hasFile('main_photo.file')) {
            $service->clearMediaCollection('image');
            $service->addMediaFromRequest('main_photo.file')->toMediaCollection('image');
        }

        if ($request->photos) {
            foreach ($request->file('photos', []) as $file) {
                $service->mediaSave($file, 'images');
            }
        }

        if ($statusChanged) {
            Notification::send($user, new ServiceModerate($service));
            $service->notifies()->create([
                'user_id' => $user->id,
                'type' => Notify::TYPE_MODERATE,
                'text' => trans('notification.services.moderate'),
            ]);
        }
        ServiceManager::addPhones($request, $service);

        return response()->json(['message' => trans('system.service.moderate')], Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/users/{id}/services 7. Получить свои опубликованные/на модерации СТО
     * @apiVersion 1.0.0
     * @apiName GetUsersServices
     * @apiGroup 11.СТО
     *
     * @apiParam {String} filter Фильтр для СТО. Допустимые значение <code>published, moderate</code>
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function getUserServices($id, ServiceUser $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $services = $user->services()->with('ratings', 'media', 'phones')
            ->whereIn('status', $request->filter == 'published' ? [Service::SERVICE_PUBLISHED] : [Service::SERVICE_MODERATE, Service::SERVICE_REJECTED])
            ->sortService($request->filter)
            ->paginate($request->per_page);

        return ServiceResource::collection($services);
    }

    /**
     * @api {delete} /api/v1/services/{id}  8. Удалть СТО
     * @apiVersion 1.0.0
     * @apiName deleteService
     * @apiGroup 11.СТО
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if (Gate::denies('service-delete', $service)) {
            return response()->json(['message' => trans('system.service.denies')], Response::HTTP_FORBIDDEN);
        }

        $service->delete();
        $service->notifies()->delete();

        return response()->json(['message' => trans('system.service.delete')], Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/services/search 9. Поиск СТО
     * @apiVersion 1.0.0
     * @apiName searchService
     * @apiGroup 11.СТО
     *
     * @apiParam {String} lang Код языка
     * @apiParam {Decimal} f[latitude] широта
     * @apiParam {Decimal} f[longitude] долгота
     * @apiParam {Int} f[radius] Радиус
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function searchService(ServiceSearchRequest $request)
    {
        $f = $request->get('f', []);

        $services = Service::with('ratings', 'media', 'phones')
            ->where('status', Service::SERVICE_PUBLISHED)
            ->filterable($f)
            ->orderByDesc('created_at')
            ->paginate($request->per_page);

//        $latitude  = $request->f["latitude"];
//        $longitude  = $request->f["longitude"];
//
//        $radius = $request->f["radius"];
//
//        $services = Service::where('status', Service::SERVICE_PUBLISHED)
//            ->orderByDesc('created_at')
//            ->select('services.*')
//            ->selectRaw('( 6371 * acos( cos( radians(?) ) *
//                               cos( radians( latitude ) )
//                               * cos( radians( longitude ) - radians(?)
//                               ) + sin( radians(?) ) *
//                               sin( radians( latitude ) ) )
//                             ) AS distance', [$latitude, $longitude, $latitude])
//            ->havingRaw("distance < ?", [$radius])
//            ->paginate($request->per_page);

        return ServiceResource::collection($services);
    }

    /**
     * @api {post} /api/v1/services/{id}/complaint 10. Пожаловаться на СТО
     * @apiVersion 1.0.0
     * @apiName ComplaintService
     * @apiGroup 11.СТО
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     * @apiParam {String} complaint_text Текст жалобы
     * @apiParam {String} theme Тема жалобы
     *
     * * @apiDescription Жалобу можно писать не чаще чем через 24 часа
     */
    public function complaint($id, PostComplaintRequest $request)
    {
        $service = Service::findOrFail($id);
        $user = auth()->user();

        if ($user->hasComplaintService($service)) {
            return response()->json(['message' => trans('system.complaint.already')], Response::HTTP_BAD_REQUEST);
        }

        $complaint = $service->complaints()->create([
            'user_id' => $user->id,
            'complaint_text' => $request->complaint_text,
            'theme' => $request->theme,
        ]);

        Notification::send($service->user, new ServiceComplaint($service, $complaint));

        return response()
            ->json(['message' => trans('system.complaint.success')], Response::HTTP_CREATED);
    }
}
