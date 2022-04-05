<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Control\UserRequest;
use App\Http\Requests\Control\UserUpdateRequest;
use App\Http\Requests\SyncRequest;
use App\Http\Resources\Control\UserEditResource;
use App\Http\Resources\Control\UserResource;
use App\Models\Domain;
use App\Models\User;
use App\Services\User\UserManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @api {post} /api/v1/control/users 01. Список
     * @apiVersion 1.0.0
     * @apiName GetUserIndex
     * @apiGroup 35.Пользователи
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page] Количество элементов на странице
     * @apiParam {String=id,name,role,phone,email,created_at,status} [sort=created_at] Поле для сортировки
     * @apiParam {String=asc,desc} [direction=desc] Направление сортировки
     *
     * @apiParam {String} [q] Поисковый запрос
     */
    public function index(Request $request)
    {
        $this->authorize('user-manage');

        $users = User::sortable('created_at')->filterable()->searchable()
            ->paginate($request->per_page);

        return UserResource::collection($users)
            ->additional([
                'form' => $this->getFormAdditional(),
            ]);
    }

    /**
     * @api {get} /api/v1/control/users/create 02. Создать
     * @apiVersion 1.0.0
     * @apiName GetUserCreate
     * @apiGroup 35.Пользователи
     */
    public function create()
    {
        return response()->json([
            'form' => $this->getFormAdditional(),
        ]);
    }

    /**
     * @api {post} /api/v1/control/users 03. Сохранить
     * @apiVersion 1.0.0
     * @apiName PostUserStore
     * @apiGroup 35.Пользователи
     *
     * @apiParam {String} email Email
     * @apiParam {String} name Имя
     * @apiParam {String} nickname Nickname
     * @apiParam {String} phone Телефон (основной телефон пользователя, используется для входа)
     * @apiParam {String} about О себе
     * @apiParam {Array} [phones] Телефоны (дополнительные телефоны)
     * @apiParam {Array} [social] Соц. сети
     * @apiParam {Array} [notice] Уведомление
     * @apiParam {Array} privacy Приватность
     * @apiParam {String} [password] Новый пароль
     * @apiParam {String} [password_confirmation] Подтверждение нового пароля
     * @apiParam {String} status Статус пользователи
     * @apiParam {String} role Роль пользователя (тип)
     * @apiParam {String} [msg_reject] Комментарий (для модерации)
     * @apiParam {Array} avatar Аватар
     * @apiParam {Array} media_deleted ID удаления media
     * @apiParam {string} email_verified_at Верифицировать пользователя
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
     *          "social": {
     *              "ok": "",
     *              "facebook": "https://www.facebook.com"
     *              "vk": "https://www.vk.com/name"
     *              "youtube": ""
     *          }
     *          "privacy": {
     *              "fio": false,
     *              "phone": false,
     *              "email": false,
     *              "social": true,
     *          },
     *          "avatar": {
     *                 "id": null,
     *                 "file": "<BINARY FILE>",
     *                 "title": "File title",
     *                 "alt": "File alt",
     *                 "is_active": true,
     *                 "is_main": false,
     *                 "delete": false,
     *          },
     *          "status": "approved",
     *          "role": "user",
     *          "msg_reject": "Ваш аккаунт успешно промодерирован!",
     *     }
     */
    public function store(UserRequest $request)
    {
        $this->authorize('user-manage');

        /** @var User $user */
        $user = User::create($request->only([
            'email', 'name', 'nickname', 'about', 'phone', 'social',
            'notice', 'privacy', 'status', 'role', 'msg_reject', 'password',
        ]) + ['email_verified_at' => now()]);

        $user->mediaManage($request);
        //$user->mediaSave($request->input('avatar', []), 'avatar');
        //UserManager::addMainPhoto($request, $user);
        UserManager::addPhones($request, $user);

        return response()
            ->json(['message' => trans('system.user.update')], Response::HTTP_ACCEPTED);
    }

    /**
     * @api {get} /api/v1/control/users/{userId}/edit 04. Редактировать
     * @apiVersion 1.0.0
     * @apiName GetUserEdit
     * @apiGroup 35.Пользователи
     */
    public function edit(User $user)
    {
        $this->authorize('user-manage');

        return (new UserEditResource($user->load('media')))
            ->additional([
                'form' => $this->getFormAdditional(),
            ]);
    }

    /**
     * @api {patch} /api/v1/control/users/{userId} 05. Обновить
     * @apiVersion 1.0.0
     * @apiName PatchUserUpdate
     * @apiGroup 35.Пользователи
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('user-manage');

        $data = $request->only([
            'email', 'name', 'nickname', 'about', 'phone', 'social',
            'notice', 'privacy', 'status', 'role', 'msg_reject',
        ]);
        if ($request->email_verify_at) {
            $data['email_verify_at'] = now();
        }
        if ($request->password) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        //$user->mediaSave($request->input('avatar', []), 'avatar');
        $user->mediaManage($request);
        UserManager::addPhones($request, $user);

        return response()
            ->json(['message' => trans('system.user.update')], Response::HTTP_ACCEPTED);
    }

    /**
     * @api {delete} /api/v1/control/users/{userId} 06. Удалить
     * @apiVersion 1.0.0
     * @apiName DeleteUserDestroy
     * @apiGroup 35.Пользователи
     */
    public function destroy(User $user)
    {
        $this->authorize('user-manage');

        $user->delete();

        return response()
            ->json(['message' => trans('system.actions.destroy.success')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/control/users/sync 07. Синхронизация записей
     * @apiVersion 1.0.0
     * @apiName PostUserSync
     * @apiGroup 35.Пользователи
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
        $this->authorize('user-manage');

        if ($request->deleted) {
            User::whereIn('id', $request->deleted)->where('id', '<>', $request->user()->id)->delete();
        }

        if ($request->changed) {
            foreach ($request->changed as $item) {
                if (isset($item['id']) && ($model = user::find($item['id']))) {
                    //$model->update(\Arr::only($item, 'is_active'));
                }
            }
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')])
            ->setStatusCode(\Illuminate\Http\Response::HTTP_OK);
    }

    protected function getFormAdditional(): array
    {
        return [
            'roles' => User::rolesList(),
            'statuses' => User::statusesList(),
            //            'domains' => Domain::all()->mapWithKeys(function ($d) {
            //                return [$d->url => $d->url];
            //            })
        ];
    }
}
