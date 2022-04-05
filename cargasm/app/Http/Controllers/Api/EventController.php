<?php

namespace App\Http\Controllers\Api;

use App\Events\EventSortable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckValidLangForDomain;
use App\Http\Requests\CommentAddRequest;
use App\Http\Requests\Complaint\PostComplaintRequest;
use App\Http\Requests\EventAddPhotoRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Requests\EventUserStatusRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\SeoModelResource;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Notify;
use App\Models\Timeline;
use App\Models\User;
use App\Notifications\Event\CancelNotification;
use App\Notifications\Event\ChangeNotification;
use App\Notifications\Event\ChangeStatus;
use App\Notifications\Event\EventComplaint;
use App\Notifications\Event\NewComment;
use App\Notifications\Event\NewLike;
use App\Notifications\Event\NewParticipant;
use App\Notifications\Event\NewShare;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $title
 * @property bool $comment_allowed
 * @property string $author_type
 * @property int $author_id
 * @property Carbon $created_at
 * @property Carbon updated_at
 */
class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show', 'addPhotos', 'getUserEvents', 'slider', 'create', 'allUsers', 'getEventComments']);
    }

    /**
     * @api {get} /api/v1/events 1. Все события
     * @apiVersion 1.0.0
     * @apiName EventIndex
     * @apiGroup 20.События
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
     * @apiParam {string} [date] Поиск по дате: date[from] - из, date[to] - по
     * @apiParam {string} [place] Поиск по городу
     * @apiParam {string} [categories] Поиск по категории, <code>all - </code>Не имеет значения
     * @apiParam {int} [count_seats] Количество участников, ключи <code>10,20,50,101,1001 - </code>Не имеет значения
     * @apiParam {bool} [confirm_user] Подтверждения участия
     * @apiParam {int} [age] Возраст
     * @apiParam {string} [sex] Пол
     * @apiParam {string} [status] Статус
     * @apiParam {int} [locations[]] Фильтрация по радиусу города: должно быть locations[latitude] => latitude, locations[longitude] => longitude, locations[radius] =>  radius,
     */
    public function index(CheckValidLangForDomain $request)
    {
        $q = $request->get('q');
        $f = $request->get('f', []);
        $events = Event::with('media', 'user', 'users', 'shares')->withCount('likes', 'comments')->whereHas('user')
            ->when($q, function ($query) use ($q): void {
                $query->where('title', 'LIKE', '%' . $q . '%')
                    ->oRwhere('descr', 'LIKE', '%' . $q . '%');
            })
            ->filterable($f)
            ->orderBy('nearly')
            ->paginate($request->per_page);

        return EventResource::collection($events);
    }

    /**
     * @api {get} /api/v1/events/all 21. Все события (Мои события, Я иду)
     * @apiVersion 1.0.0
     * @apiName EventIndexAll
     * @apiGroup 20.События
     *
     * @apiDescription Получение всех событий
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function allEvents(Request $request)
    {
        $user = $request->user();
        $events = $user->eventsful()->with('media', 'user', 'users', 'shares')
            ->withCount('likes', 'comments')
            ->orderBy('nearly')
            ->paginate($request->per_page);

        return EventResource::collection($events);
    }

    /**
     * @api {get} /api/v1/users/{id}/onward 22. Я иду
     * @apiVersion 1.0.0
     * @apiName EventIndexOnward
     * @apiGroup 20.События
     *
     * @apiDescription Получение всех событий на которые я иду
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function onward($id, Request $request)
    {
        $user = User::findOrFail($id);

        $events = $user->eventsful()->wherePivot('type', Event::TYPE_ATTEMPT)->with('media', 'user', 'users', 'shares')
            ->withCount('likes', 'comments')
            ->orderBy('nearly')
            ->paginate($request->per_page);

        return EventResource::collection($events);
    }

    /**
     * @api {get} /api/v1/events/create 2. Создания события
     * @apiVersion 1.0.0
     * @apiName EventCreate
     * @apiGroup 20.События
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
     * @api {post} /api/v1/events 3. Добавить событие
     * @apiVersion 1.0.0
     * @apiName EventStore
     * @apiGroup 20.События
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
     * @apiParam {Boolean} photos_allowed Разрешить добавления фотографий в альбом
     * @apiParam {Boolean} self_schedule_dates Добавить свое расписание
     * @apiParam {Boolean} dates_continuous Непрерывное событие
     * @apiParam {Boolean} more_days Несколько дней
     * @apiParam {Array} dates Даты и время событий
     */
    public function store(EventRequest $request, $uuid = false)
    {
        /** @var User $user */
        $user = $request->user();
        /** @var Event $event */
        $event = Event::create(array_merge(
            Arr::except($request->validated(), ['main_photo', 'photos']),
            [
                'uuid' => $uuid ? $uuid : Str::uuid()->toString(),
                'lang' => $request->lang,
                'user_id' => $user->id,
                'title' => $request->title,
                'coauthor' => $request->coauthor,
                'country' => $request->country,
                'place' => $request->place,
                'street' => $request->street,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'category' => $request->category,
                'is_privacy' => $request->is_privacy,
                'confirm_user' => $request->confirm_user,
                'comment_allowed' => $request->comment_allowed,
                'chat_allowed' => $request->chat_allowed,
                'photos_allowed' => $request->photos_allowed,
                'count_seats' => $request->count_seats,
                'age' => $request->age,
                'sex' => $request->sex,
                'dates' => $request->dates,
                'self_schedule_dates' => $request->self_schedule_dates,
                'dates_continuous' => $request->dates_continuous,
                'more_days' => $request->more_days,
            ]
        ));

        if (!empty($request->users)) {
            foreach ($request->users as $item) {
                $item_id_array[$item['id']] = ['user_status' => Event::STATUS_USER_ALLOWED];
            }
            $event->users()->sync($item_id_array);
        }

        if (is_array($event['dates']) || is_object($event['dates'])) {
            // Изменение статуса события
            $dateFrom = $event['dates']['date']['from'];
            $dateTo = $event['dates']['date']['to'];
            //проверка диапазона времени текущего события,
            foreach ($event['dates']['items'] as $date) {
                //проверка диапазона времени текущего события,
                if (Carbon::parse(Carbon::parse($dateFrom)->toDateString() . ' ' . $date['time']['from'])->lte(Carbon::now()->setSecond(0)) && Carbon::parse(Carbon::parse($dateTo)->toDateString() . ' ' . $date['time']['to'])->gte(Carbon::now()->setSecond(0))) {
                    $event->update(['status' => Event::STATUS_ACTIVE]);
                } elseif (Carbon::parse(Carbon::parse($dateTo)->toDateString() . ' ' . $date['time']['to'])->lt(Carbon::now()->setSecond(0))) {
                    $event->update(['status' => Event::STATUS_PASSED]);
                } else {
                    $event->update(['status' => Event::STATUS_WAIT]);
                }
            }
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
            'user_id' => $user->id,
            'type' => Timeline::TYPE_ADD,
        ]);

        $event->eventsful()->attach($user->id, [
            'type' => Event::TYPE_SELF,
        ]);

        event(new EventSortable());

        return response()
            ->json(['message' => trans('system.store.success'), 'data' => $event], Response::HTTP_ACCEPTED);
    }

    /**
     * @api {get} /api/v1/events/{id} 4. Получение события
     * @apiVersion 1.0.0
     * @apiName EventShow
     * @apiGroup 20.События
     *
     * @apiDescription Получение отдельного события.
     */
    public function show($slug)
    {
        $event = Event::with('media', 'user', 'users')->withCount('likes', 'comments')->where('slug', $slug)->firstOrFail();

        return response()->json([
            'event' => EventResource::make($event),
            'seo' => new SeoModelResource($event),
        ]);
    }

    /**
     * @api {get} /api/v1/events/create 5. Редактирование события
     * @apiVersion 1.0.0
     * @apiName EventEdit
     * @apiGroup 20.События
     *
     * @apiDescription Редактирование события, передаваемые параметры: Категории - "categories", Приватность события - "privacy",
     * Подтвержденые пользователи,которые могут быть участниками - "users",
     * Пол - "gender"
     */
    public function edit($id)
    {
        $categories = Event::categoryList();
        $ages = Event::ageList();
        $privacy = Event::privacyList();
        $gender = Event::genderList();
        $confirm = Event::confirmList();

        $users = User::where('status', 'approved')->pluck('nickname', 'id')->all();
        $event = Event::with('media', 'user', 'users')->withCount('likes')->findOrFail($id);

        return response()->json([
            'categories' => $categories,
            'ages' => $ages,
            'users' => $users,
            'privacy' => $privacy,
            'gender' => $gender,
            'confirm_users' => $confirm,
            'event' => EventResource::make($event),
        ]);
    }

    /**
     * @api {put/patch} /api/v1/events/{id} 6. Обновление события
     * @apiVersion 1.0.0
     * @apiName EventUpdate
     * @apiGroup 20.События
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
     * @apiParam {Boolean} self_schedule_dates Добавить свое расписание
     * @apiParam {Boolean} dates_continuous Непрерывное событие
     * @apiParam {Boolean} more_days Несколько дней
     * @apiParam {Array} dates Дата и время события
     */
    public function update(EventUpdateRequest $request, $id)
    {
        $user = $request->user();
        $event = Event::with('media', 'users', 'user')->findOrFail($id);

        if (Gate::allows('update-event', $event)) {
            if ($event->dates != $request->dates) {
                foreach ($event->getAllowedUsers() as $user) {
                    Notification::send($user, new ChangeNotification($event));
                    $event->notifies()->create([
                        'user_id' => $user->id,
                        'type' => Notify::TYPE_CHANGE,
                        'text' => trans('notification.event.change_data'),
                    ]);
                }
                Notification::send($event->user, new ChangeNotification($event));
                $event->notifies()->create([
                    'user_id' => $event->user->id,
                    'type' => Notify::TYPE_CHANGE,
                    'text' => trans('notification.event.change_data'),
                ]);
            }
            $event->update(array_merge(
                Arr::except($request->validated(), ['main_photo', 'photos']),
                [
                    'title' => $request->title,
                    'coauthor' => $request->coauthor,
                    'country' => $request->country,
                    'place' => $request->place,
                    'street' => $request->street,
                    'address' => $request->address,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'category' => $request->category,
                    'is_privacy' => $request->is_privacy,
                    'comment_allowed' => $request->comment_allowed,
                    'chat_allowed' => $request->chat_allowed,
                    'photos_allowed' => $request->photos_allowed,
                    'count_seats' => $request->count_seats,
                    'age' => $request->age,
                    'sex' => $request->sex,
                    'dates' => $request->dates,
                    'self_schedule_dates' => $request->self_schedule_dates,
                    'dates_continuous' => $request->dates_continuous,
                    'more_days' => $request->more_days,
                ]
            ));

            if (is_array($event['dates']) || is_object($event['dates'])) {
                $dateFrom = $event['dates']['date']['from'];
                $dateTo = $event['dates']['date']['to'];
                //проверка диапазона времени текущего события,
                foreach ($event['dates']['items'] as $date) {
                    //проверка диапазона времени текущего события,
                    if (Carbon::parse(Carbon::parse($dateFrom)->toDateString() . ' ' . $date['time']['from'])->lte(Carbon::now()->setSecond(0)) && Carbon::parse(Carbon::parse($dateTo)->toDateString() . ' ' . $date['time']['to'])->gte(Carbon::now()->setSecond(0))) {
                        $event->update(['status' => Event::STATUS_ACTIVE]);
                    } elseif (Carbon::parse(Carbon::parse($dateTo)->toDateString() . ' ' . $date['time']['to'])->lt(Carbon::now()->setSecond(0))) {
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
                $event->clearMediaCollection('image');
                $event->addMediaFromRequest('main_photo.file')->toMediaCollection('image');
            }

            if ($request->photos) {
                foreach ($request->file('photos', []) as $file) {
                    $event->mediaSave($file, 'images');
                }
            }

            $event->timelines()->update([
                'user_id' => $request->user()->id,
                'type' => Timeline::TYPE_UPDATE,
            ]);

            $event->eventsful()->updateExistingPivot($user->id, [
                'type' => Event::TYPE_SELF,
            ]);

            event(new EventSortable());

            return response()
                ->json(['message' => trans('system.update.success'), 'event' => EventResource::make($event)], Response::HTTP_ACCEPTED);
        }

        return response()->json(['message' => trans('system.destroy.error')], Response::HTTP_FORBIDDEN);
    }

    /**
     * @api {post} /api/v1/events/{id}/photos 9. Добавления фотографий в событие
     * @apiVersion 1.0.0
     * @apiName EventPhotoUpdate
     * @apiGroup 20.События
     *
     * @apiDescription Добавления фотографий если в событии это разрешено
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {File} photos Фотографии события
     */
    public function addPhotos(EventAddPhotoRequest $request, $id)
    {
        $user = $request->user();
        $event = Event::with('media', 'users', 'user')->findOrFail($id);

        if ($event->user->id === $user->id) {
            if ($request->photos) {
                foreach ($request->file('photos', []) as $file) {
                    $event->mediaSave([
                        'file' => $file,
                    ], 'images_author');
                }

                return response()->json(['message' => trans('system.event.photo.save')], Response::HTTP_ACCEPTED);
            }
        } else {
            //загрузка фотографий другими участниками события
            if ($event->photos_allowed) {//если разрешено добавлять фотографии
                foreach ($event->getAllowedUsers() as $userPhoto) {
                    if (isset($userPhoto)) {//если пользователь участник события
                        if ($request->photos) {
                            foreach ($request->file('photos', []) as $file) {
                                $event->mediaSave([
                                    'file' => $file,
                                ], 'images_users');
                            }

                            return response()->json(['message' => trans('system.event.photo.save')], Response::HTTP_ACCEPTED);
                        }
                    }
                }
            }
        }

        return response()->json(['message' => trans('system.event.photo.forbidden')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @api {delete} /api/v1/events/{id} 7. Удаление события
     * @apiVersion 1.0.0
     * @apiName EventDestroy
     * @apiGroup 20.События
     */
    public function destroy($id)
    {
        $event = Event::with('media', 'user', 'users')->findOrFail($id);

        if (Gate::allows('delete-event', $event)) {
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
            $event->favorites()->delete();
            $event->eventsful()->sync([]);
            $event->delete();

            return response()
                ->json(['message' => trans('system.destroy.success')], Response::HTTP_OK);
        }

        return response()->json(['message' => trans('system.destroy.error')], Response::HTTP_FORBIDDEN);
    }

    /**
     * @api {post} /api/v1/events/{id}/deleteUser 8. Удаление участников события
     * @apiVersion 1.0.0
     * @apiName EventUsersDestroy
     * @apiGroup 20.События
     * @apiParam {Array} users Пользователи которых нужно удалить
     */
    public function deleteUser($id, Request $request)
    {
        $event = Event::with('users', 'user')->findOrFail($id);

        if (Gate::allows('update-event', $event)) {
            foreach ($request->users as $userDel) {
                $event->users()->detach($userDel['id']);
                $event->eventsful()->detach($userDel['id']);

                return response()
                    ->json(['message' => trans('system.destroy.success')], Response::HTTP_OK);
            }
        }
    }

    /**
     * @api {get} /api/v1/users/{id}/events 10. Получение событий юзера
     * @apiVersion 1.0.0
     * @apiName UserEvents
     * @apiGroup 20.События
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function getUserEvents($id, Request $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $events = Event::with('media', 'user', 'users', 'shares')
            ->where('user_id', $user->id)
            ->orderBy('nearly')
            ->paginate($request->per_page);

        return EventResource::collection($events);
    }

    /**
     * @api {get} /api/v1/events/{id}/comments 9. Получение коментариев к событию
     * @apiVersion 1.0.0
     * @apiName getEventComment
     * @apiGroup 20.События
     */
    public function getEventComments($id)
    {
        $event = Event::findOrFail($id);
        $comments = Comment::getChildTreeArray($event->comments()->with('user')->withCount('likes')->orderBy('created_at')->get());

        return CommentResource::collection($comments);
    }

    /**
     * @api {post} /api/v1/events/{id}/comment 11. Добавить коментарий к событию
     * @apiVersion 1.0.0
     * @apiName CommentAdd
     * @apiGroup 20.События
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} text Текст коментария
     */
    public function comment($id, CommentAddRequest $request)
    {
        $event = Event::findOrFail($id);
        $user = $request->user();

        if (!$event->allowComment()) {
            return response()->json(['message' => trans('system.comment.permission')], Response::HTTP_BAD_REQUEST);
        }

        $comment = $event->comments()->create([
            'user_id' => $user->id,
            'text' => $request->text,
        ]);

        //коментарий к своей записи
        if ($comment->commentable->user_id != $user->id) {
            Notification::send($event->user, new NewComment($event, $comment));
            $event->notifies()->create([
                'user_id' => $user->id,
                'type' => Notify::TYPE_COMMENT,
                'text' => trans('notification.comment.add'),
            ]);
        }

        return response()->json(['message' => trans('system.comment.save'), 'comment' => CommentResource::make($comment)], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/events/{id}/favorite 13. Добавить/удалить из избранного
     * @apiVersion 1.0.0
     * @apiName Favorites
     * @apiGroup 20.События
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function favorite($id)
    {
        /** @var User $user */
        $user = auth()->user();
        $event = Event::findOrFail($id);

        if ($user->hasFavoriteEvent($event)) {
            $event->favorites()->delete();

            return response()->json(['message' => trans('system.favorite.remove')], Response::HTTP_OK);
        }

        $event->favorites()->create(['user_id' => $user->id]);

        return response()->json(['message' => trans('system.favorite.add')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/events/{id}/share 14. Поделиться событием
     * @apiVersion 1.0.0
     * @apiName ShareEvent
     * @apiGroup 20.События
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function share($id, Request $request)
    {
        $event = Event::with('user')->findOrFail($id);
        $user = auth()->user();

        if ($user->isMainEvent($event)) {
            return response()->json(['message' => trans('system.share.self')], Response::HTTP_BAD_REQUEST);
        }

        if ($user->hasShareEvent($event)) {
            return response()->json(['message' => trans('system.event.share.already')], Response::HTTP_OK);
        }

        $share = $event->shares()->create([
            'user_id' => $user->id,
            'description' => $request->description,
        ]);

        Notification::send($event->user, new NewShare($event, $share));
        $event->notifies()->create([
            'user_id' => $user->id,
            'type' => Notify::TYPE_SHARE,
            'text' => trans('notification.event.share.add'),
        ]);

        $event->timelines()->updateOrCreate([
            'user_id' => $user->id,
            'type' => Timeline::TYPE_SHARE,
            'description' => $request->description,
        ]);

        return response()
            ->json(['message' => trans('system.event.share.success')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/events/{id}/complaint 15. Пожаловаться на событие
     * @apiVersion 1.0.0
     * @apiName ComplaintEvent
     * @apiGroup 20.События
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     * @apiParam {String} complaint_text Текст жалобы
     * @apiParam {String} theme Тема жалобы
     *
     * * @apiDescription Жалобу можно писать не чаще чем через 24 часа
     */
    public function complaint($id, PostComplaintRequest $request)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();
        $admin = User::where('role', User::ROLE_ADMIN)->first();

        if ($user->hasComplaintEvent($event)) {
            return response()->json(['message' => trans('system.complaint.already')], Response::HTTP_BAD_REQUEST);
        }

        $complaint = $event->complaints()->create([
            'user_id' => $user->id,
            'complaint_text' => $request->complaint_text,
            'theme' => $request->theme,
        ]);

        Notification::send($admin, new EventComplaint($event, $complaint));

        return response()
            ->json(['message' => trans('system.complaint.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {post} /api/v1/events/{id}/like 16. Лайкнуть событие
     * @apiVersion 1.0.0
     * @apiName LikeAdd
     * @apiGroup 20.События
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getLike($id)
    {
        $event = Event::with('user')->findOrFail($id);
        $user = auth()->user();

        if ($user->hasLikedEvent($event)) {
            $event->likes()->delete();

            return response()
                ->json(['message' => trans('system.like.delete')], Response::HTTP_OK);
        }

        $like = $event->likes()->create(['user_id' => $user->id]);
        Notification::send($event->user, new NewLike($event, $like, $user));
        $event->notifies()->create([
            'user_id' => $user->id,
            'type' => Notify::TYPE_LIKE,
            'text' => trans('notification.event.like.add'),
        ]);

        return response()
            ->json(['message' => trans('system.like.save')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/events/{id}/statuses 17. Изменить статус участников события
     * @apiVersion 1.0.0
     * @apiName StatusChange
     * @apiGroup 20.События
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *          "changed": [
     *           {
     *               "user_id": 231,
     *               "user_status": false
     *           },
     *           {
     *               "user_id": 453,
     *               "user_status": false
     *           }
     *          ]
     *     }
     */
    public function changeStatus($id, EventUserStatusRequest $request)
    {
        $event = Event::with('users')->findOrFail($id);
        if (Gate::allows('update-event', $event)) {
            foreach ($request->get('changed', []) as $item) {
                if (!empty($item['user_id'])) {
                    $event->users()->updateExistingPivot($item['user_id'], Arr::only($item, ['user_status']));
                    Notification::send($event->users->where('id', $item['user_id']), new ChangeStatus($event, $item));

                    $event->notifies()->create([
                        'user_id' => $item['user_id'],
                        'type' => Notify::TYPE_STATUS,
                        'text' => trans('notification.event.status.body'),
                    ]);
                }
            }

            return response()
                ->json(['message' => trans('system.event.user.status')], Response::HTTP_OK);
        }

        return response()->json(Response::HTTP_FORBIDDEN);
    }

    /**
     * @api {post} /api/v1/events/{id}/attend 18. Отправить заявку на событие, (Я иду, Я не иду)
     * @apiVersion 1.0.0
     * @apiName EventAttend
     * @apiGroup 20.События
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function attend($id, Request $request)
    {
        $event = Event::with('user', 'users')->findOrFail($id);
        $user = $request->user();

        if ($user->isMainEvent($event)) {
            return response()
                ->json(['message' => trans('system.event.attend.self')], Response::HTTP_BAD_REQUEST);
        }

//        if ($event->isClose()) {
//            return response()
//                ->json(['message' => trans('system.event.attend.close')], Response::HTTP_BAD_REQUEST);
//        }

        if ($user->hasApplicationSend($event)) {
            if ($event->getEventUserStatus($user) === Event::STATUS_USER_WAITING) {
                $event->users()->detach($user->id);
                $event->eventsful()->detach($user->id);
                $event->notifies()->delete();

                return response()
                    ->json(['message' => trans('system.event.attend.annulment')], Response::HTTP_OK);
            }

            if ($event->getEventUserStatus($user) === Event::STATUS_USER_ALLOWED) {
                $event->users()->detach($user->id);
                $event->eventsful()->detach($user->id);
                $event->notifies()->delete();

                return response()
                    ->json(['message' => trans('system.event.attend.cancel')], Response::HTTP_OK);
            }
        }

        if ($event->isOpen()) {
            if ($event->confirm_user) {
                $event->users()->attach($user->id, [
                    'user_status' => Event::STATUS_USER_ALLOWED,
                ]);

                Notification::send($event->user, new NewParticipant($event, $user));
                $event->notifies()->create([
                    'user_id' => $user->id,
                    'type' => Notify::TYPE_ATTEND,
                    'text' => trans('notification.event.application.participant'),
                ]);

                $event->eventsful()->attach($user->id, [
                    'type' => Event::TYPE_ATTEMPT,
                ]);

                return response()
                    ->json(['message' => trans('system.event.attend.participant')], Response::HTTP_OK);
            }

            $event->eventsful()->attach($user->id, [
                'type' => Event::TYPE_ATTEMPT,
            ]);

            $event->users()->attach($user->id, [
                'user_status' => Event::STATUS_USER_WAITING,
            ]);

            Notification::send($event->user, new NewParticipant($event, $user));
            $event->notifies()->create([
                'user_id' => $user->id,
                'type' => Notify::TYPE_ATTEND,
                'text' => trans('notification.event.application.title'),
            ]);

            return response()
                ->json(['message' => trans('system.event.attend.success')], Response::HTTP_OK);
        }
    }

    /**
     * @api {get} /api/v1/events/{id}/users-all 20. Получить всех пользователей к событию
     * @apiVersion 1.0.0
     * @apiName EventUsers
     * @apiGroup 20.События
     * @apiDescription Получить всех пользователей к событию з статусом waiting и forbidden
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function allUsers($id)
    {
        $event = Event::with('users')->findOrFail($id);

        return response()->json([
            'users' => $event->getForbiddenUsers(),
        ]);
    }

    /**
     * @api {get} /api/v1/events/slider 19. Получение событий в слайдере
     * @apiVersion 1.0.0
     * @apiName EventShow
     * @apiGroup 20.События
     *
     * @apiDescription Получение событий которые добавили в слайдер.
     */
    public function slider()
    {
        $events = Event::with('media', 'user', 'users')->withCount('likes', 'comments')->where('to_slider', true)->get();

        return EventResource::collection($events);
    }
}
