<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * @api {delete} /api/v1/control/comments/{id} 1. Удалить коментарий
     * @apiVersion 1.0.0
     * @apiName CommentDelete
     * @apiGroup 29.Коментарии
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function destroy($id)
    {
        $this->authorize('comment-manage');
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => trans('system.comment.delete')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/control/comments/sync 2. Синхронизация записей
     * @apiVersion 1.0.0
     * @apiName CommentsSync
     * @apiGroup 29.Коментарии
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
    public function sync(Request $request)
    {
        $this->authorize('comment-manage');

        if ($request->deleted) {
            Comment::whereIn('id', $request->deleted)->delete();
        }

        if ($request->changed) {
            foreach ($request->changed as $item) {
                if (isset($item['id']) && ($model = Comment::find($item['id']))) {
                    //$model->update(\Arr::only($item, 'is_active'));
                }
            }
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_OK);
    }
}
