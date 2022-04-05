<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentAddRequest;
use App\Http\Requests\BlogCommentUpdateRequest;
use App\Http\Requests\Complaint\PostComplaintRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Notify;
use App\Notifications\Comment\CommentComplaint;
use App\Notifications\Post\CommentResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{
    /**
     * @api {post} /api/v1/comments/{id} 1. Добавить ответ к коментрарию
     * @apiVersion 1.0.0
     * @apiName CommentAdd
     * @apiGroup 10.Коментарий
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {int} [parent_id] Id родительского коментария (если нет радителя - <code>null</code>)
     * @apiParam {String} text Текст коментария
     */
    public function store(BlogCommentAddRequest $request, $id)
    {
        $user = $request->user();
        $comment = Comment::with('user')->findOrFail($id);
        $commentResponse = $comment->children()->create([
            'user_id' => $user->id,
            'text' => $request->text,
            'commentable_id' => $comment->commentable_id,
            'commentable_type' => $comment->commentable_type,
        ]);

        Notification::send($comment->user, new CommentResponse($comment, $commentResponse));
        $comment->notifies()->create([
            'user_id' => $user->id,
            'type' => Notify::TYPE_COMMENT_RESPONSE,
            'text' => trans('notification.comment.response'),
        ]);

        return response()->json(['message' => trans('system.comment.save'), 'comment' => CommentResource::make($comment)]);
    }

    /**
     * @api {put/patch} /api/v1/comments/{id} 2. Обновить свой коментарий
     * @apiVersion 1.0.0
     * @apiName CommentUpdate
     * @apiGroup 10.Коментарий
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} text Текст коментария
     */
    public function update($id, BlogCommentUpdateRequest $request)
    {
        $comment = Comment::with('user')->withCount('likes')->findOrFail($id);

        if (Gate::denies('update-comment', $comment)) {
            return response()->json(['message' => trans('system.comment.denies')], Response::HTTP_FORBIDDEN);
        }
        $comment->update([
            'text' => $request->text,
        ]);

        return response()->json(['message' => trans('system.comment.update'), 'comment' => CommentResource::make($comment)], Response::HTTP_OK);
    }

    /**
     * @api {delete} /api/v1/comments/{id} 3. Удалить свой коментарий
     * @apiVersion 1.0.0
     * @apiName CommentDelete
     * @apiGroup 10.Коментарий
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (Gate::denies('delete-comment', $comment)) {
            return response()->json(['message' => trans('system.comment.denies')], Response::HTTP_FORBIDDEN);
        }

        $comment->delete();

        return response()->json(['message' => trans('system.comment.delete')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/comments/{id}/like 10. Лайкнуть сущность
     * @apiVersion 1.0.0
     * @apiName LikeAdd
     * @apiGroup 06.Блог
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getLike(Request $request, Comment $comment)
    {
        $user = $request->user();

        if ($user->hasLikedComment($comment)) {
            $comment->likes()->delete();

            return response()
                ->json(['message' => trans('system.like.delete')], Response::HTTP_OK);
        }

        $comment->likes()->create(['user_id' => $user->id]);

        return response()
            ->json(['message' => trans('system.like.save')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/comments/{id}/complaint 6. Пожаловаться на комментарий
     * @apiVersion 1.0.0
     * @apiName ComplaintComment
     * @apiGroup 10.Коментарий
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     * @apiParam {String} complaint_text Текст жалобы
     * @apiParam {String} theme Тема жалобы
     *
     * * @apiDescription Жалобу можно писать не чаще чем через 24 часа
     */
    public function complaint($id, PostComplaintRequest $request)
    {
        $comment = Comment::findOrFail($id);
        $user = $request->user();

        if ($user->hasComplaintComment($comment)) {
            return response()->json(['message' => trans('system.complaint.already')], Response::HTTP_BAD_REQUEST);
        }

        $complaint = $comment->complaints()->create([
            'user_id' => $user->id,
            'complaint_text' => $request->complaint_text,
            'theme' => $request->theme,
        ]);

        Notification::send($complaint->user, new CommentComplaint($comment, $complaint));

        return response()
            ->json(['message' => trans('system.complaint.success')], Response::HTTP_CREATED);
    }
}
