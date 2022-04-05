<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Control\EventRequest;
use App\Http\Requests\Control\SeoRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Requests\SyncRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Control\MediaResource;
use App\Http\Resources\Control\SeoModelEditResource;
use App\Http\Resources\EventResource;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Timeline;
use App\Models\User;
use App\Notifications\Event\CancelNotification;
use App\Notifications\Event\ChangeNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Variable;

class EventController extends Controller
{
    /**
     * @api {get} /api/v1/control/events 1. Все события
     * @apiVersion 1.0.0
     * @apiName EventIndex
     * @apiGroup 21.События - Админка
     *
     * @apiDescription Получение всех событий
     *
     * @apiParam {String} lang Код языка
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     *
     * @apiDescription Фильтрация f[]
     * @apiParam {string} [period] Период времени активности события: 'today' => сегодня, 'this_week' => на этой неделе, 'weekend' => в выходные,
     * @apiParam {string} [date] Поиск по дате
     * @apiParam {string} [place] Поиск по городу
     * @apiParam {string} [category] Поиск по категории
     * @apiParam {int} [count_seats] Количество участников
     * @apiParam {bool} [confirm_user] Подтверждения участия
     * @apiParam {int} [age] Возраст
     * @apiParam {string} [sex] Пол
     * @apiParam {string} [status] Статус
     * @apiParam {int} [locations[]] Фильтрация по радиусу города: должно быть locations[latitude] => latitude, locations[longitude] => longitude, locations[radius] =>  radius,
     */
    public function index(Request $request)
    {
        $this->authorize('event-manage');

        $q = $request->get('q');
//        $f = $request->get('f', []);
        $events = Event::with('media', 'user', 'users', 'shares')->withCount('likes', 'comments')->whereHas('user')
            ->when($q, function ($query) use ($q): void {
                $query->where('title', 'LIKE', '%' . $q . '%')
                    ->oRwhere('descr', 'LIKE', '%' . $q . '%');
            })
            ->orderBy('nearly')
//            ->filterable($f)
//            ->where('lang', $request->lang)

            ->paginate($request->per_page);

        return EventResource::collection($events);
    }

    /**
     * @api {get} /api/v1/control/events/create 2. Создания события
     * @apiVersion 1.0.0
     * @apiName EventCreate
     * @apiGroup 21.События - Админка
     *
     * @apiDescription Создания события, передаваемые параметры: Категории - "categories", Приватность события - "privacy",
     * Подтвержденые пользователи,которые могут быть участниками - "users",
     * Пол - "gender", Возраст - "ages",
     */
    public function create(Request $request)
    {
        $categories = Event::categoryList();
        $ages = Event::ageList();
        $privacy = Event::privacyList();
        $gender = Event::genderList();
        $confirm = Event::confirmList();

        //количество участников для фильтрации
        $countSeats = Event::countSeatsList();

        $limit = $request->get('limit', 10);
        $q = $request->get('q');

        $users = User::with('media')
            ->when($q, function ($query) use ($q): void {
                $query->where(function ($query) use ($q): void {
                    $query->where('name', 'LIKE', '%' . $q . '%')
                        ->orWhere('surname', 'LIKE', '%' . $q . '%')
                        ->orWhere('nickname', 'LIKE', '%' . $q . '%');
                });
            })->select('id', 'name', 'surname', 'nickname')
            ->take($limit)->get();

        return response()->json([
            'categories' => $categories,
            'users' => AuthorResource::collection($users),
            'privacy' => $privacy,
            'gender' => $gender,
            'ages' => $ages,
            'confirm_users' => $confirm,
            'count_seats' => $countSeats,
        ]);
    }

