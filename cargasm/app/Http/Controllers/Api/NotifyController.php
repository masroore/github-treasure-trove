<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotifyResource;
use App\Models\Notify;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @api {get} /api/v1/notifies 1. Все нотификации для текущего пользователя
     * @apiVersion 1.0.0
     * @apiName AllNotification
     * @apiGroup 25.Нотификации
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiDescription Типы нотификаций
     *
     * @apiParam {String} message Новое сообщение
     * @apiParam {String} like Новый лайк
     * @apiParam {String} share Поделились записью
     * @apiParam {String} change Изменение записи (события)
     * @apiParam {String} moderate Отправлено на модерацию
     * @apiParam {String} published Статус опубликован
     * @apiParam {String} comment Новый комментарий
     * @apiParam {String} comment_response Ответ на ваш коментарий
     * @apiParam {String} subscriber Новый подписчик
     * @apiParam {String} status Изменено статус участника события
     * @apiParam {String} attend Отправлено заявку на участвие в событии
     * @apiParam {String} begin Начало события
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = Notify::with('user', 'notifiable')->whereHasMorph('notifiable', '*', function (Builder $query) use ($user): void {
            $query->where('user_id', $user->id);
        })
            ->orderByDesc('created_at')
            ->get();

        return NotifyResource::collection($notifications);
    }

    /**
     * @api {post} /api/v1/notifies/delete 7. Удаление нотификаций
     * @apiVersion 1.0.0
     * @apiName AllNotification
     * @apiGroup 25.Нотификации
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function deleteAll(Request $request)
    {
        $ids = $request->notifes_id;
        $notifies = Notify::whereIn('id', $ids)->get();
        foreach ($notifies as $notify) {
            $notify->delete();
        }

        return response()
            ->json(['message' => trans('system.destroy.success')], Response::HTTP_OK);
    }
}
