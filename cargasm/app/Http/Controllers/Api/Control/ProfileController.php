<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Resources\Control\ProfileEditResource;
use App\Http\Resources\Control\ProfileShowResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * @api {get} /api/v1/control/profile/me 01. Данные профиля
     * @apiVersion 1.0.0
     * @apiName GetProfileMe
     * @apiGroup 40.Данные профиля
     */
    public function me(Request $request)
    {
        return new ProfileShowResource($request->user()->load('media'));
    }

    /**
     * @api {get} /api/v1/control/profile 02. Редактировать
     * @apiVersion 1.0.0
     * @apiName GetProfileEdit
     * @apiGroup 40.Данные профиля
     */
    public function edit(Request $request)
    {
        return new ProfileEditResource($request->user()->load('media'));
    }

    /**
     * @api {post} /api/v1/control/profile 03. Сохранить
     * @apiVersion 1.0.0
     * @apiName PostProfileUpdate
     * @apiGroup 40.Данные профиля
     *
     * @apiParam {String} name Имя
     * @apiParam {String} nickname Ник
     * @apiParam {String} [phone] Тел.
     * @apiParam {String} email Email
     * @apiParam {String} [password] Пароль
     * @apiParam {String} [password_confirmation] Подтверждение пароля
     *
     * @apiParam {Array} avatar Изображение
     * @apiParam {Array} media_deleted ID удаления media
     *
     * @apiParamExample {json} Request-Example:
     * "avatar": {
     *        "id": null,
     *        "file": "<BINARY FILE>",
     *        "title": "File title",
     *        "alt": "File alt",
     *        "is_active": true,
     *        "is_main": false,
     *        "delete": false,
     * }
     */
    public function save(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string',
            'nickname' => 'required|string',
            'email' => 'required|email|unique:users,id,' . $user->id,
            'phone' => 'sometimes|string|unique:users,id,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar.file' => 'nullable|mimes:jpeg,jpg,png',
        ]);

        /** @var User $user */
        if ($request->password) {
            $user->update($request->only('name', 'nickname', 'email', 'phone', 'password'));
        } else {
            $user->update($request->only('name', 'nickname', 'email', 'phone'));
        }

        $user->mediaManage($request);

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_ACCEPTED);
    }
}
