<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Complaint\UserComplaintRequest;
use App\Http\Requests\UserEntityCount;
use App\Http\Requests\UserPasswordRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserSettingsRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\UserForPageResource;
use App\Http\Resources\UserResource;
use App\Models\Car;
use App\Models\Event;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use App\Notifications\Post\NewComment;
use App\Notifications\UserComplaint;
use App\Services\User\UserManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['show']);
    }

    /**
     * @api {get} /api/v1/user 1. Получить данные текущего пользователя
     * @apiVersion 1.0.0
     * @apiName UserMe
     * @apiGroup 09.Пользователь
     * @apiDescription Полученние всех данных авторизированого пользователя
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function index()
    {
        $user = User::with('media', 'subscriptions', 'subscribers', 'phones')
            ->with(['cars' => function ($q): void {
                $q->where('status', Car::STATUS_PUBLISHED);
            }])
            ->findOrFail(auth()->user()->id);

        return UserResource::make($user);
    }

    /**
     * @api {get} /api/v1/users 11. Получение всех пользователей
     * @apiVersion 1.0.0
     * @apiName UsersAll
     * @apiGroup 09.Пользователь
     * @apiDescription Полученние всех данных авторизированых пользователей
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getAllUsers(Request $request)
    {
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

        return response()->json(['users' => AuthorResource::collection($users)]);
    }

    /**
     * @api {get} /api/v1/users/{id} 2. Получить данные пользователя
     * @apiVersion 1.0.0
     * @apiName UserGetWithId
     * @apiGroup 09.Пользователь
     * @apiDescription Полученние данных пользователя
     */
    public function show($id)
    {
        /** @var User $user */
        $user = User::with('media', 'subscriptions', 'subscribers', 'phones', 'cars')
            ->with(['cars' => function ($q): void {
                $q->where('status', Car::STATUS_PUBLISHED);
            }])
            ->findOrFail($id);

        return UserForPageResource::make($user);
    }

    /**
     * @api {post} /api/v1/user 3. Обновить данные авторизованного пользователя
     * @apiVersion 1.0.0
     * @apiName UserUpdate
     * @apiGroup 09.Пользователь
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {File} main_photo Главное фото профиля
     * @apiParam {String} email Email
     * @apiParam {String} name Имя
     * @apiParam {String} nickname Nickname
     * @apiParam {String} phone Телефон (основной телефон пользователя, используется для входа)
     * @apiParam {String} about О себе
     * @apiParam {Array} [phones] Телефоны (дополнительные телефоны)
     * @apiParam {Array} [social] Соц. сети
     * @apiParam {Array} [social] Адрес
     * @apiParam {Array} [notice] Уведомление
     * @apiParam {Array} privacy Приватность
     * @apiParam {String} [old_password] Старый пароль
     * @apiParam {String} [password] Новый пароль
     * @apiParam {String} [password_confirmation] Подтверждение нового пароля
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *          "phone": "0679999999"
     *          "phones": [
     *           {
     *               "phone": "0671111111"
     *           },
     *           {
     *               "phone": "0671111111"
     *           }
     *          ],
     *          "social": [
     *          {
     *              "name": "facebook",
     *              "link": "https://www.facebook.com"
     *          }
     *          ],
     *          "privacy": {
     *              "fio": false,
     *              "phone": false,
     *              "email": false
     *          },
     *          "address": [
     *              "location":
     *                  {
     *                      "lat" : "43" ,
     *                      "lng" : "45" ,
     *                   },
     *              "fullName": "fullName",
     *              "city": "NY",
     *              "country": "USA",
     *          ]
     *     }
     */
    public function store(UserRequest $request)
    {

        /** @var User $user */
        $user = auth()->user();

        $data = $request->only([
            'email', 'name', 'nickname', 'about', 'phone',
            'social', 'notice', 'privacy', 'address',
        ]);
        if ($request->password) {
            $data['password'] = $request->password;
        }
        $user->update($data);

        if ($request->hasFile('main_photo.file')) {
            $user->clearMediaCollection('avatar');
            $user->mediaSave([
                'file' => $request->main_photo['file'],
            ], 'avatar', true);
        }

        // dd($request->main_photo);

        if (!$request->main_photo) {
            $user->clearMediaCollection('avatar');
        }

        // if(!$request->hasFile('main_photo.file')) {
        //     $user->clearMediaCollection('avatar');
        // }

        UserManager::addPhones($request, $user);
        $user->load('cars');
        $user = $user->refresh();

        return response()->json(['message' => trans('system.user.update'), 'user' => UserResource::make($user)], Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/user/authors 4. Получить список авторов юзера
     * @apiVersion 1.0.0
     * @apiName UserGetAuthor
     * @apiGroup 09.Пользователь
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getAuthors()
    {
        /** @var User $user */
        $user = auth()->user();
        //$authors = [];

        //if ($user->role == User::ROLE_PARTNER || $user->role == User::ROLE_ADMIN) {
        $services = $user->services()->where('status', Service::SERVICE_PUBLISHED)->get();

        $authors = $services->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'main_photo' => $item->getAllConversions(),
                'type' => ($item->getTable() === 'users') ? 'user' : 'service',
            ];
        })->toArray();

        array_unshift($authors, [
            'id' => $user->id,
            'name' => $user->name,
            'nickname' => $user->nickname,
            'main_photo' => $user->getAllConversions(),
            'type' => 'user',
        ]);
        //}

        return response()->json(['data' => $authors], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/users/{id}/ban 5. Добавить пользователя в бан
     * @apiVersion 1.0.0
     * @apiName bannedUsers
     * @apiGroup 09.Пользователь
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function ban($id)
    {
        /** @var User $user */
        $user = auth()->user();
        $banUser = User::findOrFail($id);

        if ($user->checkBanUser($banUser->id)) {
            return response()->json(['message' => trans('system.ban.already')], Response::HTTP_BAD_REQUEST);
        }

        $user->banUsers()->create([
            'ban_user_id' => $banUser->id,
        ]);

        return response()->json(['message' => trans('system.ban.success')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/users/{id}/unban 6. Розбанить юзера
     * @apiVersion 1.0.0
     * @apiName unbanedUsers
     * @apiGroup 09.Пользователь
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function unban($id)
    {
        /** @var User $user */
        $user = auth()->user();
        $unbanUser = User::findOrFail($id);

        if (!$user->checkBanUser($unbanUser->id)) {
            return response()->json(['message' => trans('system.ban.not-banned')], Response::HTTP_BAD_REQUEST);
        }

        $user->banUsers()->where('ban_user_id', $unbanUser->id)->first()->delete();

        return response()->json(['message' => trans('system.ban.delete')], Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/users/banned 7. Получить забаненых юзеров
     * @apiVersion 1.0.0
     * @apiName getBannedUser
     * @apiGroup 09.Пользователь
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getBannedUsers()
    {
        /** @var User $user */
        $user = auth()->user();
        $bannedUsers = $user->banUsers()->with('banUserData')->has('banUserData')->orderByDesc('created_at')->get();

        $result = $bannedUsers->map(function ($item, $key) {
            return [
                'id' => $item->banUserData->id,
                'name' => $item->banUserData->name,
                'main_photo' => $item->banUserData->getAllConversions(),
                'type' => 'user',
            ];
        });

        return response()->json(['data' => $result], Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/user/entity/quantity 8. Получить количесто постов/сервисов
     * @apiVersion 1.0.0
     * @apiName getEntityCount
     * @apiGroup 09.Пользователь
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     * @apiParam {String} type Значение <code>post, service, car</code>
     */
    public function getCountEntity(UserEntityCount $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($request->type === 'post') {
            $result = [
                Post::POST_PUBLISHED => 0,
                Post::POST_MODERATE => 0,
                Post::POST_REJECTED => 0,
                Post::POST_DRAFT => 0,
                Post::POST_UNPUBLISHED => 0,
            ];
            /** @var Post $posts */
            $posts = Post::select(DB::raw('count(*) as post_count, status'))->where('user_id', $user->id)->groupBy('status')->get();

            foreach ($posts as $post) {
                foreach ($result as $key => $value) {
                    if ($post->status === $key) {
                        $result[$post->status] = $post->post_count;
                    }
                }
            }
        } elseif ($request->type === 'service') {
            $result = [
                Service::SERVICE_PUBLISHED => 0,
                Service::SERVICE_MODERATE => 0,
                Service::SERVICE_REJECTED => 0,
                Service::SERVICE_DRAFT => 0,
            ];

            /** @var Service $service */
            $services = Service::select(DB::raw('count(*) as service_count, status'))->where('user_id', $user->id)->groupBy('status')->get();

            foreach ($services as $service) {
                foreach ($result as $key => $value) {
                    if ($service->status === $key) {
                        $result[$service->status] = $service->service_count;
                    }
                }
            }
        } else {
            $result = [
                Car::STATUS_PUBLISHED => 0,
                Car::STATUS_MODERATE => 0,
            ];

            /** @var Service $service */
            $cars = Car::select(DB::raw('count(*) as car_count, status'))->where('user_id', $user->id)->groupBy('status')->get();

            foreach ($cars as $car) {
                foreach ($result as $key => $value) {
                    if ($car->status === $key) {
                        $result[$car->status] = $car->car_count;
                    }
                }
            }
        }

        return response()->json(['data' => $result], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/user/setting 9.Настройка уведомлений пользователя
     * @apiVersion 1.0.0
     * @apiName UserSetting
     * @apiGroup 09.Пользователь
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {Array} [settings] Настройки
     * @apiParam {Array} new_message Получение новых сообщений
     * @apiParam {Array} blog_comment Новые комментарии к вашей записи
     * @apiParam {Array} blog_comment_response Ответ на ваш комментарий
     * @apiParam {Array} blog_subscribe Добавление нового подписчика
     * @apiParam {Array} blog_like Отметки «Нравится»
     * @apiParam {Array} blog_share Кто-то поделился вашей записью
     * @apiParam {Array} event_new_participant Новый участник события
     * @apiParam {Array} event_reminder Напоминание о предстоящем событии
     * @apiParam {Array} event_comment Новые комментарии к вашей записи
     * @apiParam {Array} event_comment_response Ответ на ваш комментарий
     * @apiParam {Array} event_begin Начало события
     * @apiParam {Array} event_cancel Отмена события
     * @apiParam {Array} event_change Изменения данных события
     * @apiParam {Array} event_share Кто-то поделился вашим событием
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *          "settings": [
     *              "new_message":
     *                  {
     *                      "email" : true ,
     *                      "site" : false ,
     *                  },
     *              "blog": {
     *                      "comment":
     *                      {
     *                          "email" : true ,
     *                          "site" : false ,
     *                      },
     *                      "comment_response":
     *                      {
     *                          "email" : true ,
     *                          "site" : false ,
     *                      },
     *                      "like":
     *                      {
     *                          "email" : true ,
     *                          "site" : false ,
     *                      },
     *                      "share":
     *                      {
     *                          "email" : true ,
     *                          "site" : false ,
     *                      },
     *
     *                  },
     *
     *              "event" : {
     *                  "like":
     *                      {
     *                          "email" : true ,
     *                          "site" : true ,
     *                      },
     *                  "new_participant":
     *                  {
     *                      "email" : true ,
     *                      "site" : false ,
     *                  },
     *                  "reminder":
     *                  {
     *                      "email" : true ,
     *                      "site" : false ,
     *                  },
     *                  "comment":
     *                  {
     *                      "email" : true ,
     *                      "site" : false ,
     *                  },
     *                  "comment_response":
     *                  {
     *                      "email" : true ,
     *                      "site" : false ,
     *                  },
     *                  "begin":
     *                  {
     *                      "email" : true ,
     *                      "site" : false ,
     *                  },
     *                  "cancel":
     *                  {
     *                      "email" : true ,
     *                      "site" : false ,
     *                  },
     *                  "change":
     *                  {
     *                      "email" : true ,
     *                      "site" : false ,
     *                  },
     *                  "share":
     *                  {
     *                      "email" : true ,
     *                      "site" : false ,
     *                  },
     *              }
     *          ]
     *     }
     */
    public function setting(UserSettingsRequest $request)
    {
        /** @var User $user */
        $user = $request->user();
        $data = $request->only('settings');
        $user->update($data);

        $user = $user->refresh();

        return response()->json(['message' => trans('system.user.update'), 'settings' => $user->settings], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/user/password 10. Обновить пароль авторизованного пользователя
     * @apiVersion 1.0.0
     * @apiName UserUpdate
     * @apiGroup 09.Пользователь
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     * @apiParam {String} [old_password] Старый пароль
     * @apiParam {String} [password] Новый пароль
     * @apiParam {String} [password_confirmation] Подтверждение нового пароля
     */
    public function password(UserPasswordRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($request->password) {
            $user->password = $request->password;
            $user->update();
            $user = $user->refresh();

            return response()->json(['message' => trans('system.user.update')], Response::HTTP_OK);
        }
        // return response()->json(['message' => trans('system.user.update')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/users/{id}/complaint 11. Пожаловаться на пользователя
     * @apiVersion 1.0.0
     * @apiName ComplaintUser
     * @apiGroup 09.Пользователь
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     * @apiParam {String} complaint_text Текст жалобы
     * @apiParam {String} theme Тема жалобы
     *
     * * @apiDescription Жалобу можно писать не чаще чем через 24 часа
     */
    public function complaint($id, UserComplaintRequest $request)
    {
        $visitor = User::findOrFail($id);
        $user = auth()->user();

        if ($user->hasComplaintUser($visitor)) {
            return response()->json(['message' => trans('system.complaint.already')], Response::HTTP_BAD_REQUEST);
        }
        if ($user->id === $visitor->id) {
            return response()->json(['message' => trans('system.complaint.self')], Response::HTTP_BAD_REQUEST);
        }

        $complaint = $visitor->complaints()->create([
            'user_id' => $user->id,
            'complaint_text' => $request->complaint_text,
            'theme' => $request->theme,
        ]);

        Notification::send($visitor, new UserComplaint($visitor, $complaint));

        return response()
            ->json(['message' => trans('system.complaint.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {post} /api/v1/users/push 20. Разрешить нотификации
     * @apiVersion 1.0.0
     * @apiName NotificationUser
     * @apiGroup 09.Пользователь
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     * @apiParam {String} endpoint  endpoint
     * @apiParam {String} keys.auth Token
     * @apiParam {String} keys.p256dh  Key
     */
    public function push(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [
            'token' => 'required',
        ]);

        if ($request->token) {
            $user->update(['device_token' => $request->token]);
        }

        return response()->json(['message' => trans('system.notification.success')], Response::HTTP_OK);
    }

    public function pusher()
    {
        Notification::send(User::all(), new NewComment(Post::first()));

        return response()->json(['message' => trans('system.notification.success')], Response::HTTP_OK);
    }
}