    /**
     * @api {post} /api/v1/control/events 3. Добавить событие
     * @apiVersion 1.0.0
     * @apiName EventStore
     * @apiGroup 21.События - Админка
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} lang Аббревиатура языка на котором создается пост
     * @apiParam {File} main_photo Главное фото
     * @apiParam {File} photos Фотографии события
     * @apiParam {String} title Заголовок
     * @apiParam {String} descr Описание
     * @apiParam {Array} [coauthor] Соавтор
     * @apiParam {String} category Категория события
     * @apiParam {String} country Страна
     * @apiParam {String} place Город
     * @apiParam {String} street Улица
     * @apiParam {String} address Полный адрес
     * @apiParam {Number} latitude географическая широта
     * @apiParam {Number} longitude долгота
     * @apiParam {String} is_privacy Приватность события
     * @apiParam {Boolean} confirm_user Вручную выбирать участников
     * @apiParam {Array} [users] Участники
     * @apiParam {Number} count_seats Количество участников
     * @apiParam {Number} age Возраст
     * @apiParam {String} sex Пол
     * @apiParam {Boolean} comment_allowed Разрешены ли комментарии?
     * @apiParam {Boolean} chat_allowed Разрешен ли чат?
     * @apiParam {Boolean} to_slider Добавить в слайдер
     * @apiParam {Boolean} photos_allowed Разрешить добавления фотографий в альбом
     * @apiParam {Array} dates Даты и время событий
     * @apiParam {Boolean} to_slider Выводить событие в слайдер ("рекламный" блок)
     * @apiParam {Boolean} external_source  Внешний источник
     * @apiParam {Array} external Автор - внешний источник
     * @apiParamExample {json} Request-Example:
     *     {
     *          "external": [
     *               "name": Google Site,
     *               "link": https://laravel.com/docs/8.x/validation#rule-url
     *          ]
     *     }
     */
    public function store(EventRequest $request)
    {
        $this->authorize('event-manage');

        $data = $request->only([
            'lang', 'title', 'coauthor', 'country', 'place', 'street', 'address', 'latitude', 'longitude', 'category', 'is_privacy', 'confirm_user', 'comment_allowed',
            'chat_allowed', 'photos_allowed', 'count_seats', 'age', 'sex', 'dates', 'to_slider', 'descr', 'external', 'external_source', 'to_slider', 'self_schedule_dates',
            'dates_continuous', 'more_days',
        ]);

//        $data['user_id'] = $request->external_source ? auth()->user()->id : $request->user_id;
        $data['user_id'] = auth()->user()->id;

        /** @var Post $post */
        $event = Event::create($data);

        if (is_array($event['dates']) || is_object($event['dates'])) {
            // Изменение статуса события
            //проверка диапазона времени текущего события,
            foreach ($event['dates']['items']  as $date) {
                //проверка диапазона времени текущего события,
                if (Carbon::parse(Carbon::parse($date['date'])->toDateString() . ' ' . $date['time']['from'])->lte(Carbon::now()->setSecond(0)) && Carbon::parse(Carbon::parse($date['date'])->toDateString() . ' ' . $date['time']['to'])->gte(Carbon::now()->setSecond(0))) {
                    $event->update(['status' => Event::STATUS_ACTIVE]);
                } elseif (Carbon::parse(Carbon::parse($date['date'])->toDateString() . ' ' . $date['time']['from'])->lt(Carbon::now()->setSecond(0)) && Carbon::parse(Carbon::parse($date['date'])->toDateString() . ' ' . $date['time']['to'])->lt(Carbon::now()->setSecond(0))) {
                    $event->update(['status' => Event::STATUS_PASSED]);
                } else {
                    $event->update(['status' => Event::STATUS_WAIT]);
                }
            }
        }

        if (!empty($request->users)) {
            foreach ($request->users as $item) {
                $item_id_array[$item['id']] = ['user_status' => Event::STATUS_USER_ALLOWED];
            }
            $event->users()->sync($item_id_array);
        }

        if ($request->hasFile('main_photo.file')) {
            $event->addMedia($request->main_photo['file'])->toMediaCollection('image');
        }
        if ($request->photos) {
            foreach ($request->file('photos', []) as $file) {
                $event->mediaSave($file, 'images');
            }
        }

        $event->timelines()->create([
            'user_id' => $event->user->id,
            'type' => Timeline::TYPE_ADD,
        ]);

        $event->eventsful()->attach($request->user()->id, [
            'type' => Event::TYPE_SELF,
        ]);

        return response()
            ->json(['message' => trans('system.actions.store.success')], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * @api {get} /api/v1/control/events/create 5. Редактирование события
     * @apiVersion 1.0.0
     * @apiName EventEdit
     * @apiGroup 21.События - Админка
     *
     * @apiDescription Редактирование события, передаваемые параметры: Категории - "categories", Приватность события - "privacy",
     * Подтвержденые пользователи,которые могут быть участниками - "users",
     * Пол - "gender"
     */
    public function edit($id)
    {
        $this->authorize('event-manage');

        $categories = Event::categoryList();
        $privacy = Event::privacyList();
        $gender = Event::genderList();
        $users = User::where('status', 'approved')->pluck('nickname', 'id')->all();
        $event = Event::with('media', 'user', 'users')->withCount('likes')->findOrFail($id);

        return response()->json([
            'categories' => $categories,
            'users' => $users,
            'privacy' => $privacy,
            'gender' => $gender,
            'event' => EventResource::make($event),
        ]);
    }

    /**
     * @api {put/patch} /api/v1/control/events/{id} 6. Обновление события
     * @apiVersion 1.0.0
     * @apiName EventUpdate
     * @apiGroup 21.События - Админка
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {File} main_photo Главное фото
     * @apiParam {File} photos Фотографии события
     * @apiParam {String} title Заголовок
     * @apiParam {String} descr Описание
     * @apiParam {Array} [coauthor] Соавтор
     * @apiParam {String} category Категория события
     * @apiParam {String} country Страна
     * @apiParam {String} place Город
     * @apiParam {String} street Улица
     * @apiParam {String} address Полный адрес
     * @apiParam {Number} latitude географическая широта
     * @apiParam {Number} longitude долгота
     * @apiParam {String} is_privacy Приватность события
     * @apiParam {Boolean} confirm_user Вручную выбирать участников
     * @apiParam {Array} [users] Участники
     * @apiParam {Number} count_seats Количество участников
     * @apiParam {Number} age Возраст
     * @apiParam {String} sex Пол
     * @apiParam {Boolean} comment_allowed Разрешены ли комментарии?
     * @apiParam {Boolean} chat_allowed Разрешен ли чат?
     * @apiParam {Boolean} photos_allowed Разрешить добавления фотографий в альбом
     * @apiParam {Boolean} to_slider Добавить в слайдер
     * @apiParam {Array} dates Дата и время события
     * @apiParam {Boolean} to_slider Выводить событие в слайдер ("рекламный" блок)
     * @apiParam {Boolean} external_source  Внешний источник
     * @apiParam {Array} external Автор - внешний источник
     * @apiParamExample {json} Request-Example:
     *     {
     *          "external": [
     *               "name": Google Site,
     *               "link": https://laravel.com/docs/8.x/validation#rule-url
     *          ]
     *     }
     */
    public function update(EventUpdateRequest $request, $id)
    {
        $this->authorize('event-manage');

        $event = Event::with('media', 'users', 'user')->findOrFail($id);
        $user = $event->user;

        if ($event->dates != $request->dates) {
            foreach ($event->getAllowedUsers() as $user) {
                Notification::send($user, new ChangeNotification($event));
                $event->notifies()->create([
                    'user_id' => $user->id,
                    'type' => trans('notification.event.change_data'),
                ]);
            }
            Notification::send($event->user, new ChangeNotification($event));
            $event->notifies()->create([
                'user_id' => $event->user->id,
                'type' => trans('notification.event.change_data'),
            ]);
        }

        $data = $request->only([
            'lang', 'title', 'coauthor', 'country', 'place', 'street', 'address', 'latitude', 'longitude', 'category', 'is_privacy', 'confirm_user', 'comment_allowed',
            'chat_allowed', 'photos_allowed', 'count_seats', 'age', 'sex', 'dates', 'to_slider', 'descr', 'external', 'external_source', 'to_slider', 'self_schedule_dates',
            'dates_continuous', 'more_days',
        ]);

//        $data['user_id'] = $request->external_source ? auth()->user()->id : $request->user_id;
        $data['user_id'] = auth()->user()->id;

        /** @var Post $post */
        $event->update($data);

        if (!empty($request->users)) {
            foreach ($request->users as $item) {
                $item_id_array[$item['id']] = ['user_status' => Event::STATUS_USER_ALLOWED];
            }
            $event->users()->sync($item_id_array);
        }

        if ($request->hasFile('main_photo.file')) {
            $event->clearMediaCollection('image');
            $event->addMedia($request->main_photo['file'])->toMediaCollection('image');
        }
        if ($request->photos) {
            foreach ($request->file('photos', []) as $file) {
                $event->mediaSave($file, 'images');
            }
        }

        $event->timelines()->create([
            'user_id' => $user->id,
            'type' => Timeline::TYPE_UPDATE,
        ]);

        $event->eventsful()->updateExistingPivot($user->id, [
            'type' => Event::TYPE_SELF,
        ]);

        return response()
            ->json(['message' => trans('system.update.success'), 'event' => EventResource::make($event)], Response::HTTP_ACCEPTED);
    }

    /**
     * @api {delete} /api/v1/control/events/{id} 7. Удаление события
     * @apiVersion 1.0.0
     * @apiName EventDestroy
     * @apiGroup 21.События - Админка
     */
    public function destroy($id)
    {
        $event = Event::with('media', 'user', 'users')->findOrFail($id);

        $this->authorize('event-manage');

        $event->clearMediaCollection('images');
        $event->clearMediaCollection('image');
        Storage::delete($event->main_photo);
        Storage::delete($event->photos);
        $event->comments()->delete();
        $event->likes()->delete();

        foreach ($event->getAllowedUsers() as $user) {
            Notification::send($user, new CancelNotification($event));
        }
        Notification::send($event->user, new CancelNotification($event));

        $event->users()->sync([]);
        $event->notifies()->delete();
        $event->shares()->delete();
        $event->timelines()->delete();
        $event->eventsful()->sync([]);
        $event->delete();

        return response()
            ->json(['message' => trans('system.destroy.success')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/control/events/slider 8. Добавить/удалить в слайдер
     * @apiVersion 1.0.0
     * @apiName ToSlider
     * @apiGroup 21.События - Админка
     * @apiParam {Int} id Id события
     * @apiParam {Boolean} to_slider Выводить событие в слайдер ("рекламный" блок)
     * @apiParamExample {json} Request-Example:
     *     {
     *          "changed": [
     *           {
     *               "id": 1,
     *               "to_slider": false
     *           },
     *           {
     *               "id": 4,
     *               "to_slider": true
     *           }
     *          ]
     *     }
     */
    public function toSlider(Request $request)
    {
        $this->authorize('event-manage');

        foreach ($request->changed as $item) {
            $event = Event::findOrFail($item['id']);
            $event->update([
                'to_slider' => $item['to_slider'],
            ]);
        }

        return response()
            ->json(['message' => trans('system.update.success')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/control/events/sync 9. Синхронизация записей
     * @apiVersion 1.0.0
     * @apiName EventSync
     * @apiGroup 21.События - Админка
     *
     * @apiDescription Метод позволяет масово удалять записи.
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
        $this->authorize('event-manage');

        if ($request->deleted) {
            Event::whereIn('id', $request->deleted)->delete();
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/control/events/{eventId}/media 10. Редактировать Media
     * @apiVersion 1.0.0
     * @apiName GetEventImagesEdit
     * @apiGroup 21.События - Админка
     */
    public function mediaEdit(Event $event)
    {
        return MediaResource::collection($event->media);
    }

    /**
     * @api {post} /api/v1/control/events/{eventId}/media 11. Загрузить Media
     * @apiVersion 1.0.0
     * @apiName PostServiceImagesEdit
     * @apiGroup 21.События - Админка
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
    public function mediaSave(Request $request, Event $event)
    {
        $this->authorize('event-manage');

        if ($request->photos) {
            foreach ($request->file('photos', []) as $file) {
                $event->mediaSave($file, 'images');
            }
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], \Illuminate\Http\Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/control/events/{eventId}/seo 12. Редактировать SEO
     * @apiVersion 1.0.0
     * @apiName GetEventSeoEdit
     * @apiGroup 21.События - Админка
     */
    public function seoEdit(Event $event)
    {
        $this->authorize('event-manage');

        return (new SeoModelEditResource($event))
            ->additional([
                'form' => [
                    'tokens' => Variable::setLang($event->lang)->getArray('seo_masks')['event']['tokens'] ?? [],
                ],
            ]);
    }

    /**
     * @api {post} /api/v1/control/events/{eventId}/seo 13. Сохранить SEO
     * @apiVersion 1.0.0
     * @apiName EventSeoEdit
     * @apiGroup 21.События - Админка
     *
     * @apiParam {String} [title] Title
     * @apiParam {String} [keywords] Keywords
     * @apiParam {String} [description] Description
     * @apiParam {String=index,noindex} [robots] Robots
     */
    public function seoSave(SeoRequest $request, Event $event)
    {
        $this->authorize('event-manage');

        $event->seo()->updateOrCreate([], $request->validated());

        return response()
            ->json(['message' => trans('system.actions.update.success')], \Illuminate\Http\Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/control/events/{id}/comments 9. Получение коментариев к событию
     * @apiVersion 1.0.0
     * @apiName getEventComment
     * @apiGroup 21.События - Админка
     */
    public function getEventComments($id)
    {
        $event = Event::findOrFail($id);
        $comments = Comment::getChildTreeArray($event->comments()->with('user')->withCount('likes')->orderBy('created_at')->get());

        return CommentResource::collection($comments);
    }
}
